<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
 * Copyright (C) 2005-2014 The phpMyProfiler project
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
*/

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'guestbook';

require_once('include/emoticons.php');
require_once('include/formkey.class.php');
require_once('Validate.php');

$formKey = new formKey();
$validate = new Validate();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Initialize the captcha object with our configuration options
if ( $pmp_guestbook_showcode == true) {
	require_once('include/b2evo_captcha/b2evo_captcha.config.php');
	require_once('include/b2evo_captcha/b2evo_captcha.class.php');

	$captcha = new b2evo_captcha($CAPTCHA_CONFIG);
	$imgLoc = $captcha->get_b2evo_captcha();
	$smarty->assign('imgLoc', $imgLoc);
}

dbconnect();

if ( (isset($_GET['action'])) && ($_GET['action'] == 'save') ) {
	// First check the form key
	if ( !isset($_POST['form_key']) || !$formKey->validate() ) {
		//Form key is invalid, show an error
	$smarty->assign('Failed', 'Form key error!');
	}
	else {
		$msg = array();

		// Check all values we get from contact form
		if ( $_POST['name'] != "" ) {
			$name = html2txt($_POST['name']);
		}
		else {
			$msg[]= 'Please enter your name!';
		}

		if ( $_POST['email'] != "" ) {
			$email = $_POST['email'];
			if ( !$validate->email($email, array('use_rfc822' => true)) ) {
				$msg[] = "$email is <strong>NOT</strong> a valid email address!";
			}
		}
		else {
			$msg[]= 'Please enter a valid email address!';
		}

		if ( $_POST['url'] != "" ) {
			$url = $_POST['url'];
			if ( !$validate->uri($url, array('use_rfc4151' => true)) ) {
				$msg[] = "$url is <strong>NOT</strong> a valid URL!";
			}
		}
		else {
			$url = '';
		}

		if ( $_POST['message'] != "" ) {
			$message = html2txt($_POST['message']);
		}
		else {
			$msg[]= 'Please enter a message to send!';
		}

		if ( count($msg) == 0 ) {
			// Check captcha
			if ( ($pmp_guestbook_showcode == true) && ($captcha->validate_submit($_POST['image'], $_POST['code']) == false) ) {
				$smarty->assign('Failed', t('Wrong security code!'));
			}
			// Make Bot-Check
			else if ( !empty($_POST['username']) ) {
				$smarty->assign('Failed', t('Bot Attack!'));
			}
			else {
				// Insert enty into db
				$query = sprintf('INSERT INTO pmp_guestbook (date, name, email, text, status, url)
					VALUES ( now(), \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')',
					mysql_real_escape_string( $name ),
					mysql_real_escape_string( $email ),
					mysql_real_escape_string( $message ),
					mysql_real_escape_string( $pmp_guestbook_activatenew ),
					mysql_real_escape_string( $url ) );

				if ( dbexec($query) ) {
					// Send info mail to admin
					str_replace(array("\r", "\n"), '', $email);
					str_replace(array("\r", "\n"), '', $name);
					$subject = '[phpMyProfiler] ' .  t('%name added a new guestbook entry', array('%name' => $name));
					$subject= mb_encode_mimeheader(html_entity_decode($subject, ENT_COMPAT, 'UTF-8'), "UTF-8", "B", "\n");

					$body = $name . ' <' . $email . '> ';
					if ( !empty($url)) {
						$body .= '[' . $url . '] ';
					}
					$body .= t('wrote') . ':' . "\n\n" . $message;

					$header = 'From: "' . $pmp_admin_name . '" <' . $pmp_admin_mail . '>' . "\r\n"
						. 'MIME-Version: 1.0' . "\r\n"
						. 'Content-Type: text/plain; charset="UTF-8"' . "\r\n"
						. 'Content-Transfer-Encoding: quoted-printable' . "\r\n"
						. 'Message-ID: <' . md5(uniqid(microtime())) . '@' . $_SERVER['SERVER_NAME'] . '>' . "\r\n"
						. 'X-Mailer: phpMyProfiler ' . $pmp_version . "\r\n";

					mail($pmp_admin_mail, $subject, $body, $header);

					$smarty->assign('Success', t('Thank you. The guest book entry was stored.'));

					// Clean values
					$_POST['name'] = '';
					$_POST['email'] = '';
					$_POST['url'] = '';
					$_POST['message'] = '';
				}
				else {
					$smarty->assign('Error', t('When storing in the database unfortunately an error occurs.'));
				}
			}
		}
		else {
			$smarty->assign('Failed', implode($msg, ' <br />'));
		}
	}
}

// Page selected?
if ( isset($_GET['page']) ) {
	if ( !is_numeric($_GET['page']) ) {
		$start = 1;
	}
	else {
		$start = $_GET['page'];
	}
}
else {
	$start = 1;
}

// Get total numbers of guestbook entries
$query = 'SELECT COUNT(id) AS num from pmp_guestbook WHERE status = 1';
$row = dbexec($query);
$count = mysql_result($row, 0, 'num');

// Get guestbook entries for one page
$query = 'SELECT name, email, date_format(date, \'' . $pmp_dateformat . '\') AS date, text, url, comment
	  FROM pmp_guestbook WHERE status != 0 ORDER BY id DESC LIMIT ' .
	  (((int)$start - 1) * $pmp_entries_side) . ", " . $pmp_entries_side;
$result = dbexec($query);

$i = 0;
$entries = array();
if ( mysql_num_rows($result) > 0 ) {
	while ( $row = mysql_fetch_object($result) ) {
		$row->nr = $count - $i++ - (((int)$start - 1) * $pmp_entries_side);
		$row->text = replace_emoticons($row->text);
		$row->comment = replace_emoticons($row->comment);
		$entries[] = $row;
	}
}

dbclose();

$smarty->assign('entries', $entries);
$smarty->assign('emoticons', array_unique($emoticons));
$smarty->assign('count', $count);
$smarty->assign('page', (int)$start);
$smarty->assign('pages', (int)($count / $pmp_entries_side + ((($count % $pmp_entries_side)==0)? 0 : 1)));
$smarty->assign('formkey', $formKey->outputKey());

$smarty->display('guestbook.tpl');
?>
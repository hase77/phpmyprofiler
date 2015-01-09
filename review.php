<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
 * Copyright (C) 2005-2015 The phpMyProfiler project
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
*/

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

// Check for id
if (!isset($_GET['id'])) {
    die('No id given!');
}

$pmp_module = 'review';

require_once('include/formkey.class.php');
require_once('Validate.php');

$formKey = new formKey();
$validate = new Validate();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Initialize the captcha object with our configuration options
if ( $pmp_guestbook_showcode == true ) {
	require_once('include/b2evo_captcha/b2evo_captcha.config.php');
	require_once('include/b2evo_captcha/b2evo_captcha.class.php');

	$captcha = new b2evo_captcha($CAPTCHA_CONFIG);
	$imgLoc = $captcha->get_b2evo_captcha();
	$smarty->assign('imgLoc', $imgLoc);
}

dbconnect();

if ( (isset($_GET['action'])) && ($_GET['action'] == 'send') ) {
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

		if ( $_POST['title'] != "" ) {
			$title = html2txt($_POST['title']);
		}
		else {
			$msg[]= 'Please enter a title for your review!';
		}

		if ( $_POST['text'] != "" ) {
			$text = html2txt($_POST['text']);
		}
		else {
			$msg[]= 'Please enter a text for your review!';
		}

		if ( $_POST['vote'] != "" ) {
			$vote = (int)$_POST['vote'];
		}
		else {
			$msg[]= 'Please select an rating!';
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
				// Add Review to DB
				$query = sprintf('INSERT INTO pmp_reviews (film_id, date, title, name, email, text, vote, status)
						VALUES ( \'%s\', now(), \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')',
						mysql_real_escape_string( html2txt($_GET['id']) ),
						mysql_real_escape_string( $title ),
						mysql_real_escape_string( $name ),
						mysql_real_escape_string( $email ),
						mysql_real_escape_string( $text ),
						mysql_real_escape_string( $vote ),
						mysql_real_escape_string( $pmp_review_activatenew ) );

				if ( dbexec($query) ) {
					$dvd = new smallDVD(html2txt($_GET['id']));

					str_replace(array('\r', '\n'), '', $email);
					str_replace(array('\r', '\n'), '', $name);

					// Send e-mail to administrator
					$body  = html_entity_decode(t('Someone added a new review:'), ENT_COMPAT, 'UTF-8') . "\n\n";
					$body .= "-----------------------------------------------------------\n";
					$body .= 'DVD: ' . html_entity_decode($dvd->Title, ENT_COMPAT, 'UTF-8') . "\n";
					$body .= t('Title of review') . ': ' . $title . "\n";
					$body .= t('Author') . ': ' . $name . "\n";
					$body .= t('E-mail') . ': ' . $email . "\n\n";
					$body .= $text . "\n";
					$body .= "-----------------------------------------------------------\n\n";
					if ( $pmp_review_activatenew == false ) {
						$body .= html_entity_decode(t('Please activate or delete this pending review:'), ENT_COMPAT, 'UTF-8') . "\n\n";
						$body .= $pmp_basepath. '/admin/reviews.php';
					}

					$subject = '[phpMyProfiler] ' .  t('New pending review:') . ' ' . $title;
					$subject= mb_encode_mimeheader(html_entity_decode($subject, ENT_COMPAT, 'UTF-8'), "UTF-8", "B", "\n");

					$header = 'From: "' . $pmp_admin_name . '" <' . $pmp_admin_mail . '>' . "\r\n"
						. 'MIME-Version: 1.0' . "\r\n"
						. 'Content-Type: text/plain; charset="UTF-8"' . "\r\n"
						. 'Content-Transfer-Encoding: quoted-printable' . "\r\n"
						. 'Message-ID: <' . md5(uniqid(microtime())) . '@' . $_SERVER['SERVER_NAME'] . '>' . "\r\n"
						. 'X-Mailer: phpMyProfiler ' . $pmp_version . "\r\n";

					mail($pmp_admin_mail, $subject, $body, $header);

					$smarty->assign('Success', t('Thank you for your review.'));

					// Clean values
					$_POST['title'] = '';
					$_POST['name'] = '';
					$_POST['email'] = '';
					$_POST['text'] = '';
					$_POST['vote'] = '9';
				}
				else {
					$smarty->assign('Error', t('Sorry, an error has occurred') . '!');
				}
			}
		}
		else {
			$smarty->assign('Failed', implode($msg, ' <br />'));
		}
	}
}

$smarty->assign('id', html2txt($_GET['id']));
$smarty->assign('film', new smallDVD(html2txt($_GET['id'])));

dbclose();

$smarty->assign('title', t("Write a review for"));
$smarty->assign('formkey', $formKey->outputKey());

$smarty->display('review.tpl');
?>
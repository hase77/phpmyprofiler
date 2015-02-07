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
if (empty($id)) {
    die('No id given!');
}

$pmp_module = 'review';

require_once('include/formkey.class.php');

$formKey = new formKey();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Initialize the captcha object with our configuration options
if ($pmp_guestbook_showcode == true) {
	require_once('include/b2evo_captcha/b2evo_captcha.config.php');
	require_once('include/b2evo_captcha/b2evo_captcha.class.php');

	$captcha = new b2evo_captcha($CAPTCHA_CONFIG);
	$imgLoc = $captcha->get_b2evo_captcha();
	$smarty->assign('imgLoc', $imgLoc);
}

if ($action == 'send') {
	// First check the form key
	if (!$formKey->validate($form_key)) {
		//Form key is invalid, show an error
		$smarty->assign('Failed', 'Form key error!');
	}
	else {
		$msg = [];

		// ToDo: Translation for error messages

		// Check all values we get from contact form
		if (empty($name)) {
			$msg[]= 'Please enter your name!';
		}

		if (!$email) {
			$msg[]= 'Please enter a valid email address!';
		}

		if (empty($title)) {
			$msg[]= 'Please enter a title for your review!';
		}

		if (empty($text)) {
			$msg[]= 'Please enter a text for your review!';
		}

		if (empty($vote)) {
			$msg[]= 'Please select an rating!';
		}

		if (count($msg) == 0) {
			// Check captcha
			if ($pmp_guestbook_showcode == true && $captcha->validate_submit($captcha_image, $captcha_code) == false) {
				$smarty->assign('Failed', t('Wrong security code!'));
			}
			// Make Bot-Check
			else if (!empty($username)) {
				$smarty->assign('Failed', t('Bot Attack!'));
			}
			else {
				// Add Review to DB
				// Insert entry into db
				$sql = 'INSERT INTO pmp_reviews (film_id, date, title, name, email, text, vote, status)
						VALUES (?, now(), ?, ?, ?, ?, ?, ?)';
				$params = [$id, $title, $name, $email, $text, $vote, $pmp_review_activatenew];
				$result = dbexecute_pdo($sql, $params);

				if ($result) {
					$dvd = new smallDVD($id);

					str_replace(['\r', '\n'], '', $email);
					str_replace(['\r', '\n'], '', $name);

					// Send e-mail to administrator
					$body  = html_entity_decode(t('Someone added a new review:'), ENT_COMPAT, 'UTF-8') . "\n\n";
					$body .= "-----------------------------------------------------------\n";
					$body .= "DVD: ".html_entity_decode($dvd->Title, ENT_COMPAT, 'UTF-8')."\n";
					$body .= t('Title of review').": {$title}\n";
					$body .= t('Author'). ": {$name}\n";
					$body .= t('E-mail') . ": {$email}\n\n";
					$body .= $text . "\n";
					$body .= "-----------------------------------------------------------\n\n";
					if ($pmp_review_activatenew == false) {
						$body .= html_entity_decode(t('Please activate or delete this pending review:'), ENT_COMPAT, 'UTF-8')."\n\n";
						$body .= get_base_url().'admin/reviews.php';
					}

					$subject = '[phpMyProfiler] ' .  t('New pending review:') . ' ' . $title;
					$subject = mb_encode_mimeheader(html_entity_decode($subject, ENT_COMPAT, 'UTF-8'), 'UTF-8', 'B', '\n');

					$header = "From: \"{$pmp_admin_name}\" <{$pmp_admin_mail}>\r\n"
							 ."MIME-Version: 1.0\r\n"
							 ."Content-Type: text/plain; charset=\"UTF-8\"\r\n"
							 ."Content-Transfer-Encoding: quoted-printable\r\n"
							 ."Message-ID: <".md5(uniqid(mt_rand(), true))."@".$_SERVER['SERVER_NAME'].">\r\n"
							 ."X-Mailer: phpMyProfiler {$pmp_version}\r\n";

					mail($pmp_admin_mail, $subject, $body, $header);

					$smarty->assign('Success', t('Thank you for your review.'));

					// Clean values
					$title = '';
					$name = '';
					$email = '';
					$text = '';
					$vote = '9';
				}
				else {
					$smarty->assign('Error', t('Sorry, an error has occurred') . '!');
				}
			}
		}
		else {
			$smarty->assign('Failed', implode($msg,  '<br/>'));
		}
	}
}

$smarty->assign('id', $id);
$smarty->assign('film', new smallDVD($id));

$smarty->assign('title', t('Write a review for'));
$smarty->assign('formkey', $formKey->outputKey());
$smarty->assign('title', $title);
$smarty->assign('name', $name);
$smarty->assign('email', $email);
$smarty->assign('text', $text);
$smarty->assign('vote', $vote);

$smarty->display('review.tpl');
?>
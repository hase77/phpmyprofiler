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

$pmp_module = 'contact';

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

// Add new entry
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

		if (empty($subject)) {
			$msg[]= 'Please enter a subject!';
		}

		if (empty($message)) {
			$msg[]= 'Please enter a message to send!';
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
				$subject = "[phpMyProfiler] {$subject}";
				$subject= mb_encode_mimeheader($subject, 'UTF-8', 'B', '\n');

				// Wordwrap after 72 chars in message
				$message = wordwrap($message, 72);

				$header = "From: \"{$name}\" <{$email}>\r\n"
						 ."MIME-Version: 1.0\r\n"
						 ."Content-Type: text/plain; charset=\"UTF-8\"\r\n"
						 ."Content-Transfer-Encoding: quoted-printable\r\n"
						 ."Message-ID: <".md5(uniqid(mt_rand(), true))."@".$_SERVER['SERVER_NAME'].">\r\n"
						 ."X-Mailer: phpMyProfiler {$pmp_version}\r\n";

				// Send e-mail
				if (mail($pmp_admin_mail, $subject, $message, $header)) {
					$smarty->assign('Success', t('Thank you for your message.'));
				}
				else {
					$smarty->assign('Failed', t('Failed to send E-mail.'));
				}

				// Clean the input values
				$name = '';
				$email = '';
				$subject = '';
				$message = '';
			}
		}
		else {
			$smarty->assign('Failed', implode($msg, '<br/>'));
		}
	}
}

// Try to obscure email against spammers
$pmp_admin_mail_s = str_replace('@', ' [at] ', $pmp_admin_mail);
$pmp_admin_mail_s = str_replace('.', ' dot ', $pmp_admin_mail_s);

$smarty->assign('formkey', $formKey->outputKey());
$smarty->assign('name', $name);
$smarty->assign('email', $email);
$smarty->assign('subject', $subject);
$smarty->assign('message', $message);

$smarty->display('contact.tpl');
?>
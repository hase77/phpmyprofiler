<?php
/* phpMyProfiler
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

define('_PMP_REL_PATH', '..');

$pmp_module = 'install';

require_once('../config.inc.php');
require_once('../include/functions.php');
require_once('../admin/include/functions.php');

$configfile = '../passwd.inc.php';
$user = '';

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);


if (!empty($action) && $action == 'save') {
    if (empty($username)) {
        $error = t('You must enter a username.');
    }
    else if (empty($password) || empty($password2)) {
        $error = t('You must enter a password.');
        $user = $username;
    }
    else if ($password != $password2) {
	$error = t('The Password do not match.');
	$user = $username;
    }
    else {
	$data  = "<?php\n// " . t('Configuration File of Administration') . "\n// " . t('Generated:') . " " .  date("r") . "\n\n";
	$data .= '$pmp_admin' ." = '" . $username . "';" . "\n";
	$data .= '$pmp_passwd' . " = '" . password_hash($password, PASSWORD_BCRYPT, array('costs'=>11)) . "';" . "\n";
	$data .= "\n?>";

	if (!@file_put_contents($configfile, $data)) {
            $error = t('An error occurs while writing to') . ' "' . basename($configfile) . '".';
	}
	else {
            // Try and track new installs to see if it is worthwhile continueing development
            @include_once('../admin/include/PiwikTracker.php');

            if (class_exists('PiwikTracker')) {
		$piwikTracker = new PiwikTracker($idSite = 1 , 'http://www.phpmyprofiler.de/piwik/');
		// We don't need or want the dist-version
		$php_ver = explode("-", phpversion());
                $piwikTracker->setCustomVariable(1, 'php_version', $php_ver[0]);
		$piwikTracker->setCustomVariable(2, 'pmp_version', $pmp_version);
		// Don't send url, referrer and user agent!
		$piwikTracker->setUrl('none');
		$piwikTracker->setUrlReferrer('none');
		$piwikTracker->setUserAgent('unknown');
		$piwikTracker->doTrackPageView( 'Installation completed' );
            }

            header("Location:install4.php");
            exit();
	}
    }
}

header('Content-type: text/html; charset=utf-8');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>phpMyProfiler - Installation</title>
	<link href="css/install.css" rel="stylesheet" type="text/css" />
    </head>
    <body>

	<div style="text-align: center;" align="center">
	    <div id="mainover" style="margin-left:auto; margin-right:auto">

		<div id="mainpanel">

		    <table cellpadding="0" cellspacing="0" border="0" width="100%">

			<tr style="height: 10px"><td>&nbsp;</td></tr>

			<tr style="height: 32px">
			    <td style="width: 10px">&nbsp;</td>
			    <td colspan="10">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
				    <tr>
					<td><img src="images/install.jpg" border="0" alt="" /><img src="images/logo.jpg" border="0" alt="" /></td>
					<td align="right" valign="bottom">Version: <?php echo $pmp_version; ?></td>
					<td style="width: 10px">&nbsp;</td>
				    </tr>
				</table>
			    </td>
			</tr>

			<tr style="height: 10px"><td>&nbsp;</td></tr>

			<tr style="height: 30px">
			    <td style="width: 10px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Pre-Installation Check'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 1'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 2'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-on"> <?php echo t('Step 3'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Finish'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td style="width: 10px">&nbsp;</td>
			</tr>
		    </table>

		</div>

		<?php
		if (isset($error)) {
		?>

		<div id="mainerror">
		    <div class="error_box">
			<div class="error_headline"><?php echo t('Sorry, an error has occurred') . ':'; ?></div>
			<div class="error_msg"><?php echo $error; ?></div>&nbsp;
		    </div>
		</div>

		<?php
		}
		?>
		<form action="install3.php?action=save" method="post" target="_self" style="display: inline;">
		    <div class="maintext">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">

			    <tr><td colspan="3" class="mainheader"><?php echo t('Password for Administration'); ?></td></tr>
			    <tr><td colspan="3">&nbsp;</td></tr>

			    <tr>
				<td style="width: 20px">&nbsp;</td>
				<td>
				    <table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
					<tr>
					    <td><?php echo t('Username'); ?></td>
					    <td style="width: 100px"><input type="text" name="username" value="<?php echo $user; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Password'); ?></td>
					    <td style="width: 100px"><input type="password" name="password" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Retype Password'); ?></td>
					    <td style="width: 100px"><input type="password" name="password2" /></td>
					</tr>
				    </table>
				</td>
				<td style="width: 20px">&nbsp;</td>
			    </tr>
			</table>

		    </div>

		    <div class="maintext">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			    <tr>
				<td align="center" style="text-align: center">
				    <input type="text" name="action" value="save" style="visibility: hidden; display: none" />
				    <input type="submit" name="submit" class="next" value="<?php echo t('Next'); ?>" />
				</td>
			    </tr>

			</table>
		    </div>
		</form>
	    </div>
	</div>

    </body>
</html>
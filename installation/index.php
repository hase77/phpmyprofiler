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
require_once('../passwd.inc.php');
require_once('../include/functions.php');

if (dbconnect_pdo(false) === true && !empty($pmp_admin) && !empty($pmp_passwd)) {
    header("Location:install4.php");
    exit();
}

if (dbconnect_pdo(false) === true && empty($pmp_admin) && empty($pmp_passwd)) {
    header("Location:install3.php");
    exit();
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
			<tr style="height: 10px">
			    <td style="width: 10">&nbsp;</td>
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
			    <td width="10">&nbsp;</td>
			    <td class="step-on"> <?php echo t('Pre-Installation Check'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 1'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 2'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 3'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Finish'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td style="width: 10px">&nbsp;</td>
			</tr>
		    </table>
		</div>

		<?php
		function check_phpversion() {
		    global $failed;

		    if (version_compare(phpversion(), '5.5.0', '>=')) {
			echo '<b><font color="green">' . t('Yes') . '</font></b>';
		    }
		    else {
			echo '<b><font color="red">' . t('No') . '</font></b>';
			$failed = true;
		    }
		}

		function check_extension($extension) {
		    global $failed;

		    if (extension_loaded($extension)) {
			echo '<b><font color="green">' . t('Available') . '</font></b>';
		    }
		    else {
			echo '<b><font color="red">' . t('Unavailable') . '</font></b>';
			$failed = true;
		    }
		}
		?>

		<div class="maintext">
		    <table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr><td colspan="3" class="mainheader"><?php echo t('Requirements'); ?></td></tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
			    <td valign="top" align="left" style="padding-left: 5px; width: 200px"><?php echo t('To install phpMyProfiler you must have this requirements.') . '<br /><br /> ' .  t('If some requirements are not available and colored red, the installation will not start.') . '<br /><br /> ' . t('When its colored orange, the installation will starts but not all functions are available.'); ?></td>
			    <td style="width: 3px">&nbsp;</td>
			    <td>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
				    <tr>
					<td>PHP >= 5.5.0</td>
					<td style="width: 150px"><?php check_phpversion(); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - PDO MySQL Support</td>
					<td style="width: 150px"><?php check_extension('pdo_mysql'); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - Session Support</td>
					<td style="width: 150px"><?php check_extension('session'); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - PCRE (Perl Compatible Regular Expressions) Support</td>
					<td style="width: 150px"><?php check_extension('pcre'); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - XML Support</td>
					<td style="width: 150px"><?php check_extension('xml'); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - Iconv Support</td>
					<td style="width: 150px"><?php check_extension('iconv'); ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - GD Support</td>
					<td style="width: 150px"><?php echo extension_loaded('gd') ? '<b><font color="green">' . t('Available') . '</font></b>' : '<b><font color="#ffa800">' . t('Unavailable') . '</font></b>' ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - Zip Support</td>
					<td style="width: 150px"><?php echo extension_loaded('zip') ? '<b><font color="green">' . t('Available') . '</font></b>' : '<b><font color="#ffa800">' . t('Unavailable') . '</font></b>' ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - BZip2 Support</td>
					<td style="width: 150px"><?php echo extension_loaded('bz2') ? '<b><font color="green">' . t('Available') . '</font></b>' : '<b><font color="#ffa800">' . t('Unavailable') . '</font></b>' ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - ZLib Support</td>
					<td style="width: 150px"><?php echo extension_loaded('zlib') ? '<b><font color="green">' . t('Available') . '</font></b>' : '<b><font color="#ffa800">' . t('Unavailable') . '</font></b>' ?></td>
				    </tr>
				    <tr>
					<td>&nbsp; - cURL Support</td>
					<td style="width: 150px"><?php echo extension_loaded('curl') ? '<b><font color="green">' . t('Available') . '</font></b>' : '<b><font color="#ffa800">' . t('Unavailable') . '</font></b>' ?></td>
				    </tr>
				</table>
			    </td>
			</tr>
		    </table>

		    <?php
		    function check_permissions($folder, $type) {
			global $failed;

			echo '<tr>';
			echo '<td>' . $folder . '</td>';
			echo '<td align="left" style="width: 150px">';
			if ($type == '1' && is__writable( "../$folder")) {
			    echo '<b><font color="green">' . t('Writeable') . '</font></b></td>';
			}
			else if ($type == '2' && is_writable( "../$folder")) {
			    echo '<b><font color="green">' . t('Writeable') . '</font></b></td>';
			}
			else {
			    echo '<b><font color="red">' . t('Unwriteable') . '</font></b></td>';
			    $failed = true;
			}
			echo '</tr>';
		    }
		    ?>

		    <table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr><td colspan="3" class="mainheader"><?php echo t('Directory and File Permissions'); ?></td></tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
			    <td valign="top" align="left" style="padding-left: 5px; width: 200px"><?php echo t('This folders/files must be writeable to install phpMyProfiler.'); ?></td>
			    <td style="width: 3px">&nbsp;</td>
			    <td>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
				<?php
                                    check_permissions('awards/', 1);
                                    check_permissions('cache/', 1);
                                    check_permissions('cover/', 1);
                                    check_permissions('pictures/', 1);
                                    check_permissions('screenshots/', 1);
                                    check_permissions('screenshots/thumbs/', 1);
                                    check_permissions('templates_c/', 1);
                                    check_permissions('xml/', 1);
                                    check_permissions('xml/split/', 1);
                                    check_permissions('config.inc.php', 2);
                                    check_permissions('passwd.inc.php', 2);
				?>
				</table>
			    </td>
			</tr>
		    </table>
		</div>
		<div class="maintext">
		    <table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
			    <td align="center" style="text-align: center">
				<input type="submit" name="submit" class="reload" value="<?php echo t('Check Again'); ?>" onclick="window.location=window.location" />
				<?php if (! $failed) {?>
				&nbsp;
				<form action="install1.php" method="post" target="_self" style="display: inline">
				    <input type="submit" name="submit" class="next" value="<?php echo t('Next'); ?>" />
				</form>
				<?php
				}
				?>
			    </td>
			</tr>
		    </table>
		</div>
	    </div>
	</div>
    </body>
</html>
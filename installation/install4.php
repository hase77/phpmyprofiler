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
			    <td width="10">&nbsp;</td>
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
			    <td class="step-off"><?php echo t('Step 3'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-on"> <?php echo t('Finish'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td style="width: 10px">&nbsp;</td>
			</tr>
		    </table>

		</div>

		<div class="maintext">
		    <table cellpadding="0" cellspacing="0" border="0" width="100%">

			<tr>
			    <td style="width: 20px">&nbsp;</td>
			    <td>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
				    <tr>
					<td><img src="images/messagebox_info.jpg" border="0" alt="" /></td>
					<td><?php echo t('The Installation has finished. For your security, you must delete the folder "installation".'); ?></td>
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
				<input type="submit" name="submit" class="next" value="<?php echo t('Frontpage'); ?>" onclick="location.href='../'" /> &nbsp;
				<input type="submit" name="submit" class="next" value="<?php echo t('Administration'); ?>" onclick="location.href='../admin'" />
			    </td>
			</tr>
		    </table>
		</div>

	    </div>
	</div>
    </body>
</html>
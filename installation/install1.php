<?php
/* phpMyProfiler
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

define('_PMP_REL_PATH', '..');

$pmp_module = 'install';

require('../config.inc.php');
require_once('../include/functions.php');
require_once('../admin/include/functions.php');
require_once('../admin/include/option.class.php');
require_once('../admin/include/options.php');

$configfile = '../config.inc.php';

// Save the Configuration File

if( (isset($_POST['action'])) && ($_POST['action'] == 'save') ) {
    $data = "<?php \n// " . t('Generated:') . " " .  date("r") . "\n\n";
    foreach ( $Options as $item ) {
	if ( @get_class($item) == 'option' ) {
	    $data .= $item->getSkript();
	}
	else {
	    $data .= "\n\n// " . html_entity_decode(t($item), ENT_COMPAT, 'UTF-8') . "\n// " . str_pad('', strlen(html_entity_decode(t($item), ENT_COMPAT, 'UTF-8')), '=') . "\n\n";
	}
    }
    $data .= "?>";

    if ( !@file_put_contents($configfile, $data) ) {
	$error = t('No write acccess to config.inc.php. Settings not saved.');
    }
    else {
	require('../config.inc.php');

	if ( !@mysql_connect($pmp_sqlhost, $pmp_sqluser, $pmp_sqlpass) ) {
	    $error = t('Wrong access data for MySQL Database.');
	}
	else {
	    header("Location:install2.php");
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
	<form action="install1.php" method="post" target="_self" style="display: inline" accept-charset="utf-8">
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
				<td class="step-off"><?php echo t('Pre-Installation Check'); ?></td>	<td style="width: 3px">&nbsp;</td>
				<td class="step-on"> <?php echo t('Step 1'); ?></td>					<td style="width: 3px">&nbsp;</td>
				<td class="step-off"><?php echo t('Step 2'); ?></td>					<td style="width: 3px">&nbsp;</td>
				<td class="step-off"><?php echo t('Step 3'); ?></td>					<td style="width: 3px">&nbsp;</td>
				<td class="step-off"><?php echo t('Finish'); ?></td>					<td style="width: 3px">&nbsp;</td>
				<td style="width: 10px">&nbsp;</td>
			    </tr>
			</table>

		    </div>

		    <?php
		    if ( isset($error) ) {
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

		    <div class="maintext">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">

			    <tr><td colspan="3" class="mainheader"><?php echo t('Main settings'); ?></td></tr>
			    <tr><td colspan="3">&nbsp;</td></tr>

			    <tr>
				<td valign="top" align="left" style="padding-left: 5px; width: 200px"><?php echo t('Please enter the access data to the MySQL database.'); ?></td>
				<td style="width: 3px">&nbsp;</td>
				<td>
				    <table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
					<tr>
					    <td><?php echo t('Database server'); ?></td>
					    <td style="width: 100px"><input type="text" name="pmp_sqlhost" value="<?php echo $pmp_sqlhost; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Database name'); ?></td>
					    <td style="width: 100px"><input type="text" name="pmp_sqldatabase" value="<?php echo $pmp_sqldatabase; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Database user'); ?></td>
					    <td style="width: 100px"><input type="text" name="pmp_sqluser" value="<?php echo $pmp_sqluser; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Database password'); ?></td>
					    <td style="width: 100px"><input type="password" name="pmp_sqlpass" value="<?php echo $pmp_sqlpass; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('Tableprefix'); ?></td>
					    <td style="width: 100px"><input type="text" name="pmp_table_prefix" value="<?php echo $pmp_table_prefix; ?>" /></td>
					</tr>
					<tr>
					    <td><?php echo t('URL to phpMyprofiler'); ?></td>
					    <td style="width: 100px"><input type="text" name="pmp_basepath" value="<?php echo $pmp_basepath; ?>" /></td>
					</tr>
				    </table>
				</td>
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
		</div>
	    </div>
	</form>
    </body>
</html>
<?php
/* phpMyProfiler
 * Copyright (C) 2005-20015 The phpMyProfiler project
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

function showmsg($type, $msg) {
    echo '<tr><td width="40">';

    if ($type == 'Error') {
	echo '<img src="images/messagebox_error.jpg" border="0" alt="" />';
    }
    else if ($type == 'Warning') {
        echo '<img src="images/messagebox_warning.jpg" border="0" alt="" />';
    }
    else if ($type == 'Info') {
        echo '<img src="images/messagebox_info.jpg" border="0" alt="" />';
    }
    else {
        echo '<img src="images/messagebox_success.jpg" border="0" alt="" />';
    }

    echo '</td><td>' . $msg . '</td></tr>';
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
			    <td class="step-on"> <?php echo t('Step 2'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Step 3'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td class="step-off"><?php echo t('Finish'); ?></td><td style="width: 3px">&nbsp;</td>
			    <td style="width: 10px">&nbsp;</td>
			</tr>
		    </table>

		</div>

		<div class="maintext">

		    <table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr><td colspan="3" class="mainheader"><?php echo t('Create phpMyProfiler Database'); ?></td></tr>
			<tr><td colspan="3">&nbsp;</td></tr>

			<tr>
			    <td style="width: 20px">&nbsp;</td>
			    <td>
				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="maintests">
                                    <?php
				    // Check Connection to Database
				    $pmp_db = false;
                                    try {
                                        $pmp_db = new PDO("mysql:host={$pmp_sqlhost}", $pmp_sqluser, $pmp_sqlpass,
                                                [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8;']);
                                        $pmp_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    }
                                    catch (PDOException $e) {
					showmsg('Error', t('Unable to connect to database.'));
					$failed = true;
                                    }

				    if ($pmp_db !== false) {
					showmsg('Success', t('Connection to database established.'));
					$res = dbquery_pdo("SHOW DATABASES LIKE '{$pmp_sqldatabase}'");
					
                                    
					// Check Database exist
					if (empty($res)) {
					    showmsg('Warning', t("Can't select database. Trying to create..."));

					    if (!dbexecute_pdo("CREATE DATABASE {$pmp_sqldatabase} DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci", null, true)) {
						showmsg('Error', t("Can't create database."));
						$failed = true;
					    }
					    else {
						showmsg('Success', t('Database created.'));
						$pmp_db->exec("USE {$pmp_sqldatabase}");
					    }
					}
					else {
					    showmsg('Success', t('Connected to existing database.'));
                                            $pmp_db->exec("USE {$pmp_sqldatabase}");
					}

					// Start creating Tables
					if (!isset($failed)) {
					    showmsg('Info', t('Start Creating tables.'));

					    $query = file('sql/phpmyprofiler.sql');
					    $query = array_map('trim', $query);

					    foreach ($query as $index => $line) {
						if ((strpos($line, '#') === 0) || (substr($line, 0, 2) == '--') || $line == null) {
						    unset($query[$index]);
                                                }
					    }

					    $query = array_values($query);

					    foreach (explode(';', implode(' ', $query)) as $sql) {
						if (strlen(trim($sql)) > 0) {
						    dbexecute_pdo($sql);
                                                }
					    }

					    showmsg('Success', t('Tables created successfully.'));
					    showmsg('Info', t('Starting importing data'));

					    $query = file('sql/phpmyprofiler_data.sql');
					    $query = array_map('trim', $query);

					    foreach ($query as $index => $line) {
						if (strpos($line, "INSERT") === false) {
						    unset($query[$index]);
                                                }
					    }
					    foreach ($query as $sql) {
						dbexecute_pdo($sql);
                                            }

					    showmsg('Success', t('Data imported successfully.'));
					    showmsg('Success', t('Installation finished'));
					}
				    }

				    if (isset($failed)) {
					showmsg('Error', t('Installation halted, check your Configuration.'));
				    }
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
                                <?php if (isset($failed)) {
                                ?>
				<form action="install1.php" method="post" target="_self" style="display: inline;" accept-charset="utf-8">
				    <input type="submit" name="submit" class="next" value="<?php echo t('Back'); ?>" />
				</form>
				<?php }
                                else {
                                ?>
				<form action="install3.php" method="post" target="_self" style="display: inline;">
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
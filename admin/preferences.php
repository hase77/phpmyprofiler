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

$pmp_module = 'admin_preferences';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../admin/include/option.class.php');
require_once('../admin/include/options.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Preferences'));
$smarty->assign('header_img', 'config');
$smarty->assign('session', session_name() . "=" . session_id() );

$configfile = '../config.inc.php';
if ( !is_writable($configfile) ) {
	$smarty->assign('Error', t('No write acccess to config.inc.php. Settings not saved.'));
}
else {
	if ( (isset($_GET['action'])) && ($_GET['action'] == 'save') ) {
		$data = "<?php \n// " . t('Generated:') . " " .  date("r") . "\n\n";
		foreach ( $Options as $item ) {
			if ( strtolower(@get_class($item)) == 'option' ) {
				$data .= $item->getSkript();
			}
			else {
				$data .= "\n\n// " . html_entity_decode(t($item), ENT_COMPAT, 'UTF-8') . "\n// " . str_pad('', strlen(html_entity_decode(t($item), ENT_COMPAT, 'UTF-8')), '=') . "\n\n";
			}
		}
		$data .= "?>";

		if ( !file_put_contents($configfile, $data) ) {
			$smarty->assign('Error', t('An error occurs while writing to "config.inc.php".'));
		}
		else {
			$smarty->assign('Success', t('Settings saved.'));

			// Delete cached templates
			$handle = opendir('../cache/');
			while ( ($file = readdir($handle)) !== false ) {
				if ( strrchr($file, '.') == '.php' ) {
					@unlink('../cache/' . basename($file));
				}
			}
			closedir($handle);
		}
	}
}

$smarty->assign('Options', $Options);
$smarty->display('admin/preferences.tpl');
?>
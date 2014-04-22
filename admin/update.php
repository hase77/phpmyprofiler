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

$pmp_module = 'admin_update';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../admin/include/update.class.php');

isadmin();

dbconnect();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header_img', 'update');
$smarty->assign('session', session_name() . "=" . session_id() );

// Check database and database structure
$dbstate = checkDBState();
$smarty->assign('StateDB', $dbstate['StateDB']);
$smarty->assign('StateDBTime', $dbstate['StateDBTime']);
$smarty->assign('StateUpdate', $dbstate['StateUpdate']);

if ( (isset($_GET['action'])) && ($_GET['action'] == 'doupdate') ) {
	// Get needed updates
	$smarty->assign('header', t('Processing update'));
	$smarty->display('admin/update_log_start.tpl');

	$handle = opendir('updates');
	while ( false !== ($file = readdir($handle)) ) {
		if ( ($file != '.') && ($file != '..') && (!is_dir($file)) ) {
			$tmp = explode('.', $file);

			if ( $tmp[count($tmp)-1] == 'upd' ) {
				if ( $tmp[0] > $dbstate['StateDB'] ) {
					$todo[] = $tmp[0];
				}
			}
		}
	}
	closedir($handle);

	sort($todo, SORT_NUMERIC);

	$founderror = false;

	foreach ( $todo as $do ) {
		$upd = new update('updates/' . $do . '.upd');
		$res = $upd->doit();

		if ( $res !== false) {

			// Try and track new installs to see if it is worthwhile continueing development
			include_once('../admin/include/PiwikTracker.php');

			if ( class_exists( 'PiwikTracker' ) ) {
				$piwikTracker = new PiwikTracker( $idSite = 1 , 'http://www.phpmyprofiler.de/piwik/');
				$piwikTracker->setCustomVariable( 1, 'php_version', phpversion() );
				$piwikTracker->setCustomVariable( 2, 'pmp_version', $pmp_version );
				$piwikTracker->doTrackPageView( 'Update Completed' );
			}

			$smarty->assign('type', 'S');
			$smarty->assign('msg', $res);
			$smarty->display('admin/update_log_msg.tpl');
		}
		else {
			$founderror = true;

			$smarty->assign('type', 'E');
			$smarty->assign('msg', $upd->lasterror);
			$smarty->display('admin/update_log_msg.tpl');
		}
		@flush();
	}

	$smarty->assign('founderror', $founderror);
	$smarty->display('admin/update_log_end.tpl');
}
else {
	$smarty->assign('header', t('Process update'));
	$smarty->display('admin/update.tpl');
}
?>
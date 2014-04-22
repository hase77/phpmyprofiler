<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
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

$pmp_module = 'admin_index';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

if ( file_exists('../installation/') ) {
	header("Location:../installation/");
	exit();
}
else {
	isadmin();

	$smarty = new pmp_Smarty;
	$smarty->loadFilter('output', 'trimwhitespace');
	$smarty->compile_dir = '../templates_c';
	$smarty->assign('session', session_name() . "=" . session_id() );

	dbconnect();

	// Check database and database structure
	$dbstate = checkDBState();
	if ( ($dbstate['StateDB'] != $dbstate['StateUpdate']) || ($dbstate['StateDB'] == -1) ) {
		$smarty->assign('stateDB', $dbstate['StateDB']);
		$smarty->assign('stateUpdate', $dbstate['StateUpdate']);
	}

	// Check GB
	$sql = 'SELECT id FROM pmp_guestbook';
	$res = dbexec($sql);

	if ( mysql_num_rows($res) > 0 ) {
		$smarty->assign('gbfound', true);

		// Check for new GB entries
		if ( $pmp_guestbook_activatenew == false ) {
			$sql = 'SELECT id FROM pmp_guestbook WHERE status = 0';
			$res = dbexec($sql);
			$smarty->assign('guestbook', mysql_num_rows($res));
		}
	}

	// Check movies
	$sql = 'SELECT id FROM pmp_film';
	$res = dbexec($sql);

	if ( mysql_num_rows($res) > 0 ) {
		// Check reviews
		$sql = 'SELECT id FROM pmp_reviews';
		$res = dbexec($sql);

		if ( mysql_num_rows($res) > 0 ) {
			$smarty->assign('reviewsfound', true);

			// Check for new Reviews
			if ( $pmp_review_activatenew == false ) {
				$sql = 'SELECT id FROM pmp_reviews WHERE status = 0';
				$res = dbexec($sql);
				$smarty->assign('reviews', mysql_num_rows($res));
			}
		}
	}
	else {
		$smarty->assign('nomovies', true);
	}

	dbclose();

	// Check for new update
	if ( $pmp_checkforupdates == true ) {
		$latestrelease = getRemoteContent('http://www.phpmyprofiler.de/latest');

		if ( trim($pmp_version) != trim($latestrelease) ) {
			$smarty->assign('latestrelease', $latestrelease);
		}
	}

    $smarty->display('admin/index.tpl');
}
?>
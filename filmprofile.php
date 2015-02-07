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

$pmp_module = 'filmprofile';

require_once('include/DVD.class.php');

// Check values
if (!empty($id)) {
	$smarty = new pmp_Smarty;
	$smarty->loadFilter('output', 'trimwhitespace');
	$smarty->assign('pmp_theme', $pmp_theme);
	$smarty->assign('pmp_review_type', $pmp_review_type);

	// Page selected?
	if (!empty($page) && $page > 0 && $page < 5) {
		$start = $page;
	}
	else {
		$page = 1;
	}

	// Get screenshots on page 1
	if ($page == 1) {
		$filenames = getScreenshots($id);
		if (isset($filenames)) {
			sort($filenames);
			$smarty->assign('screenshots', $filenames);
		}
	}

	// Increase counter for profile
	$smarty->assign('counter', inccounter($id));

	// Get dvd data
	$smarty->assign('dvd', new DVD($id));

	$smarty->assign('page', $page);
	
	$smarty->display('filmprofile.tpl');
}
?>
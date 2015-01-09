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

$pmp_module = 'picturelist';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Page selected?
if (!empty($page)) {
	$start = $page;
}
else {
	$start = 1;
}

// Get total number of pictures
$query = 'SELECT COUNT(id) AS cnt from pmp_pictures';
$row = dbquery_pdo($query, null, 'assoc');
$count = $row[0]['cnt'];

// Get pictures for one page
$query = 'SELECT id, title, filename FROM pmp_pictures ORDER BY title LIMIT ?, ?';
$params = [(((int)$start - 1) * $pmp_picture_page), $pmp_picture_page];
$rows = dbquery_pdo($query, $params, 'object');

$pictures = [];

if (count($rows) > 0) {
	foreach ($rows as $row) {
		$pictures[] = $row;
	}
}

$smarty->assign('pictures', $pictures);
$smarty->assign('count', $count);
$smarty->assign('page', (int)$start);
$smarty->assign('pages', (int)($count / $pmp_picture_page + ((($count % $pmp_picture_page) == 0) ? 0 : 1)));

$smarty->display('picturelist.tpl');
?>
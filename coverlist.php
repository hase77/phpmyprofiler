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

$pmp_module = 'coverlist';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Page selected?
if (empty($page)) {
	$start = 1;
}
else {
	$start = $page;
}

// Get cover ids for one page
$query = 'SELECT id FROM pmp_film WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\'
		  AND id NOT IN (SELECT id FROM pmp_tags where name = ?) ORDER BY sorttitle LIMIT ?, ?';
$params = [$pmp_exclude_tag, (((int)$start - 1) * $pmp_cover_page), $pmp_cover_page];
$rows = dbquery_pdo($query, $params, 'assoc');

// Get dvd objects with dvd covers
$cover = [];
if (count($rows) > 0) {
	foreach ($rows as $row) {
		$cover[] = new smallDVD($row['id']);
	}
}

$query = 'SELECT COUNT(id) AS cnt FROM pmp_film WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\'
		  AND id NOT IN (SELECT id FROM pmp_tags where name = ?)';
$params = [$pmp_exclude_tag];
$row = dbquery_pdo($query, $params, 'assoc');
$count = $row[0]['cnt'];

$smarty->assign('cover', $cover);
$smarty->assign('count', $count);
$smarty->assign('page', (int)$start);
$smarty->assign('pages', (int)($count / $pmp_cover_page + ((($count % $pmp_cover_page) == 0) ? 0 : 1)));

$smarty->display('coverlist.tpl');
?>

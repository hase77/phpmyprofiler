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

$pmp_module = 'start';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// News
$query = 'SELECT id, date, title, text FROM pmp_news ORDER BY date DESC LIMIT 0, 1';
$result = dbquery_pdo($query, null, 'object');
$news = [];
if (count($result) > 0) {
	$news[] = $result[0];
}
$smarty->assign('news', $news);

// Last DVDs
$query = 'SELECT pmp_film.id FROM pmp_film LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid
		  WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_boxset.childid IS NULL
		  AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = ?)
		  ORDER BY purchdate DESC LIMIT 0, ?';
	
$params = [$pmp_exclude_tag, $pmp_dvd_start];
$result = dbquery_pdo($query, $params, 'assoc');

$new = [];
foreach ($result as $row) {
	$new[] = new smallDVD($row['id']);
}
$smarty->assign('new', $new);

// Last ordered DVDs
$query = 'SELECT pmp_film.id FROM pmp_film LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid
		  WHERE collectiontype = \'Ordered\' AND pmp_boxset.childid IS NULL
		  AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = ?)
		  ORDER BY purchdate DESC LIMIT 0, ?';
	
$params = [$pmp_exclude_tag, $pmp_dvd_start];
$result = dbquery_pdo($query, $params, 'assoc');

$order = [];
foreach ($result as $row) {
	$order[] = new smallDVD($row['id']);
}
$smarty->assign('ordered', $order);

// Number of DVDs
$query = 'SELECT SUM(countas) AS cnt FROM pmp_film WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\'
		  AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = ?)';
$params = [$pmp_exclude_tag];
$result = dbquery_pdo($query, $params, 'assoc');
$count = $result[0]['cnt'];
$smarty->assign('count', $count);

// Counter
$smarty->assign('counter', inccounter());

// Last update
$query = 'SELECT data FROM pmp_statistics WHERE type = \'last_update\'';
$result = dbquery_pdo($query, null, 'assoc');
if (count($result) > 0) {
	$last_update = $result[0]['data'];
	$smarty->assign('last_update', strftime($pmp_dateformat, strtotime($last_update)));
}

$smarty->display('start.tpl');
?>
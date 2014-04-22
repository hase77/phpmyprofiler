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

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'start';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

dbconnect();

// News
$sql = 'SELECT id, date, title, text FROM pmp_news ORDER BY date DESC LIMIT 0, 1';
$res = dbexec($sql);

$news = array();
if ( mysql_num_rows($res) > 0 ) {
	while ( $row = mysql_fetch_object($res) ) {
		$news[] = $row;
    }
}
$smarty->assign('news', $news);

// Last DVDs
$sql = 'SELECT pmp_film.id FROM pmp_film
	LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid
	WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\'
	AND pmp_boxset.childid IS NULL
	AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = \'' . mysql_real_escape_string($pmp_exclude_tag) . '\')
	ORDER BY ' . $pmp_start_sort_order . ' DESC LIMIT 0, ' . $pmp_dvd_start;
$res = dbexec($sql);

$new = array();
if ( mysql_num_rows($res) > 0 ) {
	while ( $row = mysql_fetch_object($res) ) {
		$new[] = new smallDVD($row->id);
	}
}
$smarty->assign('new', $new);

// Last ordered DVDs
$sql = 'SELECT pmp_film.id FROM pmp_film
	LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid
	WHERE collectiontype = \'Ordered\'
	AND pmp_boxset.childid IS NULL
	AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = \'' . mysql_real_escape_string($pmp_exclude_tag) . '\')
	ORDER BY purchdate DESC LIMIT 0, ' . $pmp_dvd_start;
$res = dbexec($sql);

$order = array();
if ( mysql_num_rows($res) > 0 ) {
    while ( $row = mysql_fetch_object($res) ) {
	$order[] = new smallDVD($row->id);
    }
}
$smarty->assign('ordered', $order);

// Number of DVDs
$query = 'SELECT SUM(countas) AS count FROM pmp_film
	WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\'
	AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = \'' . mysql_real_escape_string($pmp_exclude_tag) . '\')';
$result = dbexec($query);
$smarty->assign('count', mysql_result($result, 0, 'count'));

// Counter
$smarty->assign('counter', inccounter());

// Last update
$query = 'SELECT data FROM pmp_statistics WHERE type = \'last_update\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('last_update', strftime($pmp_dateformat, strtotime(mysql_result($result, 0, 'data'))));
}

dbclose();

$smarty->display('start.tpl');
?>
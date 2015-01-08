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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
*/

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'news';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

dbconnect();

// Page selected?
if (isset($_GET['page'])) {
	if (!is_numeric($_GET['page'])) {
		$start = 1;
	}
	else {
		$start = $_GET['page'];
	}
}
else {
	$start = 1;
}

// Get News for one page
$sql = 'SELECT title, date, text FROM pmp_news ORDER BY date DESC LIMIT '
	. (((int)$start - 1) * $pmp_news_page). ", " . $pmp_news_page;
$res = dbexec($sql);

$news = array();

if (mysql_num_rows($res) > 0) {
	while ($row = mysql_fetch_object($res)) {
		$news[] = $row;
	}
}

// Get otal number of news
$query = 'SELECT COUNT(id) AS num FROM pmp_news';
$result = dbexec($query);
$count = mysql_result($result, 0, 'num');

dbclose();

$smarty->assign('news', $news);
$smarty->assign('count', $count);
$smarty->assign('page', (int)$start);
$smarty->assign('pages', (int)($count / $pmp_news_page + ((($count % $pmp_news_page) == 0) ? 0 : 1)));

$smarty->display('news.tpl');
?>
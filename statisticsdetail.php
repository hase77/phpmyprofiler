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

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'statisticsdetail';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

dbconnect();

$data = '';
$i = 1;
$report[$i]['title'] = 'Visitor Statistic';
$report[$i]['sql'] = 'SELECT YEAR(date) AS year, MONTH(date) AS month, MAX(id) AS visitors FROM pmp_counter GROUP BY MONTH(date), YEAR(date) ORDER BY date ASC';
$report[$i]['column'][] = 'Year';
$report[$i]['column'][] = 'Month';
$report[$i]['column'][] = 'Visitors';
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Profile Statistic';
$report[$i]['sql'] = 'SELECT YEAR(date) AS year, MONTH(date) AS month, MAX(id) AS visitors FROM pmp_counter_profil GROUP BY MONTH(date), YEAR(date) ORDER BY date ASC';
$report[$i]['column'][] = 'Year';
$report[$i]['column'][] = 'Month';
$report[$i]['column'][] = 'Visitors';
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Year of Production';
$report[$i]['sql'] = 'SELECT prodyear, COUNT(id) AS count FROM pmp_film GROUP BY prodyear ORDER BY prodyear ASC';
$report[$i]['column'][] = 'Year';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Year of Purchase';
if ( $pmp_statistic_showprice == true ) {
	$report[$i]['sql'] = 'SELECT YEAR(purchdate) AS year, MONTHNAME(purchdate) AS month, SUM(purchprice) AS price, COUNT(id) AS count FROM pmp_film WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND year(purchdate) > 0 AND year(purchdate) != 1899 GROUP BY MONTH(purchdate), YEAR(purchdate) ORDER BY purchdate ASC';
}
else {
	$report[$i]['sql'] = 'SELECT YEAR(purchdate) AS year, MONTHNAME(purchdate) AS month, COUNT(id) AS count FROM pmp_film WHERE collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND year(purchdate) > 0 AND year(purchdate) != 1899 GROUP BY MONTH(purchdate), YEAR(purchdate) ORDER BY purchdate ASC';
}
$report[$i]['column'][] = 'Year';
$report[$i]['column'][] = 'Month';
if ( $pmp_statistic_showprice == true ) {
	$report[$i]['column'][] = 'Price';
}
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['translate'][] = 2;

$i++;
$report[$i]['title'] = 'Actor Statistic';
$report[$i]['sql'] = 'SELECT fullname AS full, fullname AS pic, COUNT(DISTINCT pmp_actors.id) AS count, birthyear, firstname, middlename, lastname FROM pmp_common_actors, pmp_actors LEFT JOIN pmp_film ON pmp_film.id = pmp_actors.id WHERE pmp_film.collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_actors.actor_id = pmp_common_actors.actor_id AND pmp_common_actors.fullname != \'[DIVIDER]\' GROUP BY full ORDER BY count DESC, full DESC LIMIT 25';
$report[$i]['column'][] = 'Actor';
$report[$i]['column'][] = 'Picture';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['replace'][0] = '<a href="index.php?content=searchperson&amp;name=[VALUE1]&amp;birthyear=[VALUE2]&amp;nowildcards">[VALUE3]</a>';
$report[$i]['pic'][1] = $pmp_dir_cast;
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Director Statistic';
$report[$i]['sql'] = 'SELECT fullname AS full, fullname AS pic, COUNT(DISTINCT pmp_credits.id) AS count, birthyear, firstname, middlename, lastname FROM pmp_common_credits, pmp_credits LEFT JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE pmp_film.collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_credits.credit_id = pmp_common_credits.credit_id AND pmp_credits.subtype = \'Director\' AND pmp_common_credits.fullname != \'[DIVIDER]\' GROUP BY full ORDER BY count DESC, full ASC LIMIT 25';
$report[$i]['column'][] = 'Director';
$report[$i]['column'][] = 'Picture';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['replace'][0] = '<a href="index.php?content=searchperson&amp;name=[VALUE1]&amp;birthyear=[VALUE2]&amp;nowildcards">[VALUE3]</a>';
$report[$i]['pic'][1] = $pmp_dir_cast;
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Producer Statistic';
$report[$i]['sql'] = 'SELECT fullname AS full, fullname AS pic, COUNT(DISTINCT pmp_credits.id) AS count, birthyear, firstname, middlename, lastname FROM pmp_common_credits, pmp_credits LEFT JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE pmp_film.collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_credits.credit_id = pmp_common_credits.credit_id AND pmp_credits.type = \'Production\' AND pmp_common_credits.fullname != \'[DIVIDER]\' GROUP BY full ORDER BY count DESC, full ASC LIMIT 25';
$report[$i]['column'][] = 'Producer';
$report[$i]['column'][] = 'Picture';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['replace'][0] = '<a href="index.php?content=searchperson&amp;name=[VALUE1]&amp;birthyear=[VALUE2]&amp;nowildcards">[VALUE3]</a>';
$report[$i]['pic'][1] = $pmp_dir_cast;
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Writer &amp; Screenwriter Statistic';
$report[$i]['sql'] = 'SELECT fullname AS full, fullname AS pic, COUNT(DISTINCT pmp_credits.id) AS count, birthyear, firstname, middlename, lastname FROM pmp_common_credits, pmp_credits LEFT JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE pmp_film.collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_credits.credit_id = pmp_common_credits.credit_id AND pmp_credits.type = \'Writing\' AND (pmp_credits.subtype = \'Writer\' OR pmp_credits.subtype = \'Screenwriter\') AND pmp_common_credits.fullname != \'[DIVIDER]\' GROUP BY full ORDER BY count DESC, full ASC LIMIT 25';
$report[$i]['column'][] = 'Writer/Screenwriter';
$report[$i]['column'][] = 'Picture';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['replace'][0] = '<a href="index.php?content=searchperson&amp;name=[VALUE1]&amp;birthyear=[VALUE2]&amp;nowildcards">[VALUE3]</a>';
$report[$i]['pic'][1] = $pmp_dir_cast;
$report[$i]['translate'][] = '';

$i++;
$report[$i]['title'] = 'Composer Statistic';
$report[$i]['sql'] = 'SELECT fullname AS full, fullname AS pic, COUNT(DISTINCT pmp_credits.id) AS count, birthyear, firstname, middlename, lastname FROM pmp_common_credits, pmp_credits LEFT JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE pmp_film.collectiontype != \'Ordered\' AND collectiontype != \'Wish List\' AND pmp_credits.credit_id = pmp_common_credits.credit_id AND pmp_credits.type = \'Music\' AND pmp_credits.subtype = \'Composer\' AND pmp_common_credits.fullname != \'[DIVIDER]\' GROUP BY full ORDER BY count DESC, full ASC LIMIT 25';
$report[$i]['column'][] = 'Composer';
$report[$i]['column'][] = 'Picture';
$report[$i]['column'][] = 'Number of DVDs';
$report[$i]['replace'][0] = '<a href="index.php?content=searchperson&amp;name=[VALUE1]&amp;birthyear=[VALUE2]&amp;nowildcards">[VALUE3]</a>';
$report[$i]['pic'][1] = $pmp_dir_cast;
$report[$i]['translate'][] = '';

$result = dbexec($report[html2txt($_GET['id'])]['sql']);

while ( $row = mysql_fetch_array($result, MYSQL_NUM) ) {
	if ( isset($report[html2txt($_GET['id'])]['replace']) ) {
		$name = $row[0];
		$birthyear = $row[3];

		foreach ( $report[html2txt($_GET['id'])]['replace'] as $col => $repl ) {
			$row[$col] = str_replace('[VALUE1]', rawurlencode($row[$col]), $repl);
			$row[$col] = str_replace('[VALUE2]', $birthyear, $row[$col]);
			$row[$col] = str_replace('[VALUE3]', $name, $row[$col]);
		}
	}

	if ( isset($report[html2txt($_GET['id'])]['pic']) ) {
		foreach ( $report[html2txt($_GET['id'])]['pic'] as $col => $pic ) {
			$picname = getHeadshot($row[$col], $row[3], $row[4], $row[5], $row[6]);
			if ( empty($picname) ) {
				$picname = 'blank.jpg';
			}
			$row[$col] = '<img src="' . $pic . '/' . $picname . '" alt="' . $picname . '" width="100" />';
		}
		unset($row[3]);
	}

	$data[] = $row;
}

dbclose();

$smarty->assign('report', $report[html2txt($_GET['id'])]);
$smarty->assign('data', $data);

$smarty->display('statisticsdetail.tpl');
?>
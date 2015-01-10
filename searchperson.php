<?php
/* phpMyProfiler
 * Copyright (C) 2006-2015 The phpMyProfiler project
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

$pmp_module = 'searchperson';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

dbconnect();

$cast = [];
$crew = [];

// Only if a search-name is given
if (!empty($p_name)) {
	// Get birthyear if exists
	if (!empty($p_birthyear)) {
		$birthyear = $p_birthyear;
	}

	$name = $p_name;
	$searchstr = str_replace("\\'", "'", $name);
	$searchstr = strtolower($searchstr);
	$searchstr = trim(mysql_real_escape_string($searchstr));

	// Actor search (+Rolename)
	$query  = 'SELECT COUNT(pmp_actors.id) AS episodes, pmp_actors.id, firstname, middlename, lastname, fullname, role, birthyear, creditedas ';
	$query .= 'FROM pmp_common_actors, pmp_actors INNER JOIN pmp_film ON pmp_film.id = pmp_actors.id WHERE ';
	if (isset($_GET['nowildcards'])) {
		$query .= '(LOWER(fullname) = ? OR LOWER(role) = ? OR LOWER(creditedas) = ?) ';
	}
	else {
		$query .= '(LOWER(fullname) LIKE ? OR LOWER(role) LIKE ? OR LOWER(creditedas) LIKE ?%) ';
		$searchstr = '%'.$searchstr.'%';
	}
	if (!empty($birthyear)) {
		$query .= 'AND birthyear = ? ';
	}
	$query .= 'AND pmp_common_actors.actor_id = pmp_actors.actor_id ';
	$query .= 'AND pmp_common_actors.fullname != "[DIVIDER]" ';
	$query .= 'AND pmp_actors.id NOT IN (SELECT id FROM pmp_tags where name = ?) ';
	$query .= 'GROUP BY pmp_actors.id ';
	$query .= 'ORDER BY birthyear, lastname, firstname, sorttitle';
		
	if (!empty($birthyear)) {
		$params = [$searchstr, $searchstr, $searchstr, $birthyear, $pmp_exclude_tag];
	}
	else {
		$params = [$searchstr, $searchstr, $searchstr, $pmp_exclude_tag];
	}

	$rows = dbquery_pdo($query, $params, 'object');

	if (count($rows) > 0) {
		foreach ($rows as $row) {
			// Get headshot
			$row->picname = getHeadshot($row->fullname, $row->birthyear, $row->firstname, $row->middlename, $row->lastname);
			// If not found set blank
			if (empty($row->picname)) {
				$row->picname = 'blank.jpg';
			}
			$row->fullname = $row->fullname;
			$row->role = $row->role;
			$row->creditedas = $row->creditedas;
			$row->DVD = new smallDVD($row->id);
			$cast[] = $row;
		}
	}

	// Crew search
	$sql  = 'SELECT DISTINCT pmp_credits.id, firstname, middlename, lastname, fullname, type, subtype, birthyear, creditedas ';
	$sql .= 'FROM pmp_common_credits, pmp_credits INNER JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE LOWER(fullname) ';
	if ( isset($_GET['nowildcards']) ) {
		$sql .= '= \'' . $searchstr . '\' ';
	}
	else {
		$sql .= 'LIKE \'%' . $searchstr . '%\' ';
	}
	if ( !empty($birthyear) ) {
		$sql .= 'AND birthyear = \'' . $birthyear. '\' ';
	}
	$sql .= 'AND pmp_common_credits.credit_id = pmp_credits.credit_id ';
	$sql .= 'AND pmp_common_credits.fullname != "[DIVIDER]" ';
	$sql .= 'AND pmp_credits.id NOT IN (SELECT id FROM pmp_tags where name = \'' . mysql_real_escape_string($pmp_exclude_tag) . '\') ';
	$sql .= 'ORDER BY birthyear, lastname, firstname, sorttitle, type';

	$result = dbexec($sql);
	if ( mysql_num_rows($result) > 0 ) {
		while ( $row = mysql_fetch_object($result) ) {
			// Get headshot
			$row->picname = getHeadshot($row->fullname, $row->birthyear, $row->firstname, $row->middlename, $row->lastname);
			// If no found set blank
			if ( empty($row->picname) ) {
				$row->picname = 'blank.jpg';
			}
			$row->fullname = $row->fullname;
			$row->creditedas = $row->creditedas;
			$row->DVD = new smallDVD($row->id);
			$crew[] = $row;
		}
	}
}

$smarty->assign('cast', $cast);
$smarty->assign('crew', $crew);
$smarty->assign('name', $name);

$smarty->display('searchperson.tpl');
?>
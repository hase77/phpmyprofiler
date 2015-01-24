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

$name = '';
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
	$searchstr = trim($searchstr);
	if (!$nowildcards) {
		$searchstr = '%'.$searchstr.'%';
	}

	// Actor search (+Rolename)
	$query  = 'SELECT COUNT(pmp_actors.id) AS episodes, pmp_actors.id, firstname, middlename, lastname, fullname, role, birthyear, creditedas ';
	$query .= 'FROM pmp_common_actors, pmp_actors INNER JOIN pmp_film ON pmp_film.id = pmp_actors.id WHERE ';
	if (!$nowildcards) {
		$query .= '(LOWER(fullname) LIKE ? OR LOWER(role) LIKE ? OR LOWER(creditedas) LIKE ?) ';
	}
	else {
		$query .= '(LOWER(fullname) = ? OR LOWER(role) = ? OR LOWER(creditedas) = ?) ';
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
	$rows = null;

	// Crew search
	$query  = 'SELECT DISTINCT pmp_credits.id, firstname, middlename, lastname, fullname, type, subtype, birthyear, creditedas ';
	$query .= 'FROM pmp_common_credits, pmp_credits INNER JOIN pmp_film ON pmp_film.id = pmp_credits.id WHERE LOWER(fullname) ';
	if (!$nowildcards) {
		$query .= 'LIKE ? ';
	}
	else {
		$query .= '= ? ';
	}
	if (!empty($birthyear) ) {
		$query .= 'AND birthyear = ? ';
	}
	$query .= 'AND pmp_common_credits.credit_id = pmp_credits.credit_id ';
	$query .= 'AND pmp_common_credits.fullname != "[DIVIDER]" ';
	$query .= 'AND pmp_credits.id NOT IN (SELECT id FROM pmp_tags where name = ?) ';
	$query .= 'ORDER BY birthyear, lastname, firstname, sorttitle, type';

	if (!empty($birthyear)) {
		$params = [$searchstr, $birthyear, $pmp_exclude_tag];
	}
	else {
		$params = [$searchstr, $pmp_exclude_tag];
	}

	$rows = dbquery_pdo($query, $params, 'object');

	if (count($rows) > 0) {
		foreach ($rows as $row) {
			// Get headshot
			$row->picname = getHeadshot($row->fullname, $row->birthyear, $row->firstname, $row->middlename, $row->lastname);
			// If no found set blank
			if (empty($row->picname)) {
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
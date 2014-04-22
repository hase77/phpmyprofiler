<?PHP
/* phpMyProfiler
 * Copyright (C) 2012-2014 The phpMyProfiler project
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

/*
 * Based on a add-on by Marcus Klumpp
*/  

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'watched';

// Die if not called from index.php
if ( basename($_SERVER['PHP_SELF']) != 'index.php' ) {
	echo 'Not allowed! Possible hacking attempt detected!';
	exit();
}

$smarty = new pmp_Smarty;
$smarty->loadfilter('output','trimwhitespace');

function zero($time) {
	if ( strlen($time) <= 1) $time = 0 . $time;
	return $time;
}

function getTime($row) {
	$row->days = floor($row->time/(24*60));
	$row->hours = zero(floor(($row->time/(24*60) - $row->days) * 24));
	$row->minutes = zero(floor((($row->time/(24*60) - $row->days) * 24 - $row->hours) * 60));
	return $row;
}

dbconnect();

$persons = $years = $months = $movies = $results = array();
$fn = $ln = $year = $month = '';
$w_orderby = "title";
$w_orderdir = "asc";

if ( isset($_GET['fn']) ) $fn = $_GET['fn'];
if ( isset($_GET['ln']) ) $ln = $_GET['ln'];
if ( isset($_GET['year']) ) $year = $_GET['year'];
if ( isset($_GET['month']) ) $month = $_GET['month'];
$month_name = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

if ( isset($_GET['w_orderby']) ) $w_orderby = $_GET['w_orderby'];
if ( isset($_GET['w_orderdir']) ) $w_orderdir = $_GET['w_orderdir'];

// Who's watching
$sql ="SELECT lastname, firstname, SUM(runningtime) AS time, COUNT(*) AS cnt, (SUM(runningtime)/COUNT(*)) AS avg ";
$sql.="FROM pmp_events INNER JOIN pmp_film ON pmp_events.id = pmp_film.id LEFT JOIN pmp_users ON pmp_events.user_id = pmp_users.user_id ";
$sql.="WHERE eventtype = 'Watched'";
$sql.="GROUP BY lastname, firstname ORDER BY cnt DESC";
$res = dbexec($sql);
if (mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_object($res)) {
		$row->avg = ceil($row->avg);
		$row = getTime($row);
		$persons[] = $row;  
	}  
}

// When has been watched (years)
$sql ="SELECT substring(timestamp,1,4) AS year, lastname, firstname, SUM(runningtime) AS time, COUNT(*) AS cnt, (SUM(runningtime)/COUNT(*)) AS avg ";
$sql.="FROM pmp_events INNER JOIN pmp_film ON pmp_events.id = pmp_film.id LEFT JOIN pmp_users ON pmp_events.user_id = pmp_users.user_id ";
$sql.="WHERE eventtype = 'Watched' AND firstname = '$fn' AND lastname = '$ln'";
$sql.="GROUP BY substring(timestamp,1,4) ORDER BY year DESC";
$res = dbexec($sql);
if (mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_object($res)) {
		$row->avg = ceil($row->avg);
		$row = getTime($row);
		$years[] = $row;
	}  
}

// When has been watched (months)
$sql ="SELECT substring(timestamp,1,4) AS year, substring(timestamp,6,2) AS month, SUM(runningtime) AS time, COUNT(*) AS cnt, (SUM(runningtime)/COUNT(*)) AS avg ";
$sql.="FROM pmp_events INNER JOIN pmp_film ON pmp_events.id = pmp_film.id LEFT JOIN pmp_users ON pmp_events.user_id = pmp_users.user_id ";
$sql.="WHERE eventtype = 'Watched' AND firstname = '$fn' AND lastname = '$ln' AND substring(timestamp,1,4) = '$year'";
$sql.="GROUP BY substring(timestamp,6,2) ORDER BY month DESC";
$res = dbexec($sql);
if (mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_object($res)) {
		if ($row->month != "10") {
			$row->monthname = str_replace("0", "", $row->month);
		} else {
			$row->monthname = $row->month;
		}
		$row->monthname = $month_name[$row->monthname];
		$row->avg = ceil($row->avg);
		$row = getTime($row);
		$months[] = $row;
	}  
}

// What has been watched in a month
$sql ="SELECT pmp_film.id, title, runningtime, substring(timestamp,1,4) AS year, substring(timestamp,6,2) AS month, substring(timestamp,9,2) AS day ";
$sql.="FROM pmp_events INNER JOIN pmp_film ON pmp_events.id = pmp_film.id LEFT JOIN pmp_users ON pmp_events.user_id = pmp_users.user_id ";
$sql.="WHERE eventtype = 'Watched' AND firstname = '$fn' AND lastname = '$ln' AND substring(timestamp,1,4) = '$year' AND substring(timestamp,6,2) = '$month' ";
$sql.="ORDER BY " . $w_orderby . " " . $w_orderdir;
$res = dbexec($sql);
if (mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_object($res)) {
		$row->date = $row->day . "." . $row->month . "." . $row->year;
		$movies[] = $row;
	}  
}

// Statistical data
$sql ="SELECT SUM(runningtime) AS time, COUNT(*) AS cnt, (SUM(runningtime)/COUNT(*)) AS avg ";
$sql.="FROM pmp_events INNER JOIN pmp_film ON pmp_events.id = pmp_film.id ";
$sql.="WHERE eventtype = 'Watched'";
$res = dbexec($sql);
if (mysql_num_rows($res) > 0) {
	while($row = mysql_fetch_object($res)) {
		$row->avg = ceil($row->avg);
		$row = getTime($row);
		$results[] = $row;
	}  
}

// Swap sort order at last
if ( $w_orderdir == "asc") {
	$w_orderdir = "desc";
} else {
	$w_orderdir = "asc";
}

dbclose();

$smarty->assign('fn',$fn);
$smarty->assign('ln',$ln);
$smarty->assign('yr',$year);
$smarty->assign('mo',$month);
$smarty->assign('w_orderdir', $w_orderdir);

$smarty->assign('persons',$persons);
$smarty->assign('years',$years);
$smarty->assign('months',$months);
$smarty->assign('movies',$movies);
$smarty->assign('results',$results);

$smarty->display('watched.tpl');
?>
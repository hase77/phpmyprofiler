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

$pmp_module = 'statistics';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

dbconnect();

// Number of DVDs
$query = 'SELECT data FROM pmp_statistics WHERE type = \'all\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('count_all', mysql_result($result, 0, 'data'));
}

if ( $pmp_statistic_showprice == true ) {
	// Number of DVDs with purch price entered
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'price_count\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$smarty->assign('count_price', mysql_result($result, 0, 'data'));
	}

	// Price of all DVDs
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'purchprice\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$smarty->assign('price_sum', number_format(mysql_result($result, 0, 'data'), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep));
	}

	// Average Price
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'average_price\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$smarty->assign('average', number_format(mysql_result($result, 0, 'data'), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep));
	}

	// Most expensive DVDs
	$query = 'SELECT value FROM pmp_statistics WHERE type = \'highest_price\' ORDER BY LPAD(data, 20, \'0\') DESC';
	$result = dbexec($query);
	while ( $row = mysql_fetch_object($result) ) {
		$expensive[] = new smallDVD($row->value);
	}
	if ( mysql_num_rows($result) > 0 ) {
		$smarty->assign('expensive', $expensive);
	}

	// Most cheapest DVDs
	$query = 'SELECT value FROM pmp_statistics WHERE type = \'lowest_price\' ORDER BY LPAD(data, 20, \'0\') ASC';
	$result = dbexec($query);
	while ( $row = mysql_fetch_object($result) ) {
		$cheapest[] = new smallDVD($row->value);
	}
	if ( mysql_num_rows($result) > 0 ) {
		$smarty->assign('cheapest', $cheapest);
	}
}

// Number of DVDs with collectionnumber
$query = 'SELECT data FROM pmp_statistics WHERE type = \'number_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('count_number', mysql_result($result, 0, 'data'));
}

// Number of DVDs with rating
$query = 'SELECT data FROM pmp_statistics WHERE type = \'rating_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('count_rating', mysql_result($result, 0, 'data'));
}

// Number of DVDs without any childprofiles
$query = 'SELECT data FROM pmp_statistics WHERE type = \'mainprofiles\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('withoutchilds', mysql_result($result, 0, 'data'));
}

// Number of DVDs with childprifles
$query = 'SELECT data FROM pmp_statistics WHERE type = \'boxsets\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('boxsets', mysql_result($result, 0, 'data'));
}

// Number of childprofiles
$query = 'SELECT data FROM pmp_statistics WHERE type = \'childs\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('childs', mysql_result($result, 0, 'data'));
}

// DVDs with Runningtime
$length_count = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'runtime_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$length_count =  mysql_result($result, 0, 'data');
	$smarty->assign('length_count', $length_count);
}

// Length of all DVDs
$query = 'SELECT data FROM pmp_statistics WHERE type = \'runtime_sum\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$length_sum = mysql_result($result, 0, 'data');
	$smarty->assign('length_sum', $length_sum);
	$smarty->assign('length_sum_hours', $length_sum/60);
	$smarty->assign('length_sum_days', $length_sum/1440);
	$smarty->assign('length_sum_weeks', $length_sum/10080);
	$smarty->assign('length_sum_months', $length_sum/43200);
	$smarty->assign('length_sum_years', $length_sum/525600);
	$smarty->assign('length_avg', $length_sum/$length_count);
}

// Longest DVDs
$query = 'SELECT value FROM pmp_statistics WHERE type = \'longest\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$long[] = new smallDVD($row->value);
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('longest', $long);
}

// Shortest DVDs
$query = 'SELECT value FROM pmp_statistics WHERE type = \'shortest\' ORDER BY LPAD(data, 20, \'0\') ASC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$short[] = new smallDVD($row->value);
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('shortest', $short);
}

// Ratings
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'ratings\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$rating[] = array('name' => $row->name, 'data' => $row->data);
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('ratings', $rating);
}

// Year of Purchase
$query = 'SELECT name, value, data FROM pmp_statistics WHERE type = \'purchdate\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$date[] = $row;
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('dates', $date);
}

// Productiondecade
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'decade\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$year[] = $row;
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('years', $year);
}

// Purchplace
$query = 'SELECT name, value, data FROM pmp_statistics WHERE type = \'purchplace_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$place[] = $row;
}
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('places', $place);
}

// Top 10 Genres
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'genres_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$genre[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('genres', $genre);
}

// Top 10 Studios
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'studios_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$studio[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('studios', $studio);
}

// Top 10 Media Companies
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'company_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$companies[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('companies', $companies);
}

// Regions
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'regions\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$region[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('regions', $region);
}

// Origins
$origin = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'origins\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$origin[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('origins', $origin);
}

// Localities
$locality = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'localities\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$locality[] = $row;
}
if (mysql_num_rows($result) > 0) {
	$smarty->assign('localities', $locality);
}

// Visitors
$query = 'SELECT MAX(id) AS num from pmp_counter';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('visitors', mysql_result($result, 0, 'num'));
}

$query = 'SELECT MAX(id) AS num from pmp_counter_profil';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$smarty->assign('profiles', mysql_result($result, 0, 'num'));
}

dbclose();

$smarty->display('statistics.tpl');
?>
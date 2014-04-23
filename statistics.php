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
$count_all = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'all\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$count_all = mysql_result($result, 0, 'data');
}
$smarty->assign('count_all', $count_all);

if ( $pmp_statistic_showprice == true ) {
	// Number of DVDs with purch price entered
	$count_price = 0;
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'price_count\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$count_price = mysql_result($result, 0, 'data');
	}
	$smarty->assign('count_price', $count_price);

	// Price of all DVDs
	$price_sum = 0;
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'purchprice\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$price_sum = mysql_result($result, 0, 'data');
	}
	$smarty->assign('price_sum', number_format($price_sum, get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep));

	// Average Price
	$average = 0;
	$query = 'SELECT data FROM pmp_statistics WHERE type = \'average_price\'';
	$result = dbexec($query);
	if ( mysql_num_rows($result) > 0 ) {
		$average = mysql_result($result, 0, 'data');
	}
	$smarty->assign('average', number_format($average, get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep));

	// Most expensive DVDs
	$expensive = array();
	$query = 'SELECT value FROM pmp_statistics WHERE type = \'highest_price\' ORDER BY LPAD(data, 20, \'0\') DESC';
	$result = dbexec($query);
	while ( $row = mysql_fetch_object($result) ) {
		$expensive[] = new smallDVD($row->value);
	}
	$smarty->assign('expensive', $expensive);

	// Most cheapest DVDs
	$cheapest = array();
	$query = 'SELECT value FROM pmp_statistics WHERE type = \'lowest_price\' ORDER BY LPAD(data, 20, \'0\') ASC';
	$result = dbexec($query);
	while ( $row = mysql_fetch_object($result) ) {
		$cheapest[] = new smallDVD($row->value);
	}
	$smarty->assign('cheapest', $cheapest);
}

// Number of DVDs with collectionnumber
$count_number = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'number_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$count_number =mysql_result($result, 0, 'data');
}
$smarty->assign('count_number', $count_number);

// Number of DVDs with rating
$count_rating = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'rating_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$count_rating = mysql_result($result, 0, 'data');
}
$smarty->assign('count_rating', $count_rating);

// Number of DVDs without any childprofiles
$withoutchilds = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'mainprofiles\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$withoutchilds = mysql_result($result, 0, 'data');
}
$smarty->assign('withoutchilds', $withoutchilds);

// Number of DVDs with childprifles
$boxsets = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'boxsets\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$boxsets =  mysql_result($result, 0, 'data');
}
$smarty->assign('boxsets', $boxsets);

// Number of childprofiles
$childs = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'childs\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$childs = mysql_result($result, 0, 'data');
}
$smarty->assign('childs', $childs);

// DVDs with Runningtime
$length_count = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'runtime_count\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$length_count =  mysql_result($result, 0, 'data');
}
$smarty->assign('length_count', $length_count);

// Length of all DVDs
$length_sum = 0;
$query = 'SELECT data FROM pmp_statistics WHERE type = \'runtime_sum\'';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$length_sum = mysql_result($result, 0, 'data');
}
$smarty->assign('length_sum', $length_sum);
$smarty->assign('length_sum_hours', $length_sum/60);
$smarty->assign('length_sum_days', $length_sum/1440);
$smarty->assign('length_sum_weeks', $length_sum/10080);
$smarty->assign('length_sum_months', $length_sum/43200);
$smarty->assign('length_sum_years', $length_sum/525600);
if ( $length_count > 0 ) {
	$smarty->assign('length_avg', $length_sum/$length_count);
}
else {
	$smarty->assign('length_avg', 0);
}

// Longest DVDs
$long = array();
$query = 'SELECT value FROM pmp_statistics WHERE type = \'longest\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$long[] = new smallDVD($row->value);
}
$smarty->assign('longest', $long);

// Shortest DVDs
$short = array();
$query = 'SELECT value FROM pmp_statistics WHERE type = \'shortest\' ORDER BY LPAD(data, 20, \'0\') ASC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$short[] = new smallDVD($row->value);
}
$smarty->assign('shortest', $short);

// Ratings
$rating = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'ratings\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$rating[] = array('name' => $row->name, 'data' => $row->data);
}
$smarty->assign('ratings', $rating);

// Year of Purchase
$date = array();
$query = 'SELECT name, value, data FROM pmp_statistics WHERE type = \'purchdate\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$date[] = $row;
}
$smarty->assign('dates', $date);

// Productiondecade
$year = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'decade\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$year[] = $row;
}
$smarty->assign('years', $year);

// Purchplace
$place = array();
$query = 'SELECT name, value, data FROM pmp_statistics WHERE type = \'purchplace_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ( $row = mysql_fetch_object($result) ) {
	$place[] = $row;
}
$smarty->assign('places', $place);

// Top 10 Genres
$genre = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'genres_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$genre[] = $row;
}
$smarty->assign('genres', $genre);

// Top 10 Studios
$studio = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'studios_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$studio[] = $row;
}
$smarty->assign('studios', $studio);

// Top 10 Media Companies
$companies = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'company_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$companies[] = $row;
}
$smarty->assign('companies', $companies);

// Regions
$region = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'regions\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$region[] = $row;
}
$smarty->assign('regions', $region);

// Origins
$origin = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'origins\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$origin[] = $row;
}
$smarty->assign('origins', $origin);

// Localities
$locality = array();
$query = 'SELECT name, data FROM pmp_statistics WHERE type = \'localities\' ORDER BY LPAD(data, 20, \'0\') DESC';
$result = dbexec($query);
while ($row = mysql_fetch_object($result)) {
	$locality[] = $row;
}
$smarty->assign('localities', $locality);

// Visitors
$visitors = 0;
$query = 'SELECT MAX(id) AS num from pmp_counter';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$visitors = mysql_result($result, 0, 'num');
}
$smarty->assign('visitors', $visitors);

$profiles = 0;
$query = 'SELECT MAX(id) AS num from pmp_counter_profil';
$result = dbexec($query);
if ( mysql_num_rows($result) > 0 ) {
	$profiles = mysql_result($result, 0, 'num');
}
$smarty->assign('profiles', $profiles);

dbclose();

$smarty->display('statistics.tpl');
?>
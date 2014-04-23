<?php
/* phpMyProfiler
 * Copyright (C) 2008-2014 The phpMyProfiler project
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

class updateStats {

	public function update() {
		global $pmp_usecurrency, $pmp_exclude_tag, $pmp_use_countas;

		$pmp_collections = get_collections();

		$usedcurrencies = array();

		// Truncate Stats Table
		dbexec('DELETE FROM pmp_statistics WHERE type != \'last_login\';');

		// Last update date
		$sql = "INSERT INTO pmp_statistics VALUES ('last_update', '', '', '". date("Y-m-d") . "'),";

		// DVDs
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT COUNT(id) AS quantity FROM pmp_film";
		}
		else {
			$query = "SELECT SUM(countas) AS quantity FROM pmp_film";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " WHERE pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}

		$result = dbexec($query);
		$sql .= "('all', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Collections
		if ( isset( $pmp_collections) ) {
			foreach ( $pmp_collections as $collection ) {
				if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
					$query = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype = '" . $collection . "'";
				}
				else {
					$query = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype = '" . $collection . "'";
				}
				if ( $pmp_exclude_tag != '' ) {
					$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
				}
				$result = dbexec($query);
				$sql .= "('" . $collection . "', '', '', '". mysql_result($result, 0, "quantity") . "'),";
			}
		}

		// DVDs with Price
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01";
		}
		else {
			$query = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01";
		}
		
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('price_count', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// DVDs with Collection Number
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND collectionnumber != '0'";
		}
		else {
			$query = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND collectionnumber != '0'";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('number_count', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// DVDs with Rating
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND rating != ''";
		}
		else {
			$query = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND rating != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('rating_count', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// DVDs without Childs
		$query = "SELECT COUNT(pmp_film.id) AS quantity FROM pmp_film LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND pmp_boxset.childid IS NULL";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('mainprofiles', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Boxsets
		$query = "SELECT COUNT(DISTINCT pmp_boxset.id) AS quantity FROM pmp_boxset, pmp_film WHERE pmp_boxset.id = pmp_film.id AND pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('boxsets', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Childs
		$query = "SELECT COUNT(DISTINCT pmp_boxset.childid) AS quantity FROM pmp_boxset, pmp_film WHERE pmp_boxset.id = pmp_film.id AND pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('childs', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Price of all DVDs
		$query = "SELECT purchcurrencyid, SUM(purchprice) AS sum FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY purchcurrencyid";
		$result = dbexec($query);
		$sum = 0;
		$dvds_num = mysql_num_rows($result);
		for ($i = 0; $i < $dvds_num; $i++) {
			$sum += exchange(mysql_result($result, $i, "purchcurrencyid"), $pmp_usecurrency, mysql_result($result, $i, "sum"));
			$usedcurrencies[] = mysql_result($result, $i, "purchcurrencyid");
		}
		$sql .= "('purchprice', '', '', '". $sum . "'),";

		// Average price of DVDs
		if ( $sum > 0 ) {
			$sql .= "('average_price', '', '', '". round($sum/$dvds_num, 2) . "'),";
		}

		// Highest Price
		unset($tmp);
		if ( count($usedcurrencies) > 0 ) {
			foreach ($usedcurrencies as $curr) {
				$query = "SELECT id, purchprice FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01 AND purchcurrencyid ='$curr'";
				if ( $pmp_exclude_tag != '' ) {
					$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
				}
				$query .= " ORDER BY purchprice DESC LIMIT 3";
				$result = dbexec($query);
				while ( $row = mysql_fetch_object($result) ) {
					$tmp[$row->id] = exchange($curr, $pmp_usecurrency, $row->purchprice);
				}
			}
			arsort($tmp, SORT_NUMERIC);
			$tmp = array_keys($tmp);
			$count = count($tmp);
			if ( count($tmp) > 3) {
				$count = 3;
			}
			for ($i = 0; $i < $count; $i++) {
				$query = "SELECT id, title, purchprice FROM pmp_film WHERE id = '" . $tmp[$i] . "'";
				$result = dbexec($query);
				$row = mysql_fetch_object($result);
				$sql .= "('highest_price', '" . mysql_real_escape_string($row->title) . "', '" . $row->id . "', '". $row->purchprice . "'),";
			}
		}

		// Lowest Price
		unset($tmp);
		if ( count($usedcurrencies) > 0 ) {
			foreach ( $usedcurrencies as $curr ) {
				$query = "SELECT id, purchprice FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01 AND purchcurrencyid ='$curr'";
				if ( $pmp_exclude_tag != '' ) {
					$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
				}
				$query .= " ORDER BY purchprice ASC LIMIT 3";
				$result = dbexec($query);
				while ( $row = mysql_fetch_object($result) ) {
					$tmp[$row->id] = exchange($curr, $pmp_usecurrency, $row->purchprice);
				}
			}
			asort($tmp, SORT_NUMERIC);
			$tmp = array_keys($tmp);
			if ( count($tmp) > 3) {
				$count = 3;
			}
			for ($i = 0; $i < $count; $i++) {
				$query = "SELECT id, title, purchprice FROM pmp_film WHERE id = '" . $tmp[$i]. "'";
				$result = dbexec($query);
				$row = mysql_fetch_object($result);
				$sql .= "('lowest_price', '" . mysql_real_escape_string($row->title) . "', '" . $row->id . "', '". $row->purchprice . "'),";
			}
		}

		// DVDs with Runningtime
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND runningtime > 0";
		}
		else {
			$query = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND runningtime > 0";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('runtime_count', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Sum of Runningtime
		$query = "SELECT SUM(runningtime) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND runningtime > 0";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$result = dbexec($query);
		$sql .= "('runtime_sum', '', '', '". mysql_result($result, 0, "quantity") . "'),";

		// Longest DVDs
		$query = "SELECT id, title, runningtime FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND runningtime > 1";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " ORDER BY runningtime DESC LIMIT 3";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('longest', '" . mysql_real_escape_string($row->title) . "', '".$row->id  ."', '" . $row->runningtime . "'),";
		}

		// Shortest DVDs
		$query = "SELECT id, title, runningtime FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND runningtime > 1";
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " ORDER BY runningtime ASC LIMIT 3";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('shortest', '" . mysql_real_escape_string($row->title) . "', '".$row->id  ."', '" . $row->runningtime . "'),";
		}

		// Ratings
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT rating, COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		else {
			$query = "SELECT rating, SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY rating ORDER BY quantity DESC";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('ratings', '" . $row->rating . "', '', '" . $row->quantity . "'),";
		}

		// Top 10 Purchplace
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT purchplace, COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchplace != ''";
		}
		else {
			$query = "SELECT purchplace, SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchplace != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY purchplace ORDER BY quantity DESC LIMIT 10";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sum = 0;
			if ( count($usedcurrencies) > 0 ) {
				foreach ( $usedcurrencies as $curr ) {
					$query = "SELECT SUM(purchprice) AS sum FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01 AND purchplace = '" . $row->purchplace . "' AND purchcurrencyid ='". $curr . "'";
					if ( $pmp_exclude_tag != '' ) {
						$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
					}
					$query .= " GROUP BY purchcurrencyid";
					$res = dbexec($query);
					while ( $row2 = mysql_fetch_object($res) ) {
						$sum += exchange($curr, $pmp_usecurrency, $row2->sum);
					}
				}
			}
			$sql .= "('purchplace_top10', '" . mysql_real_escape_string($row->purchplace) . "', '" . $sum . "', '" . $row->quantity . "'),";
		}

		// Year of Purchase
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT YEAR(purchdate) AS date, COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchdate != ''";
		}
		else {
			$query = "SELECT YEAR(purchdate) AS date, SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchdate != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY date";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$query = "SELECT purchcurrencyid, SUM(purchprice) AS sum FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND purchprice >= 0.01 AND YEAR(purchdate) = '" . $row->date . "' AND purchdate != ''";
			if ( $pmp_exclude_tag != '' ) {
				$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
			}
			$query .= " GROUP BY purchcurrencyid";
			$res = dbexec($query);
			$sum = 0;
			while ( $row2 = mysql_fetch_object($res) ) {
				$sum +=  exchange($row2->purchcurrencyid, $pmp_usecurrency, $row2->sum);
			}
			$sql .= "('purchdate', '" . $row->date  . "', '" . $sum . "', '" . $row->quantity . "'),";
		}

		// Production Decade
		for ($i = 1920; $i < 2020; $i += 10) {
			if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
				$query  = "SELECT COUNT(id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND prodyear >= '" . $i . "' AND prodyear <= '" . ($i+9) . "'";
			}
			else {
				$query  = "SELECT SUM(countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND prodyear >= '" . $i . "' AND prodyear <= '" . ($i+9) . "'";
			}
			if ( $pmp_exclude_tag != '' ) {
				$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
			}
			$result = dbexec($query);
			$sql .= "('decade', '" . $i . "-" . ($i+9) . "', '', '" . mysql_result($result, 0, "quantity") . "'),";
		}

		// Top 10 Genres
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT genre, COUNT(pmp_film.id) AS quantity FROM pmp_genres LEFT JOIN pmp_film ON pmp_film.id = pmp_genres.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		else {
			$query = "SELECT genre, SUM(pmp_film.countas) AS quantity FROM pmp_genres LEFT JOIN pmp_film ON pmp_film.id = pmp_genres.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY genre ORDER BY quantity DESC LIMIT 10";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('genres_top10', '" . mysql_real_escape_string($row->genre) . "', '', '" . $row->quantity . "'),";
		}

		// Top 10 Studios
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT studio, COUNT(pmp_film.id) AS quantity FROM pmp_studios LEFT JOIN pmp_film ON pmp_film.id = pmp_studios.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		else {
			$query = "SELECT studio, SUM(pmp_film.countas) AS quantity FROM pmp_studios LEFT JOIN pmp_film ON pmp_film.id = pmp_studios.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY studio ORDER BY quantity DESC LIMIT 10";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('studios_top10', '" . mysql_real_escape_string($row->studio) . "', '', '" . $row->quantity . "'),";
		}

		// Top 10 Media Companies
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT company, COUNT(pmp_film.id) AS quantity FROM pmp_media_companies LEFT JOIN pmp_film ON pmp_film.id = pmp_media_companies.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND company != ''";
		}
		else {
			$query = "SELECT company, SUM(pmp_film.countas) AS quantity FROM pmp_media_companies LEFT JOIN pmp_film ON pmp_film.id = pmp_media_companies.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND company != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY company ORDER BY quantity DESC LIMIT 10";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('company_top10', '" . mysql_real_escape_string($row->company) . "', '', '" . $row->quantity . "'),";
		}

		// Regions
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT region, COUNT(pmp_film.id) AS quantity FROM pmp_regions LEFT JOIN pmp_film ON pmp_film.id = pmp_regions.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		else {
			$query = "SELECT region, SUM(pmp_film.countas) AS quantity FROM pmp_regions LEFT JOIN pmp_film ON pmp_film.id = pmp_regions.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List'";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY region";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('regions', '" . $row->region  . "', '', '" . $row->quantity . "'),";
		}

		// Origins
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT country, COUNT(pmp_film.id) AS quantity FROM pmp_countries_of_origin LEFT JOIN pmp_film ON pmp_film.id = pmp_countries_of_origin.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND country != ''";
		}
		else {
			$query = "SELECT country, SUM(pmp_film.countas) AS quantity FROM pmp_countries_of_origin LEFT JOIN pmp_film ON pmp_film.id = pmp_countries_of_origin.id WHERE pmp_film.collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND country != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY country ORDER BY quantity DESC";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('origins', '" . mysql_real_escape_string($row->country) . "', '', '" . $row->quantity . "'),";
		}

		// Localities
		if ( isset($pmp_use_countas) && $pmp_use_countas == "0") {
			$query = "SELECT locality, COUNT(pmp_film.id) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND locality != ''";
		}
		else {
			$query = "SELECT locality, SUM(pmp_film.countas) AS quantity FROM pmp_film WHERE collectiontype != 'Ordered' AND collectiontype != 'Wish List' AND locality != ''";
		}
		if ( $pmp_exclude_tag != '' ) {
			$query .= " AND pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
		}
		$query .= " GROUP BY locality ORDER BY quantity DESC";
		$result = dbexec($query);
		while ( $row = mysql_fetch_object($result) ) {
			$sql .= "('localities', '" . mysql_real_escape_string($row->locality) . "', '', '" . $row->quantity . "'),";
		}

		$sql[strlen($sql)-1] = ';';
		dbexec($sql);

		// Optimize and analyze tables
		$result = dbexec('SHOW TABLES');
		while ( $table = mysql_fetch_row($result) ) {
			dbexec('OPTIMIZE TABLE ' . $table[0]);
		}

		$result = dbexec('SHOW TABLES');
		while ( $table = mysql_fetch_row($result) ) {
			dbexec('ANALYZE TABLE ' . $table[0]);
		}
	}
}
?>
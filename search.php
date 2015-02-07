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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
*/

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'search';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->caching = $pmp_smarty_caching;
$smarty->cache_lifetime = $pmp_cache_lifetime;

// We don't need to get all fields new from db with every calling
if ( !$smarty->isCached('search.tpl') ) {
	dbconnect();

	$Locations = array();
	$sql = 'SELECT DISTINCT locality FROM pmp_film ORDER BY locality';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Locations[] = $row->locality;
	}
	$smarty->assign('Locations', $Locations);

	$Origins = array();
	$sql = 'SELECT DISTINCT country FROM pmp_countries_of_origin WHERE country != \'\' ORDER BY country';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Origins[] = $row->country;
	}
	$smarty->assign('Origins', $Origins);

	$Studios = array();
	$sql = 'SELECT DISTINCT studio FROM pmp_studios WHERE studio != \'\' ORDER BY studio';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Studios[] = htmlspecialchars($row->studio, ENT_COMPAT, 'UTF-8');
	}
	$smarty->assign('Studios', $Studios);

	$MediaCompanies = array();
	$sql = 'SELECT DISTINCT company FROM pmp_media_companies WHERE company != \'\' ORDER BY company';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$MediaCompanies[] = htmlspecialchars($row->company, ENT_COMPAT, 'UTF-8');
	}
	$smarty->assign('MediaCompanies', $MediaCompanies);

	$Genres = array();
	$sql = 'SELECT DISTINCT genre FROM pmp_genres WHERE genre != \'\' ORDER BY genre';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Genres[] = $row->genre;
	}
	$smarty->assign('Genres', $Genres);

	$Tags = array();
	$sql = 'SELECT DISTINCT name FROM pmp_tags WHERE name != \'\' ORDER BY name';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		if ( $row->name != $pmp_exclude_tag ) {
			$Tags[] = $row->name;
		}
	}
	$smarty->assign('Tags', $Tags);

	$Audio = array();
	$sql = 'SELECT DISTINCT format FROM pmp_audio WHERE format != \'\' ORDER BY format';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Audio[] = $row->format;
	}
	$smarty->assign('Audio', $Audio);

	$Language = array();
	$sql = 'SELECT DISTINCT content FROM pmp_audio WHERE content != \'\' ORDER BY content';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Language[] = $row->content;
	}
	$smarty->assign('Language', $Language);

	$Subtitle = array();
	$sql = 'SELECT DISTINCT subtitle FROM pmp_subtitles WHERE subtitle != \'\' ORDER BY subtitle';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Subtitle[] = $row->subtitle;
	}
	$smarty->assign('Subtitle', $Subtitle);

	$Regioncode = array();
	$sql = 'SELECT DISTINCT region FROM pmp_regions WHERE region != \'\' ORDER BY region';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Regioncode[] = $row->region;
	}
	$smarty->assign('Regioncode', $Regioncode);

	$Rating = array();
	$sql = 'SELECT DISTINCT rating FROM pmp_film WHERE rating != \'\' ORDER BY rating';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Rating[] = $row->rating;
	}
	$smarty->assign('Rating', $Rating);

	$Casetype = array();
	$sql = 'SELECT DISTINCT casetype FROM pmp_film WHERE casetype != \'\' ORDER BY casetype';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Casetype[] = $row->casetype;
	}
	$smarty->assign('Casetype', $Casetype);

	$Media = array();
	$sql = 'SELECT DISTINCT media_custom FROM pmp_film WHERE media_custom != \'\' ORDER BY media_custom';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Media[] = $row->media_custom;
	}
	$smarty->assign('Media', $Media);

	$MediaDVD = 0;
	$sql = 'SELECT COUNT(media_dvd) AS value FROM pmp_film WHERE media_dvd != \'0\'';
	$res = dbexec($sql);
	$row = mysql_fetch_row($res);
	$MediaDVD = $row[0];
	$smarty->assign('MediaDVD', $MediaDVD);

	$MediaHDDVD = 0;
	$sql = 'SELECT COUNT(media_hddvd) AS value FROM pmp_film WHERE media_hddvd != \'0\'';
	$res = dbexec($sql);
	$row = mysql_fetch_row($res);
	$MediaHDDVD = $row[0];
	$smarty->assign('MediaHDDVD', $MediaHDDVD);

	$MediaBluray = 0;
	$sql = 'SELECT COUNT(media_bluray) AS value FROM pmp_film WHERE media_bluray != \'0\'';
	$res = dbexec($sql);
	$row = mysql_fetch_row($res);
	$MediaBluray = $row[0];
	$smarty->assign('MediaBluray', $MediaBluray);

	$Purchplace = array();
	$sql = 'SELECT DISTINCT purchplace FROM pmp_film WHERE purchplace != \'\' ORDER BY purchplace';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Purchplace[] = $row->purchplace;
	}
	$smarty->assign('Purchplace', $Purchplace);

	$Prodyear = array();
	$sql= 'SELECT DISTINCT prodyear FROM pmp_film WHERE prodyear != \'\' ORDER BY prodyear';
	$res = dbexec($sql);
	while ( $row = mysql_fetch_object($res) ) {
		$Prodyear[] = $row->prodyear;
	}
	$smarty->assign('Prodyear', $Prodyear);
}

$smarty->display('search.tpl');
?>
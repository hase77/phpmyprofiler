<?php
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

function getIMDBSite($id) {
	$site = getRemoteContent('http://www.imdb.com/title/tt' . $id . '/');
	return $site;
}

function getOFDBSite($id) {
	$site = getRemoteContent('http://www.ofdb.de/film/' . $id . ',');
	return $site; 
}

function getRottenSite($id) {
	$site = getRemoteContent('http://www.rottentomatoes.com/m/' . $id . '/');
	return $site;
}

function getIMDBID($site) {
	// This function is currently unused
	if ( preg_match("@imdb.com/Title\?(\w*)\"\s*target=\"_blank\"@i", $ofdb_website, $match) ) {
		$id = $match[1];
	}
	else {
		$id = '';
	}
	return $id;
}

function getIMDBRating($site) {
	if ( preg_match('~<span itemprop="ratingValue">(.*)</span>~Ui', $site, $match) ) {
		$rating = $match[1];
	} else {
		$rating = 0;
	}
	if ( preg_match('~<span itemprop="ratingCount">(.*)</span>~Ui', $site, $match) ) {
		$votes = $match[1];
	} else {
		$votes = 0;
	}
	if ( preg_match("'Top 250 (.*?)</strong>'", $site, $match) ) {
		$top = "'".substr($match[1], 1)."'";
	} else {
		$top = 'NULL';
	}
	if ( preg_match("'Bottom 100 (.*?)</strong>'", $site, $match) ) {
		$bottom = "'".substr($match[1], 1)."'";
	} else {
		$bottom = 'NULL';
	}

	return array ($rating, $votes, $top, $bottom);
}

function getOFDBRating($site) {
	if ( preg_match("@Note:\s(\d{1,2}\.\d\d)@i", $site, $match) ) {
		$rating = $match[1];
	} else {
		$rating = 0;
	}
	if ( preg_match("'Stimmen: (.*?) &nbsp;'", $site, $match) ) {
		$votes = $match[1];
	} else {
	$votes = 0;
	}
	if ( preg_match("'Platz: (.*?) &nbsp;'", $site, $match) ) {
		$top = $match[1];
	} else {
		$top = 'NULL';
	}
	if ( $top == '--' ) {
		$top = 'NULL';
	} else {
		if ( $top > 250 ) {
			$top = 'NULL';
		}
		else {
			$top = "'".$top."'";
		}
	}
	$bottom = 'NULL';

	return array ($rating, $votes, $top, $bottom);
}

function getRottenRating($site) {
	if ( preg_match('!Average Rating: <span>([\d\.]+)/10!i', $site, $match) ) {
		$ratingCritics = $match[1];
	} else {
		$ratingCritics = 0;
	}
	if ( preg_match('!Reviews Counted: <span itemprop="reviewCount">([\d\,]+)!i', $site, $match) ) {
		$votesCritics = $match[1];
	} else {
		$votesCritics = 0;
	}
	if ( preg_match('!Average Rating: ([\d\.]+)/5!i',  $site, $match) ) {
		$ratingUser = $match[1];
	} else {
		$ratingUser = 0;
	}
	if ( preg_match('!User Ratings: ([\d\,]+)!i', $site, $match) ) {
		$votesUser = $match[1];
	} else {
		$votesUser = 0;
	}

	return array ($ratingCritics, $votesCritics, $ratingUser, $votesUser);
}

?>
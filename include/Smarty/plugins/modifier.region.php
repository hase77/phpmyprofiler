<?php
/* phpMyProfiler
 * Copyright (C) 2008-2012 The phpMyProfiler project
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

function smarty_modifier_region($region, $media) {
	global $pmp_theme;

	$pics['dvd']['0'] = 'region/0.gif';
	$pics['dvd']['1'] = 'region/1.gif';
	$pics['dvd']['2'] = 'region/2.gif';
	$pics['dvd']['3'] = 'region/3.gif';
	$pics['dvd']['4'] = 'region/4.gif';
	$pics['dvd']['5'] = 'region/5.gif';
	$pics['dvd']['6'] = 'region/6.gif';

	$pics['hd dvd/dvd combo']['0'] = 'region/0.gif';
	$pics['hd dvd/dvd combo']['1'] = 'region/1.gif';
	$pics['hd dvd/dvd combo']['2'] = 'region/2.gif';
	$pics['hd dvd/dvd combo']['3'] = 'region/3.gif';
	$pics['hd dvd/dvd combo']['4'] = 'region/4.gif';
	$pics['hd dvd/dvd combo']['5'] = 'region/5.gif';
	$pics['hd dvd/dvd combo']['6'] = 'region/6.gif';

	$pics['hd dvd']['0'] = 'region/0.gif';

	$pics['blu-ray']['0'] = 'region/0.gif';
	$pics['blu-ray']['A'] = 'region/A.gif';
	$pics['blu-ray']['B'] = 'region/B.gif';
	$pics['blu-ray']['C'] = 'region/C.gif';

	if ( $region == '0' ) {
		$title = 'All';
	}
	else {
		$title = $region;
	}

	if ( isset($pics[strtolower($media)][$region]) && is_string($pics[strtolower($media)][$region]) ) {
		return '<img src="' . _PMP_REL_PATH . '/themes/' . $pmp_theme . '/images/' . $pics[strtolower($media)][$region] . '" alt="'. $title . '" title="Region: '. $title . '" style="vertical-align: middle;" />';
	}
}
?>

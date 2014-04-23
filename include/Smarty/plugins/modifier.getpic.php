<?php
/* phpMyProfiler
 * Copyright (C) 2005-2012 The phpMyProfiler project
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

function smarty_modifier_getpic($string, $type) {
	global $pmp_theme;
	global $pmp_custom_media;

	$pics['media']['DVD'] = 'additional/DVD.png';
	$pics['media']['HD DVD'] = 'additional/HDDVD.png';
	$pics['media']['Blu-ray'] = 'additional/BluRay.png';

	// Custom media
	foreach ( $pmp_custom_media as $media => $image ) {
		$pics['media'][$media] = 'additional/' . $image['big'];
	}

	$pics['channels']['Mono'] = 'audio/1.0.gif';
	$pics['channels']['2-Channel Stereo'] = 'audio/2.0.gif';
	$pics['channels']['Dolby Surround'] = 'audio/3.0.gif';
	#$pics['channels']['3.1'] = 'audio/3.1.gif';
	$pics['channels']['4.0'] = 'audio/4.0.gif';
	$pics['channels']['4.1'] = 'audio/4.1.gif';
	$pics['channels']['5.0'] = 'audio/5.0.gif';
	$pics['channels']['5.1'] = 'audio/5.1.gif';
	$pics['channels']['5.1 (Matrixed 6.1)'] = 'audio/6.1.gif';
	$pics['channels']['6.1 (Discrete)'] = 'audio/6.1.gif';
	$pics['channels']['7.1'] = 'audio/7.1.gif';

	$pics['format']['Dolby Digital'] = 'audio/dolbydigital.gif';
	$pics['format']['Dolby Digital EX'] = 'audio/dolbydigital.gif';
	$pics['format']['Dolby Digital Plus'] = 'audio/dolbydigitalplus.png';
	$pics['format']['Dolby TrueHD'] = 'audio/dolbydigitaltruehd.png';
	$pics['format']['DTS'] = 'audio/dts.png';
	$pics['format']['DTS ES'] = 'audio/dts.png';
	$pics['format']['DTS-HD High Resolution'] = 'audio/dtshdhr.png';
	$pics['format']['DTS-HD Master Audio'] = 'audio/dtshdmaster.png';
	$pics['format']['MPEG-2'] = 'audio/mpeg2.png';
	$pics['format']['MPEG-1 Audio Layer II (MP2)'] = 'audio/mpeg2.png';
	#$pics['format']['PCM'] = 'audio/pcm.png';

	$pics['ratio']['1.66'] = 'additional/166.gif';
	$pics['ratio']['1.78'] = 'additional/178.gif';
	$pics['ratio']['1.85'] = 'additional/185.gif';
	$pics['ratio']['2.20'] = 'additional/220.gif';
	$pics['ratio']['2.35'] = 'additional/235.gif';
	$pics['ratio']['2.40'] = 'additional/240.gif';
	$pics['ratio']['2.55'] = 'additional/255.gif';

	$pics['boolean']['0'] = 'no.gif';
	$pics['boolean']['1'] = 'yes.gif';

	$pics['vote']['0'] = 'vote/0.gif';
	$pics['vote']['1'] = 'vote/1.gif';
	$pics['vote']['2'] = 'vote/2.gif';
	$pics['vote']['3'] = 'vote/3.gif';
	$pics['vote']['4'] = 'vote/4.gif';
	$pics['vote']['5'] = 'vote/5.gif';
	$pics['vote']['6'] = 'vote/6.gif';
	$pics['vote']['7'] = 'vote/7.gif';
	$pics['vote']['8'] = 'vote/8.gif';
	$pics['vote']['9'] = 'vote/9.gif';

	if ( isset($pics[strtolower($type)][$string]) && is_string($pics[strtolower($type)][$string]) ) {
		if ( $type == 'format' ) {
			return '<img src="' . _PMP_REL_PATH . '/themes/' . $pmp_theme . '/images/' . $pics[strtolower($type)][$string] . '" alt="'. $string  . '" title="'. $string . '" style="vertical-align: middle;height: 20px;" />';
		} else {
			return '<img src="' . _PMP_REL_PATH . '/themes/' . $pmp_theme . '/images/' . $pics[strtolower($type)][$string] . '" alt="'. $string  . '" title="'. $string . '" style="vertical-align: middle;" />';
		}
	}
	else {
		return $string;
	}
}
?>

<?php
/* phpMyProfiler
 * Copyright (C) 2005-2015 The phpMyProfiler project
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

// No direct or remote access
if (!isset($_SERVER['HTTP_REFERER']) || stristr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) === false) {
	die('Not allowed! Possible hacking attempt detected!');
}

require_once('config.inc.php');

$rating = filter_input(INPUT_GET, 'rating', FILTER_VALIDATE_FLOAT);
$size = filter_input(INPUT_GET, 'size', FILTER_SANITIZE_STRING);
if (filter_has_var(INPUT_GET, 'maxrate')) {
	$max = filter_input(INPUT_GET, 'maxrate', FILTER_SANITIZE_NUMBER_INT);
}
else {
	$max = 10;
}

function round_this($val) {
	return (int)($val + .5);
}

if ($pmp_gdlib == true) {
	if (!empty($size) && $size == 'big') {
		// Get back- & foreground pics
		$img_dest = imagecreatefrompng("./themes/{$pmp_theme}/images/vote/b_empty.png");
		$img_full = imagecreatefrompng("./themes/{$pmp_theme}/images/vote/b_full.png");

		// Build rated pic
		$w = (int)(200 * ($rating / $max));
		imagecopy($img_dest, $img_full, 0, 0, 0, 0, $w, 100);
		imagedestroy($img_full);

		// Build ratings
		$rating_big = (int)$rating;
		$rating_small = round_this(($rating - $rating_big) * 100);
		if ($rating_small < 10) {
			$rating_small = "0{$rating_small}";
		}

		// Write ratings
		imagettftext($img_dest, 64, 0, 16, 80, 0, "./themes/{$pmp_theme}/images/vote/font.ttf", $rating_big);
		imagettftext($img_dest, 32, 0, 60, 40, 0, "./themes/{$pmp_theme}/images/vote/font.ttf", $rating_small);

		// Show pic
		header('Content-type: image/png');
		imagepng($img_dest);
		imagedestroy($img_dest);
	}
	else {
		// Get back- & foreground pics
		$img_dest = imagecreatefrompng("./themes/{$pmp_theme}/images/vote/s_empty.png");
		$img_full = imagecreatefrompng("./themes/{$pmp_theme}/images/vote/s_full.png");

		// Build rated pic
		$w = (int)(200 * ($rating / $max));
		imagecopy($img_dest, $img_full, 0, 0, 0, 0, $w, 14);
		imagedestroy($img_full);

		// Show pic
		header('Content-type: image/png');
		imagepng($img_dest);
		imagedestroy($img_dest);
	}
}
?>
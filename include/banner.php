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

/* This script is based on an Add_on by Marcus Klumpp
*/

require_once('../include/functions.php');
require_once('../config.inc.php');

$pmp_rel_path = '..';

function entenc($text){
	// This is needed for german umlauts
	$res = '';
	for ($i = 0; $i < strlen($text); $i++) {
		$cc = ord($text{$i});
		if ($cc >= 128 || $cc == 38) {
			$res .= "&#$cc;";
		} else {
			$res .= chr($cc);
		}
	}
	return $res;
}

function thumb($id) {
	// Taken from thumbnail.php with minor changes
	global $pmp_rel_path, $pmp_thumbnail_cache, $pmp_theme;
	$src_Filename = '../cover/' . $id . 'f.jpg';
	$dst_Filename = '../cache/w50_' . $id.'f.png';

	// If no cover found show placeholder
	if ( !is_file($src_Filename) ) { 
		$src_Filename = '../themes/' . $pmp_theme . '/images/nocover.jpg';
	}
	$src_img = imagecreatefromjpeg($src_Filename);

	// Calculating thumb-size (maximum is set to 50x72)
	$old_x = imageSX($src_img);
	$new_x = 50;
	$old_y = imageSY($src_img);
	$new_y = $old_y * (50 / $old_x);
	if ( $new_y > 72 ) {
		$new_y = 72;
		$new_x = $old_x * (72 / $old_y);
	}

	// Creating thumb
	$dst_img = ImageCreateTrueColor($new_x, $new_y);
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $new_x, $new_y, $old_x, $old_y); 
	imagepng($dst_img, $dst_Filename);

	// Collecting some garbage
	imagedestroy($dst_img); 
	imagedestroy($src_img);

	return $dst_Filename;
}

function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) {
	/* simple function that calculates the *exact* bounding box (single pixel precision).
	 * The function returns an associative array with these keys:
	 * left, top:  coordinates you will pass to imagettftext
	 * width, height: dimension of the image you have to create
	*/
	$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text);
	$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
	$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
	$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
	$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));

	return array(
	 "left"   => abs($minX) - 1,
	 "top"    => abs($minY) - 1,
	 "width"  => $maxX - $minX,
	 "height" => $maxY - $minY,
	 "box"    => $rect
	);
} 

function buildBanners() {
	global $pmp_build_banners, $pmp_banner_name;
	$buildOK = true;
	dbconnect();

	// Recently added profiles
	if ( $pmp_build_banners == 1 or $pmp_build_banners == 3 ) {
		$sql = "SELECT id FROM pmp_film ORDER BY purchdate DESC LIMIT 0,10";
		if ( isset($pmp_banner_name) && $pmp_banner_name != '') {
			$title = $pmp_banner_name . ' ' . t("recently added:");
		} else {
			$title = t("Recently added:");
		}
		$buildOK = buildBanner($sql, $title, 'added');
	}

	// Recently watched movies
	if ( $pmp_build_banners == 2 or $pmp_build_banners == 3 ) {
		if ( isset($pmp_banner_name) && $pmp_banner_name != '') {
			$sql = "SELECT user_id FROM pmp_users WHERE CONCAT(firstname,' ',lastname) = '" . $pmp_banner_name . "'";
			$res = dbexec($sql);
			if ( mysql_num_rows($res) > 0 ) {
				$row = mysql_fetch_object($res);
				$sql = "SELECT id FROM pmp_events WHERE EventType = 'Watched' AND user_id = " . $row->user_id . " ORDER BY Timestamp DESC LIMIT 0,10";
			} else {
				$sql = "SELECT id FROM pmp_events WHERE EventType = 'Watched' ORDER BY Timestamp DESC LIMIT 0,10";
			}
			$title = $pmp_banner_name . ' ' . t("recently watched:");
		} else {
			$sql = "SELECT id FROM pmp_events WHERE EventType = 'Watched' ORDER BY Timestamp DESC LIMIT 0,10";
			$title = t("Recently watched:");
		}
		$buildOK = $buildOK && buildBanner($sql, $title, 'watched');
	}
	dbclose();
	return $buildOK;
}

function buildBanner($sql, $title, $prefix) {
	global $pmp_theme, $pmp_theme_css;
	$backimage = '../themes/'.$pmp_theme.'/images/banner/background_'.substr($pmp_theme_css, 0, -4).'.png';
	if ( !is_file($backimage) ) $backimage = '../themes/'.$pmp_theme.'/images/banner/background_default.png';
	$font = "../include/font/arial.ttf";
	$filename = '../cache/'.$prefix.'_banner.png';


	// Getting info from database
	$result = dbexec($sql);
	$rows = mysql_num_rows($result);

	// Creating thumbs
	if ( $rows == 0 ) {
		return false;
	} else {
		while ($row = mysql_fetch_object($result)) {
			$file = thumb($row->id);
			$thumb[] = imagecreatefrompng($file);
			unlink($file);
		}
	}

	// Creating background
	$size_img = GetImageSize($backimage);
	$img_width = $size_img[0]; 
	$img_height = $size_img[1];
	$dst_img = imagecreatefrompng($backimage);
	imagealphablending($dst_img, true); // setting alpha blending on
	imagesavealpha($dst_img, true); // save alphablending setting (important)

	// Placing thumbs on background
	$pos_x = 9;
	for ($i = 0; $i < $rows; $i++) {
		$th_width = imageSX($thumb[$i]);
		$th_height = imageSY($thumb[$i]);
		imagecopy($dst_img, $thumb[$i], intval($pos_x+((50-$th_width)/2)), intval(22+((72-$th_height)/2)), 0, 0, 50, $th_height);
		$pos_x = $pos_x + 53; //50px Thumbnail + 3px space in between;
	}

	// Creating text
	$title = entenc(html_entity_decode($title));
	$color = imagecolorallocate($dst_img, 255, 255, 255);
	$the_box = calculateTextBox($title, $font, 11, 0); 
	imagettftext($dst_img, 11, 0,
		$the_box["left"] + ($img_width / 2) - ($the_box["width"] / 2),
		!$img_height+15, $color, $font, $title); 

	// Saving banner
	if (imagepng($dst_img,$filename)) {
		imagedestroy($dst_img);
		return true;
	} else {
		imagedestroy($dst_img);
		return false;
	}
}
?>
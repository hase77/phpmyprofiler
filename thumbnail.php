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

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$width = filter_input(INPUT_GET, 'width', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

// Check for id
if (empty($id)) {
	die('No id given!');
}

define('_PMP_REL_PATH', '.');

require_once('config.inc.php');
require_once('include/functions.php');

switch ($type) {
	case 'front':
		$sourceFilename = $id.'f.jpg';
		break;
	case 'back':
		$sourceFilename = $id.'b.jpg';
		break;
}

if ($pmp_gdlib == true) {
	// If no cover found show placeholder
	if (!is_file("./cover/{$sourceFilename}")) {
		if (is_file("./themes/{$pmp_theme}/images/w{$width}_nocover.jpg")) {
			$sourceFilename = "./themes/{$pmp_theme}/images/w{$width}_nocover.jpg";
		}
		else {
			$sourceFilename = "./themes/{$pmp_theme}'/images/nocover.jpg";
		}

		header('Content-Type: image/jpeg');
		header('Cache-Control: must-revalidate');
		header($ExpStr);
		header("Content-Disposition: inline; filename={$sourceFilename};");
		readfile($sourceFilename);
	}
	else {
		$hash = md5_file("./cover/{$sourceFilename}");

		// Thumbnail exist?
		if (is_file("./cache/w{$width}_{$hash}_{$sourceFilename}")) {
			$sourceFilename = "./cache/w{$width}_{$hash}_{$sourceFilename}";
			header('Content-Type: image/jpeg');
			header('Cache-Control: must-revalidate');
			header($ExpStr);
			header("Content-Disposition: inline; filename={$sourceFilename};");
			readfile($sourceFilename);
		}
		else {
			// Get media and casetype
			dbconnect_pdo();
			
			$query = 'SELECT media_dvd, media_hddvd, media_bluray, media_custom, casetype, slipcover, banner_front, banner_back FROM pmp_film WHERE id = ?';
			$params = [$id];
			$row = dbquery_pdo($query, $params, 'object');

			if (count($row) > 0) {			
				$dvd = $row[0];
			}
			else {
				dbclose_pdo();
				die('Not found!');
			}
			
			dbclose_pdo();

			$src_img = imagecreatefromjpeg("./cover/{$sourceFilename}");

			// Get size of original image
			$old_x = imageSX($src_img);
			$old_y = imageSY($src_img);

			// No scaling of image
			if ($width == 'noscale') {
				$width = $old_x;
			}

			// Calculate hight of thumbnail with original aspect ratio
			$thumb_h = $old_y * ($width / $old_x);

			// Add hd-banner to image
			if ($pmp_hdbanner == true && ($type == 'front' &&  $dvd->banner_front != 'Off')
			    && ($dvd->media_hddvd == '1' || $dvd->media_bluray == '1')
			    && (( $dvd->banner_front == 'Automatic' && ($dvd->casetype == 'HD Keep Case' || $dvd->casetype == 'HD Slim') && $dvd->slipcover == '0') || $dvd->banner_front == 'On' )) {
				
				if ($dvd->media_hddvd == '1') {
					if ($dvd->media_dvd == '1') {
						$banner = "./themes/{$pmp_theme}/images/Banner_HDDVD_DVD.png";
					}
					else {
						$banner = "./themes/{$pmp_theme}/images/Banner_HDDVD.png";
					}
				}
				else if ($dvd->media_bluray == '1') {
					if ($dvd->media_dvd == '1') {
						$banner = "./themes/{$pmp_theme}/images/Banner_BluRayDVD.png";
					}
					else {
						$banner = "./themes/{$pmp_theme}/images/Banner_BluRay.png";
					}
				}

				$src_banner = imagecreatefrompng($banner);

				$banner_x = imageSX($src_banner);
				$banner_y = imageSY($src_banner);
				$banner_h = $banner_y * ($width / $banner_x);

				$dst_img = ImageCreateTrueColor($width, $thumb_h + $banner_h);
				imagecopyresampled($dst_img, $src_banner, 0, 0, 0, 0, $width, $banner_h, $banner_x, $banner_y);
				imagecopyresampled($dst_img, $src_img, 0, $banner_h, 0, 0, $width, $thumb_h, $old_x, $old_y);
				imagedestroy($src_banner);
			}
			else {
				$dst_img = ImageCreateTrueColor($width, $thumb_h);
				imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $width, $thumb_h, $old_x, $old_y);
			}

			// Cache generated thumbnail
			if ($pmp_thumbnail_cache == true) {
				imagejpeg($dst_img, "./cache/w{$width}_{$hash}_{$sourceFilename}");
				header('Content-type: image/jpeg');
				header('Cache-Control: must-revalidate');
				header($ExpStr);
				header("Content-Disposition: inline; filename=./cache/w{$width}_{$hash}_{$sourceFilename};");
				readfile("./cache/w{$width}_{$hash}_{$sourceFilename}");
			}
			else {
				header('Content-type: image/jpeg');
				header('Cache-Control: must-revalidate');
				header($ExpStr);
				imagejpeg($dst_img);
			}

			imagedestroy($dst_img);
			imagedestroy($src_img);
		}
	}
}
else // Or use existing
{
	// Thumbnail exist?
	if (is_file("./cover/thumbnails/{$sourceFilename}")) {
		$filename = "./cover/thumbnails/{$sourceFilename}";
	}
	// Use hires cover
	else {
		$filename = "./cover/{$sourceFilename}";
	}
	
	// ToDo: Show nocover

	header('Content-Type: image/jpeg');
	header('Cache-Control: must-revalidate');
	header($ExpStr);
	header("Content-Disposition: inline; filename={$filename};");
	readfile($filename);
}
?>
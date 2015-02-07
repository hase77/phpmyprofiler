<?php
/* phpMyProfiler
 * Copyright (C) 2006-2015 The phpMyProfiler project
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

$pmp_module = 'peoplelist';

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');

// Page selected?
if (!empty($page)) {
	$start = $page;
}
else {
	$start = 1;
}

// Letter selected?
if (empty($p_letter)) {
	$letter = '';
}
else {
	$letter = $p_letter;
}

$dir = @opendir($pmp_dir_cast);

$person = [];

while (($filename = @readdir($dir)) !== false) {
	if ((stristr($filename, '.jpg') || stristr($filename, '.gif') || stristr($filename, '.png') || stristr($filename, '.tiff')) && $filename != 'blank.jpg') {
		$file = substr($filename, 0, strlen($filename));

		// Invelos style
		if (strrpos($file, '_')) {
			$name = trim(substr($filename, 0, strlen($filename)-4));
			$realname = explode('_', $name);
			$name = '';
			if (isset($realname[1]) && strlen($realname[1]) > 0) $name .= $realname[1].' ';
			if (isset($realname[2]) && strlen($realname[2]) > 0) $name .= $realname[2].' ';
			if (isset($realname[0]) && strlen($realname[0]) > 0) $name .= $realname[0];

			if ($letter && (strtoupper(substr($name, 0, 1)) != strtoupper($letter))) {
				// Do nothing
			}
			else {
				$file = substr($filename, 0, strlen($filename));
				if (isset($realname[3])) {
					$person[] = [
						'Name' => $name,
						'File' => $file,
						'Birthyear' => $realname[3]
					];
				}
				else {
					$person[] = [
						'Name' => $name,
						'File' => $file
					];
				}
			}
		}

		// "Old" pmp style
		else {
			if ($letter && (strtoupper(substr($filename, 0, 1)) != strtoupper($letter))) {
				// Do nothing
			}
			else {
				$pos = strrpos($file, ')');
				// Birthyear or not?
				if ($pos === false || $filename[$pos-5] != '(') {
					$name = trim(substr($filename, 0, strlen($filename)-4));
					$person[] = [
						'Name' => $name,
						'File' => $file
					];
				}
				else {
					$birthyear = substr($filename, $pos-4,4);
					$name = str_replace('(' . $birthyear . ')', '', trim(substr($filename, 0, strlen($filename)-4)));
					$person[] = [
						'Name' => $name,
						'File' => $file,
						'Birthyear' => $birthyear
					];
				}
			}
		}
	}
}

@closedir($dir);

$count = count($person);

// Sort output
if ($count > 0) {
	sort($person);
}

$smarty->assign('person', @array_slice($person, (((int)$start - 1) * $pmp_people_per_page), $pmp_people_per_page));
$smarty->assign('count', $count);
$smarty->assign('page', (int)$start);
$smarty->assign('pages', (int)($count / $pmp_people_per_page + ((($count % $pmp_people_per_page) == 0) ? 0 : 1)));
$smarty->assign('pletter', strtoupper($letter));
$smarty->assign('alphabet', ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']);

$smarty->display('peoplelist.tpl');
?>
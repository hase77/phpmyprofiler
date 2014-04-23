<?php
/* phpMyProfiler
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

define('_PMP_REL_PATH', '..');

$pmp_module = 'admin_checklang';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

// Extract the string between ' and "
function preg_extract($text) {
	if ( (strpos($text, '"', 0) !== false) || (strpos($text, "'", 0) !== false) ) {
		if ( (strpos($text, '"', 0) !== false) && (strpos($text, "'", 0) !== false) ) {
			if ( (strpos($text, '"', 0)) < (strpos($text, "'", 0)) ) {
				$char = '"';
			}
			else {
				$char = "'";
			}
		}
		else if ( strpos($text, "'", 0) !== false ) {
			$char = "'";
		}
		else if ( strpos($text, '"', 0) !== false ) {
			$char = '"';
		}
	}

	if ( isset($char) ) {
		$start = strpos($text, $char);
		$end  = strpos($text, $char, $start+1);

		while ( (substr($text, $end-1, 1)) == "\\" ) {
			$end  = strpos($text, $char, $end+1);
		}

		unset($char);
		return substr($text, $start+1, $end-$start-1);
	}
}

function getPhpMissing($file) {
	global $data, $unused, $templates, $lang_data, $pmp_theme;

	preg_match_all("/pmp_module.*/", $data, $res);
	if ( isset($res[0][0]) ) $module = preg_extract($res[0][0]);

	if ( !empty($module) ) {
		$templates[$file]['module'] = $module;
		$templates[$file]['files'][] = substr($file, 3);

		preg_match_all("/\bt\b\((.*?)\)/", $data, $res);

		foreach ( $res[1] as $str ) {
			$preg_str = preg_extract($str);
			if ( (!empty($preg_str)) && (!isset($onlyone[$str])) && (strpos($str, "$", 0) != true) ) {
				if ( !empty($lang_data[$preg_str]) ) {
					$templates[$file]['used'][][$preg_str] = $lang_data[$preg_str];
					unset($unused[$preg_str]);
					$onlyone[$str] = true;
				}
				else {
					$templates[$file]['missing'][][$preg_str] = false;
					$onlyone[$str] = true;
				}
			}
			unset($preg_str);
		}

		unset($onlyone);
	}

	unset($module);
	unset($res);
}

function getTempMissing($file) {
	global $data, $unused, $templates, $lang_data, $pmp_theme, $used_templates;

	preg_match_all("/\bsmarty\-\>display\b\((.*)\)/", $data, $res);

	foreach ( $res[1] as $str ) {
		$preg_str = preg_extract($str);
		$used_templates['themes/' . $pmp_theme . '/templates/' . $preg_str] = true;

		foreach ( $templates[$file]['files'] as $str ) {
			if ( $str == 'themes/' . $pmp_theme . '/templates/' . $preg_str ) {
				$notset = true;
			}
		}

		if ( !isset($notset) ) {
			$templates[$file]['files'][] = 'themes/' . $pmp_theme . '/templates/' . $preg_str;
		}

		unset($notset);
		unset($preg_str);
	}

	foreach ( $res[1] as $str ) {
		$preg_str = preg_extract($str);
		getTemp($preg_str, $file);
		unset($preg_str);
	}

	unset($res);
}

function getTemp($file, $file_php = '0') {
	global $pmp_theme, $lang_data, $unused, $templates, $used_templates;

	$dir = '../themes/' . $pmp_theme . '/templates/';

	if ( $file_php == 'filename' ) {
		$file_php = $file;
		$dir = '';
		$templates[$file]['module'] = substr($file, 3);
	}

	if ( file_exists($dir . $file) ) {
		$tempdata = file_get_contents($dir . $file);
		preg_match_all('/{t.*?}(.*?){\/t}/i', $tempdata, $temp);

		foreach ( $temp[1] as $str ) {
			if ( !empty($str) && substr($str, 0, 1) != '{' && (!isset($onlyone[$str])) ) {
				if ( !empty($lang_data[$str]) ) {
					$templates[$file_php]['used'][][$str] = $lang_data[$str];
					unset($unused[$str]);
					$onlyone[$str] = true;
				}
				else {
					$templates[$file_php]['missing'][][$str] = false;
					$onlyone[$str] = true;
				}
			}
		}

		// Get included templates
		preg_match_all('/{include file=(.*?)}/i', $tempdata, $temp_incl);

		foreach ( $temp_incl[1] as $str ) {
			if ( (!strstr("header.tpl", $str)) && (!strstr("footer.tpl", $str)) && (!strstr("mainerror.tpl", $str)) && (!empty($str))
				&& (substr($str, 0, 1) != '{') ) {
				if ( (strpos($str, '"', 0) === false) && (strpos($str, "'", 0) === false) ) {
					$preg_incl = $str;
				}
				else {
					$preg_incl = preg_extract($str);
				}

				$used_templates['themes/' . $pmp_theme . '/templates/' . $preg_incl] = true;

				foreach ( $templates[$file_php]['files'] as $str2 ) {
					if ( $str2 == 'themes/' . $pmp_theme . '/templates/' . $preg_incl ) {
						$notset = true;
					}
				}

				if ( !isset($notset) ) {
					$templates[$file_php]['files'][] = 'themes/' . $pmp_theme . '/templates/' . $preg_incl;
				}

				unset($notset);

				if ( file_exists('../themes/' . $pmp_theme . '/templates/' . $preg_incl) ) {
					$incldata = file_get_contents('../themes/' . $pmp_theme . '/templates/' . $preg_incl);
					preg_match_all('/{t.*?}(.*?){\/t}/i', $incldata, $res_incl);

					foreach ( $res_incl[1] as $str_incl ) {
						if ( !empty($str_incl) && substr($str_incl, 0, 1) != '{' && (!isset($onlyone[$str_incl])) ) {
							if ( !empty($lang_data[$str_incl]) ) {
								$templates[$file_php]['used'][][$str_incl] = $lang_data[$str_incl];
								unset($unused[$str_incl]);
								$onlyone[$str_incl] = true;
							}
							else {
								$templates[$file_php]['missing'][][$str_incl] = false;
								$onlyone[$str_incl] = true;
							}
						}
					}
				}
			}
		}

		unset($onlyone);
		unset($tempdata);
	}
}

// Select Language
if ( !isset($_GET['LG']) ) {
	$LG = $pmp_lang_default;
}
else {
	$LG = $_GET['LG'];
}

$save_lang = $_SESSION['lang_id'];
$_SESSION['lang_id'] = $LG;
getLang($LG);

$unused = $lang_data;

// Get the Files
$dirs[] = '../';
$dirs[] = '../admin';
$dirs[] = '../statistic';

foreach ( $dirs as $dir ) {
	$handle = opendir($dir);

	while ( false !== ($file = readdir($handle)) ) {
		if ( (substr($file, -4) == ".php") && (substr($file, -8) != ".inc.php") && (is_file($dir . '/' . $file)) ) {
			$data = file_get_contents($dir . '/' .$file);
			getPhpMissing($dir . '/' . $file);
			getTempMissing($dir . '/' . $file);
		}
	}
}

// Get the last template files
if ( is_dir('../themes/' . $pmp_theme . '/templates/admin') ) {
	// Not every theme has admin
	$tdirs[] = '../themes/' . $pmp_theme . '/templates/admin';
}
$tdirs[] = '../themes/' . $pmp_theme . '/templates';

foreach ( $tdirs as $tdir ) {
	$handle = opendir ($tdir);

	while ( false !== ($file = readdir($handle)) ) {
		if ( (is_file($tdir . '/' . $file)) && (!isset($used_templates[substr($tdir, 3) . '/' . $file])) ) {
			getTemp($tdir . '/' . $file, 'filename');
		}
	}
	closedir($handle);
}

// Optic of unused
while ( list($key, $val) = each($unused) ) {
	$unused_output[][$key] = $val;
}

$_SESSION['lang_id'] = $save_lang;

$smarty->assign('header', t('Translation status'));
$smarty->assign('header_img', 'checklang');
$smarty->assign('session', session_name() . "=" . session_id() );
$smarty->assign('getLangs', getLangs());
$smarty->assign('unused', $unused_output);
$smarty->assign('templates', $templates);

$smarty->display('admin/checklang.tpl', $_SESSION['lang_id']);
?>
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

// No direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

// Functions only used by ACP

// Send UTF-8 header to all acp sites
header('Content-type: text/html; charset=utf-8');

require_once('../include/functions.php');

function isadmin() {
	$_SESSION['lastside'] = $_SERVER['PHP_SELF'];

	if ( empty($_SESSION['isadmin']) ) {
		header("Location:login.php?" . session_name() . "=" . session_id() );
	}
}

function checkDBState() {
	global $pmp_dateformat;

	// Get Version of Database
	$sql= 'SELECT id, DATE_FORMAT(date, \'' . $pmp_dateformat . ' %H:%i:%s\') as date FROM pmp_update ORDER BY id DESC LIMIT 1';
	$res = dbexec($sql, true);

	if ( mysql_num_rows($res) > 0 ) {
		$row = mysql_fetch_object($res);
		$StateDB = $row->id;
		$StateDBTime = $row->date;
	}
	else {
		$StateDB = -1;
		$StateDBTime = -1;
	}

	// Look for updates
	$StateUpdate = -1;

	$handle = opendir('updates/');
	while ( false !== ($file = readdir($handle)) ) {
		if ( ($file != '.') && ($file != '..') && (!is_dir($file)) ) {
			$tmp = explode('.', $file);

			if ( $tmp[count($tmp)-1] == 'upd' ) {
				if ( $tmp[0] > $StateUpdate ) {
					$StateUpdate = $tmp[0];
				}
			}
		}
	}

	closedir($handle);

	return array('StateUpdate'	=> $StateUpdate,
		'StateDB' 		=> $StateDB,
		'StateDBTime'		=> $StateDBTime);
}

function getThemes() {
	require_once(_PMP_REL_PATH.'/admin/include/theme.class.php');

	$handle = opendir('../themes/');
	if ( $handle ) {
		while ( $file = readdir($handle) ) {
			if ( $file != "." && $file != ".." ) {
				$tmp = new theme($file);
				if ( $tmp->id !== false ) {
					$res[] = $tmp;
				}
			}
		}
	}

	closedir($handle);

	return $res;
}

// On some systems, like FreeBSD, a constant with name iconv is defined
if ( !function_exists('iconv') && function_exists('libiconv') ) {
	function iconv($input_encoding, $output_encoding, $string) {
		return libiconv($input_encoding, $output_encoding, $string);
	}
}

function getCurrencies() {
	dbconnect(FALSE);
	$res = @dbexec('SELECT id FROM pmp_rates ORDER BY id', true);

	// The Euro is not in the list, because it's the base currency
	$rates['EUR'] = 'EUR';

	if ( $res ) {
		if ( mysql_num_rows($res) > 0 ) {
			while ( $row = mysql_fetch_object($res) ) {
				$rates[$row->id] = $row->id;
			}
		}
	}
	else {
		// no access to database, use default values
		$rates['USD'] = 'USD';
		$rates['JPY'] = 'JPY';
		$rates['BGN'] = 'BGN';
		$rates['CZK'] = 'CZK';
		$rates['DKK'] = 'DKK';
		$rates['EEK'] = 'EEK';
		$rates['GBP'] = 'GBP';
		$rates['HUF'] = 'HUF';
		$rates['LTL'] = 'LTL';
		$rates['LVL'] = 'LVL';
		$rates['PLN'] = 'PLN';
		$rates['RON'] = 'RON';
		$rates['SEK'] = 'SEK';
		$rates['CHF'] = 'CHF';
		$rates['NOK'] = 'NOK';
		$rates['HRK'] = 'HRK';
		$rates['RUB'] = 'RUB';
		$rates['TRY'] = 'TRY';
		$rates['AUD'] = 'AUD';
		$rates['BRL'] = 'BRL';
		$rates['CAD'] = 'CAD';
		$rates['CNY'] = 'CNY';
		$rates['HKD'] = 'HKD';
		$rates['IDR'] = 'IDR';
		$rates['INR'] = 'INR';
		$rates['KRW'] = 'KRW';
		$rates['MXN'] = 'MXN';
		$rates['MYR'] = 'MYR';
		$rates['NZD'] = 'NZD';
		$rates['PHP'] = 'PHP';
		$rates['SGD'] = 'SGD';
		$rates['THB'] = 'THB';
		$rates['ZAR'] = 'ZAR';
		$rates['ISK'] = 'ISK';
	}

	return $rates;
}

function uncompress_file($infilename) {
	$path_parts = pathinfo($infilename);
	$ext = '.' . $path_parts['extension'];
	$name = $path_parts['filename'];

	if ( $ext == '.zip' ) {
		return extractZip($infilename);
	}
	else if ( $ext == '.bz2' ) {
		return extractBzip2($infilename, $name);
	}

	return false;
}

function extractZip($infilename) {
	$zip = zip_open($infilename);

	if ( is_resource($zip) ) {
		while ( $zip_file = zip_read($zip) ) {
			if ( zip_entry_open($zip, $zip_file, "r") ) {
				// Delete file if exists
				if ( file_exists(zip_entry_name($zip_file)) ) {
					@unlink(zip_entry_name($zip_file));
				}

				$out_file = fopen(zip_entry_name($zip_file), "w");
				fwrite($out_file, zip_entry_read($zip_file, zip_entry_filesize($zip_file)));
				fclose($out_file);
				zip_entry_close($zip_file);

				return true;
			}
			else {
				return false;
			}
		}

		zip_close($zip);
	}
	else {
		return false;
	}
}

function extractBzip2($infilename, $name) {
	$in_file = bzopen($infilename, 'r');

	if ( is_resource($in_file) ) {
		$out_file = fopen($name, "w");
		$buffer = '';

		while ( $buffer = bzread($in_file, 4096) ) {
			fwrite($out_file, $buffer, 4096);
		}

		bzclose($in_file);
		fclose($out_file);

		return true;
	}
	else {
		return false;
	}
}

function saveLastIP() {
	dbconnect();
	// Remove old IP
	$sql = "DELETE FROM pmp_statistics WHERE type = 'last_login_old';";
	dbexec($sql);
	// Move last IP
	$sql = "UPDATE pmp_statistics SET type = 'last_login_old' WHERE type = 'last_login_new';";
	dbexec($sql);
	// Insert new IP
	$sql = "INSERT INTO pmp_statistics VALUES ('last_login_new', '" . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . "', '" . date("H:i") . "', '". date("Y-m-d") . "');";
	dbexec($sql);
	dbclose();
}

function getTags() {
	$tags[''] = 'empty';
	$sql= 'SELECT DISTINCT name FROM pmp_tags WHERE name != \'\' ORDER BY name';
	$res = dbexec($sql, true);
	if ( $res ) {
		while ( $row = mysql_fetch_object($res) ) {
			$tags[$row->name] = $row->name;
		}
	}

	return $tags;
}

function getTimezones() {
	$locations = array();
	$zones = timezone_identifiers_list();

	foreach ( $zones as $zone ) {
		$zone = explode('/', $zone); // 0 => Continent, 1 => City

		if ( $zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific' ) {
			if (isset($zone[1]) != '') {
				$locations[$zone[0].'/'.$zone[1]] = str_replace('_', ' ', $zone[0].'/'.$zone[1]);
			}
		}
	}

	return $locations;
}

function getThemeCSS() {
	global $pmp_theme;

	$dh = opendir('../themes/'.$pmp_theme.'/css');
	if ( $dh ) {
		while ( ($file = readdir($dh)) !== false ) {
			if ( substr($file, strlen($file) - 4) == '.css' ) {
				$files[$file] = $file;
			}
		}

		closedir($dh);
	}

	return $files;
}

function getIsset(& $value) {
	if ( isset($value) ) {
		return $value;
	}
	else {
		return;
	}
}

function maskData($value) {
	if ( get_magic_quotes_gpc() == true ) {
		$maskedData = mysql_real_escape_string(stripslashes($value));
		return $maskedData;
	}
	else {
		$maskedData = mysql_real_escape_string($value);
		return $maskedData;
	}
}

function genTopTags() {
	dbconnect();

	dbexec("DELETE FROM pmp_tags WHERE name = 'IMDB Top 250'");
	dbexec("DELETE FROM pmp_tags WHERE name = 'IMDB Bottom 100'");
	dbexec("DELETE FROM pmp_tags WHERE name = 'OFDB Top 250'");
	dbexec("DELETE FROM pmp_tags WHERE name = 'OFDB Bottom 100'");

	$sql = "SELECT pmp_reviews_connect.id, pmp_reviews_external.type, top250, bottom100 FROM pmp_reviews_connect LEFT JOIN pmp_reviews_external ON review_id = pmp_reviews_external.id WHERE (top250 IS NOT NULL OR bottom100 IS NOT NULL) AND pmp_reviews_connect.id NOT IN (SELECT id FROM pmp_boxset)";

	$result = dbexec($sql);
	if ( mysql_num_rows($result) > 0 ) {
		while ( $row = mysql_fetch_object($result) ) {
			if ( isset($row->top250) ) {
				$sql = "INSERT INTO pmp_tags values ('" . $row->id . "', '" . strtoupper($row->type) . " Top 250', '" . strtoupper($row->type) . " Top 250')";
			} else {
				$sql = "INSERT INTO pmp_tags values ('" . $row->id . "', '" . strtoupper($row->type) . " Bottom 100', '" . strtoupper($row->type) . " Bottom 100')";
			}
			dbexec($sql, true);
		}
	}

	dbclose();
}

function delCachedTempPHP() {
	// Delete cached templates
	$handle = opendir('../cache/');
	while ( ($file = readdir($handle)) !== false ) {
		if ( strrchr($file, '.') == '.php' ) {
			@unlink('../cache/' . basename($file));
		}
	}
	closedir($handle);
}

function getMaxPacket() {
	$res = dbexec("SHOW VARIABLES like 'max_allowed_packet'");
	$row = mysql_fetch_object($res);
	return ($row->Value * .99);
}

function genScreenshotTag($indb) {
	dbconnect();

	dbexec("DELETE FROM pmp_tags WHERE name = 'Screenshots'");

	foreach ($indb as $id) {
		$sql = "INSERT INTO pmp_tags values ('" . mysql_real_escape_string($id['id']) . "', 'Screenshots', 'Screenshots')";
		dbexec($sql, true);
	}

	dbclose();
}

function getScreenshotsAdm($path) {
	// Check OS
	if ( php_uname('s') != 'Windows NT' ) {
		$windows = false;
		$symlinks = 1;
	} else {
		$windows = true;
		if ( substr(php_uname('v'),6,4) >= 6000 ) $symlinks = 1;
	}

	// Get all IDs
	$ids = array();
	$link = array();
	if ( is_dir($path) ) {
		$handle = opendir($path);
		if ( is_resource($handle) ) {
			while ( false !== ($file = readdir($handle)) ) {
				if ( is_dir($path.DIRECTORY_SEPARATOR.$file) && $file != '.' && $file != '..' && $file != 'thumbs' ) {
					if ( $windows ) {
						$islink = $file !== pathinfo(@readlink($path.DIRECTORY_SEPARATOR.$file),PATHINFO_BASENAME);
					} else {
						$islink = is_link($path.DIRECTORY_SEPARATOR.$file);
					}
					if ( $islink ) {
						$link[$file] = pathinfo(@readlink($path.DIRECTORY_SEPARATOR.$file),PATHINFO_BASENAME);
					}
					$ids[] = utf8_encode($file);
				}
			}
		}
		closedir($handle);
	}

	$indb = array();
	$notindb = array();

	// IDs in database?
	dbconnect();
	foreach ($ids as $id) {
		$sql = "SELECT id, title, sorttitle FROM pmp_film WHERE id='".mysql_real_escape_string($id)."'";
		$res = dbexec($sql);
		if ( mysql_num_rows($res) != 0 ) {
			$row = mysql_fetch_object($res);
			$indb[$id] = array('sort'=>$row->sorttitle, 'id'=>$id, 'title'=>$row->title);
		} else {
			$notindb[$id] = $id;
		}
	}
	if ( !empty($indb) ) asort($indb);

	return array($ids, $link, $indb, $notindb, $symlinks, $windows);
}

?>

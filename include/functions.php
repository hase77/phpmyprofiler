<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
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

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

// Set version
$pmp_version = '1.2 dev';

// Show all errors, except notices
error_reporting(E_ALL ^ E_NOTICE);

// Uncomment for developing/debugging
@ini_set('display_errors', 1);
@ini_set('implicit_flush', 'On');
error_reporting(E_ALL | E_STRICT);

// Set include-path for PEAR lib
add_include_path(dirname(__FILE__) . '/PEAR');

// Set timezone because strict warning (if not already set in php.ini)
@date_default_timezone_set($pmp_timezone);

// Start session if there's none
if (!isset($_SESSION)) {
	session_start();
}

// Check language
if (!empty($lang_id)) {
	// The user wants to change language, save the information to session
	$_SESSION['lang_id'] = $lang_id;
}
// Okay, the user doesn't want to change the language. Then use the language
// from the Session. Oh, there is no language in the session?
else if (empty($_SESSION['lang_id'])) {
	// We need PEAR:HTTP2 to get the right language from the browser.
	require_once('HTTP2.php');
	$http = new HTTP2();

	$langs = [
		'en'	=> true,
		'de'	=> true,
		'da'	=> true,
		'no'	=> true
	];

	$_SESSION['lang_id'] = $http->negotiateLanguage($langs, $pmp_lang_default);
}

// Expire header
$offset = 60 * 60 ;
$ExpStr = 'Expires: '.gmdate('D, d M Y H:i:s', time() + $offset).' GMT';

// Connect to the database
// Dies on error (with an error message) if $dieonerror is true
function dbconnect($dieonerror = true) {
	// mysql* functions are deprecated!

	global $pmp_sqlhost, $pmp_sqluser, $pmp_sqlpass, $pmp_sqldatabase;
	global $pmp_timezone, $pmp_mysql_ver;

	$db = @mysql_connect($pmp_sqlhost, $pmp_sqluser, $pmp_sqlpass);

	// Can't connect to the mysql-database
	if (!$db && $dieonerror) {
		$the_error = "\nmySQL error: " . mysql_error() . "\n";
		$the_error .= "mySQL error code: " . mysql_errno() . "\n";
		$the_error .= "Date: " . date("Y-m-d H:i:s");
		echo "<html><head><title>Database Error</title><style>P,BODY{ font-family:arial,sans-serif; font-size:11px; }</style>
			</head><body>&nbsp;<br><br><blockquote><b>There appears to be an error with the database.</b>
			<br>You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>
			, if this does not fix the error, please connect the Webmaster<br><br><b>Error returned:</b><br>
			<form name='mysql'><textarea rows=\"15\" cols=\"45\">" . htmlspecialchars($the_error) . "</textarea></form>
			<br></blockquote></body></html>" ;
		exit();
	}

	// Get MySQL Server version
	$pmp_mysql_ver = substr(@mysql_get_server_info($db), 0, strpos(@mysql_get_server_info($db), "-"));

	// Set encoding for database
	@mysql_set_charset('utf8', $db);
	@mysql_query("SET time_zone='".$pmp_timezone."'");

	$db_select = @mysql_select_db($pmp_sqldatabase);

	// Can't switch to the database
	if (!$db_select && $dieonerror) {
		$the_error .= "\nmySQL error: ".mysql_error()."\n";
		$the_error .= "mySQL error code: ".mysql_errno()."\n";
		$the_error .= "Date: ".date("Y-m-d H:i:s");
		echo "<html><head><title>Database Error</title><style>P,BODY{ font-family:arial,sans-serif; font-size:11px; }</style>
			</head><body>&nbsp;<br><br><blockquote><b>There appears to be an error with the database.</b>
			<br>You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>
			, if this does not fix the error, please connect the Webmaster<br><br><b>Error returned:</b><br>
			<form name='mysql'><textarea rows=\"15\" cols=\"45\">" . htmlspecialchars($the_error) . "</textarea></form>
			<br></blockquote></body></html>" ;
		exit();
	}

	return ($db && $db_select);
}

// Connect to the database via PDO
// Dies on error (with an error message) if $dieonerror is true
function dbconnect_pdo($dieonerror = true) {
	global $pmp_db, $pmp_timezone, $pmp_mysql_ver;
	global $pmp_sqlhost, $pmp_sqluser, $pmp_sqlpass, $pmp_sqldatabase;

	try {
		$pmp_db = new PDO(
			"mysql:host={$pmp_sqlhost}; dbname={$pmp_sqldatabase}; charset=utf8",
			$pmp_sqluser, $pmp_sqlpass,
			[PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8;']
		);

		// Enable prepared statements
		$pmp_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		// Use exceptions
		$pmp_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// ToDo: Set timezone, get mysql version (for what?)

	}
	catch (PDOException $e) {
		if ($dieonerror) {
			echo '<html><head><title>Database Error</title><style>P,BODY{font-family:arial,sans-serif; font-size:11px;}</style>
				</head><body>&nbsp;<br><br><blockquote><b>There appears to be an error with the database.</b>
				<br>You can try to refresh the page by clicking <a href="javascript:window.location=window.location;">here</a>
				, if this does not fix the error, please connect the Webmaster<br><br><b>Error returned:</b><br>
				<form name="mysql"><textarea rows="15" cols="45">'.htmlspecialchars($e->getMessage()).'</textarea></form>
				<br></blockquote></body></html>';
			die;
		}
		else {
                    return false;
                }
	}
	
	return true;
}

// Replace the table prefix and executes the query
// If $continueonerror is set to true the script will abort with an error message if the query fails.
function dbexec($sql, $continueonerror = false) {
	$sql = replace_table_prefix($sql);
	$result = @mysql_query($sql);

	if (!$continueonerror) {
		if (!$result) {
			echo "<strong>SQL-Statement failed:</strong><br /><pre>" . mysql_errno() . " - " . mysql_error()
				. "\n\nQuery:\n$sql</pre>";
			die;
		}
	}

	return $result;
}

// Prepare and execute the query via PDO
// If $continueonerror is set to true the script will abort with an error message if the query fails.
function dbquery_pdo($query, $params = null, $type = 'default', $continueonerror = false) {
	global $pmp_db;

	$result = false;
	$query = replace_table_prefix($query);

	try {
		$stmt = $pmp_db->prepare($query);
		$stmt->execute($params);

		switch ($type) {
			case 'num';
				$result = $stmt->fetchAll(PDO::FETCH_NUM);
				break;
			case 'assoc';
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				break;
			case 'object';
				$result = $stmt->fetchAll(PDO::FETCH_OBJ);
				break;
			case 'default';
				$result = $stmt->fetchAll(PDO::FETCH_BOTH);
				break;
		}
	}
	catch (PDOException $e) {
		if (!$continueonerror) {
			echo '<html><head><title>Database Error</title><style>P,BODY{font-family:arial,sans-serif; font-size:11px;}</style>
				</head><body>&nbsp;<br><br><blockquote><b>There appears to be an error with the database.</b>
				<br>You can try to refresh the page by clicking <a href="javascript:window.location=window.location;">here</a>
				, if this does not fix the error, please connect the Webmaster<br><br><b>Error returned:</b><br>
				<form name="mysql"><textarea rows="15" cols="45">'.htmlspecialchars($e->getMessage()).'</textarea></form>
				<br></blockquote></body></html>';
			die;
		}
	}
	
	return $result;
}

function dbexecute_pdo($query, $params = null, $continueonerror = false) {
	global $pmp_db;

	$result = false;
	$query = replace_table_prefix($query);
	
	try {
		$stmt = $pmp_db->prepare($query);
		$result = $stmt->execute($params);
	}
	catch (PDOException $e) {
		if (!$continueonerror) {
			echo '<html><head><title>Database Error</title><style>P,BODY{font-family:arial,sans-serif; font-size:11px;}</style>
				</head><body>&nbsp;<br><br><blockquote><b>There appears to be an error with the database.</b>
				<br>You can try to refresh the page by clicking <a href="javascript:window.location=window.location;">here</a>
				, if this does not fix the error, please connect the Webmaster<br><br><b>Error returned:</b><br>
				<form name="mysql"><textarea rows="15" cols="45">'.htmlspecialchars($e->getMessage()).'</textarea></form>
				<br></blockquote></body></html>';
			die;
		}
	}
	
	$stmt = null;
	return $result;
}

// Close database
function dbclose() {
	mysql_close();
}

// Close database
function dbclose_pdo() {
	global $pmp_db;

	$pmp_db = null;
}

// Replace the tableprefix pmp_ with the user defined prefix
function replace_table_prefix($sql) {
	global $pmp_table_prefix;

	return str_replace('pmp_', $pmp_table_prefix, $sql);
}

// Cut $string after $length character and add the $suffix
// Will pay attention to things like &uuml;
function trunc($string, $length, $suffix = '...') {
	if (strlen($string) - strlen($suffix) > $length) {
		if (strpos($string, '&', $length-5) && strpos($string, '&', $length-5) < $length) {
			return trunc($string, $length + (strpos($string, ';', $length-5) - strpos($string, '&', $length-5)), $suffix);
		}
		else {
			return substr($string, 0, $length).$suffix;
		}
	}
	else {
		return $string;
	}
}

function getColumns($col = '', $detail = '') {
	$columns[0]['Header'] = 'empty';		// displayed name of the column
	$columns[0]['Output'] = '';				// object-property/function to display
	$columns[0]['Sort'] = 'Hide column';	// The database field to sort

	$columns[1]['Header'] = 'Movie Title';
	$columns[1]['Output'] = 'Title';
	$columns[1]['Sort'] = 'sorttitle';

	$columns[2]['Header'] = 'Year';
	$columns[2]['Output'] = 'Year';
	$columns[2]['Sort'] = 'prodyear';

	$columns[3]['Header'] = 'Country';
	$columns[3]['Output'] = 'getLocationFlag';
	$columns[3]['AltOutput'] = 'Locality';	// alternative Text output (eg for pdfs)
	$columns[3]['Sort'] = 'locality';

	$columns[4]['Header'] = 'Nr.';
	$columns[4]['Output'] = 'Number';
	$columns[4]['Sort'] = 'collectionnumber';

	$columns[5]['Header'] = 'Date of purchase';
	$columns[5]['Output'] = 'PurchDate';
	$columns[5]['Sort'] = 'purchdate';

	$columns[6]['Header'] = 'Length';
	$columns[6]['Output'] = 'Length';
	$columns[6]['Sort'] = 'runningtime';

	$columns[7]['Header'] = 'Price';
	$columns[7]['Output'] = 'PurchPrice';
	$columns[7]['Sort'] = 'purchprice';

	$columns[8]['Header'] = 'Place of purchase';
	$columns[8]['Output'] = 'PurchPlace';
	$columns[8]['Sort'] = 'purchplace';

	$columns[9]['Header'] = 'Edition';
	$columns[9]['Output'] = 'Edition';
	$columns[9]['Sort'] = 'disttrait';

	$columns[10]['Header'] = 'Origin';
	$columns[10]['Output'] = 'getOriginFlag';
	$columns[10]['AltOutput'] = 'Origin';  // alternative Text output (eg for pdfs)
	$columns[10]['Sort'] = 'origin';

	if (empty($col)) {
		return $columns;
	}
	else if (empty($detail)) {
		return $columns[$col];
	}
	else if ($detail == 'AltOutput' && !isset($columns[$col][$detail])) {
		return $columns[$col]['Output'];
	}
	else {
		return $columns[$col][$detail];
	}
}

function getColumnsasOption() {
	foreach (getColumns() as $key => $column) {
		$ret[$key] = $column['Header'];
	}

	return $ret;
}

function getFlagName($state) {
	// Localities
	$flags['united states'] = 'United_States.png';
	$flags['new zealand'] = 'New_Zealand.png';
	$flags['australia'] = 'Australia.png';
	$flags['canada'] = 'Canada.png';
	$flags['united kingdom'] = 'United_Kingdom.png';
	$flags['germany'] = 'Germany.png';
	$flags['china'] = 'China.png';
	$flags['former soviet union'] = 'Soviet_Union.png';
	$flags['france'] = 'France.png';
	$flags['netherlands'] = 'Netherlands.png';
	$flags['spain'] = 'Spain.png';
	$flags['sweden'] = 'Sweden.png';
	$flags['norway'] = 'Norway.png';
	$flags['italy'] = 'Italy.png';
	$flags['denmark'] = 'Denmark.png';
	$flags['portugal'] = 'Portugal.png';
	$flags['finland'] = 'Finland.png';
	$flags['japan'] = 'Japan.png';
	// It seems that we can get both variants
	$flags['south korea'] = 'South_Korea.png';
	$flags['korea'] = 'South_Korea.png';
	$flags['canada (quebec)'] = 'Quebec.png';
	$flags['south africa'] = 'South_Africa.png';
	$flags['hong kong'] = 'Hong_Kong.png';
	$flags['switzerland'] = 'Switzerland.png';
	$flags['brazil'] = 'Brazil.png';
	$flags['israel'] = 'Israel.png';
	$flags['mexico'] = 'Mexico.png';
	$flags['iceland'] = 'Iceland.png';
	$flags['indonesia'] = 'Indonesia.png';
	$flags['taiwan'] = 'Taiwan.png';
	$flags['poland'] = 'Poland.png';
	$flags['belgium'] = 'Belgium.png';
	$flags['turkey'] = 'Turkey.png';
	$flags['argentina'] = 'Argentina.png';
	$flags['slovakia'] = 'Slovakia.png';
	$flags['hungary'] = 'Hungary.png';
	$flags['singapore'] = 'Singapore.png';
	$flags['czech republic'] = 'Czech_Republic.png';
	$flags['malaysia'] = 'Malaysia.png';
	$flags['thailand'] = 'Thailand.png';
	$flags['india'] = 'India.png';
	$flags['austria'] = 'Austria.png';
	$flags['greece'] = 'Greece.png';
	$flags['vietnam'] = 'Vietnam.png';
	$flags['philippines'] = 'Philippines.png';
	$flags['ireland'] = 'Ireland.png';
	$flags['estonia'] = 'Estonia.png';
	$flags['romania'] = 'Romania.png';
	$flags['iran'] = 'Iran.png';
	$flags['russia'] = 'Russia.png';
	$flags['chile'] = 'Chile.png';
	$flags['colombia'] = 'Colombia.png';
	$flags['peru'] = 'Peru.png';

	// pmp languages
	$flags['de'] = 'Germany.png';
	$flags['no'] = 'Norway.png';
	$flags['dk'] = 'Denmark.png';
	$flags['en'] = '_english.gif';
	$flags['nl'] = 'Netherlands.png';

	// Languages
	$flags['afrikaans'] = 'South_Africa.png';
	$flags['arabic'] = 'Algeria.png';
	$flags['audio descriptive'] = '_commentary.gif';
	$flags['bahasa'] = 'Indonesia.png';
	$flags['bambara'] = 'Mali.png';
	$flags['basque'] = 'Basque.png';
	$flags['bulgarian'] = 'Bulgaria.png';
	$flags['catalonian'] = 'Catalonia.png';
	$flags['chinese'] = 'China.png';
	$flags['cantonese'] = 'China.png';
	$flags['commentary'] = '_commentary.gif';
	$flags['croatian'] = 'Croatia.png';
	$flags['czech'] = 'Czech_Republic.png';
	$flags['danish'] = 'Denmark.png';
	$flags['dutch'] = 'Netherlands.png';
	$flags['english'] = '_english.gif';
	$flags['estonian'] = 'Estonia.png';
	$flags['farsi'] = 'Iran.png';
	$flags['finnish'] = 'Finland.png';
	$flags['flemish'] = 'Flanders.png';
	$flags['french'] = 'France.png';
	$flags['galician'] = 'Galicia.png';
	$flags['georgian'] = 'Georgia.png';
	$flags['german'] = 'Germany.png';
	$flags['greek'] = 'Greece.png';
	$flags['hebrew'] = 'Israel.png';
	$flags['hindi'] = 'India.png';
	$flags['hungarian'] = 'Hungary.png';
	$flags['icelandic'] = 'Iceland.png';
	$flags['italian'] = 'Italy.png';
	$flags['japanese'] = 'Japan.png';
	$flags['korean'] = 'South_Korea.png';
	$flags['latvian'] = 'Latvia.png';
	$flags['lithuanian'] = 'Lithuania.png';
	$flags['mongolian'] = 'Mongolia.png';
	$flags['mandarin'] = 'China.png';
	$flags['music only'] = '_music.gif';
	$flags['norwegian'] = 'Norway.png';
	$flags['other'] = '_other.gif';
	$flags['pashtu'] = 'Afghanistan.png';
	$flags['polish'] = 'Poland.png';
	$flags['portuguese'] = 'Portugal.png';
	$flags['romanian'] = 'Romania.png';
	$flags['rumantsch'] = 'Switzerland.png';
	$flags['russian'] = 'Russia.png';
	$flags['serbian'] = 'Serbia.png';
	$flags['slovakian'] = 'Slovakia.png';
	$flags['slovenian'] = 'Slovenia.png';
	$flags['spanish'] = 'Spain.png';
	$flags['special effects'] = '_other.gif';
	$flags['swedish'] = 'Sweden.png';
	$flags['swiss german'] = 'Switzerland.png';
	$flags['tagalog'] = 'Philippines.png';
	$flags['thai'] = 'Thailand.png';
	$flags['tibetan'] = 'Tibet.png';
	$flags['trivia'] = '_commentary.gif';
	$flags['turkish'] = 'Turkey.png';
	$flags['valencian'] = 'Valenciana.png';
	$flags['vietnamese'] = 'Vietnam.png';
	$flags['xhosa'] = 'South_Africa.png';
	$flags['zulu'] = 'South_Africa.png';

	if (isset($flags[strtolower($state)])) {
		return $flags[strtolower($state)];
	}
	else {
		return;
	}
}

function getHeadshot($name, $year, $firstname, $middlename, $lastname) {
	global $pmp_dir_cast;

	$extensions = ['.jpg', '.JPG', '.gif', '.GIF', '.png', '.PNG', '.tif', '.TIF'];
	$found = false;
	$full_encoded = rawurlencode($name);

	if ($year != '') {
		$searchyear = '('.$year.')';

		// Try to find image file named like "Morgan Freeman(1937).xxx"
		foreach ($extensions as $ext) {
			if (file_exists($pmp_dir_cast.$name .$searchyear.$ext)) {
				$picname = $full_encoded.$searchyear.$ext;
				$found = true;
				break;
			}
		}

		// If not found, maybe with a blank, like "Morgan Freeman (1937).xxx"
		if (!$found) {
			foreach ($extensions as $ext) {
				if (file_exists($pmp_dir_cast.$name.' '.$searchyear.$ext) ) {
					$picname = $full_encoded.$searchyear.$ext;
		    		$found = true;
		    		break;
				}
			}
		}
	}

	// If still no image found yet. Try without the year, like "Morgan Freeman.xxx"
	if (!$found) {
		foreach ($extensions as $ext) {
			if (file_exists($pmp_dir_cast.$name.$ext)) {
				$picname = $full_encoded.$ext;
				$found = true;
				break;
			}
		}
	}

	// Search for DVDProfiler style name
	if (!$found) {
		$name = $lastname.'_'.$firstname.'_'.$middlename;
		if ($year != '') $name = $name.'_'.$year;
		foreach ($extensions as $ext) {
			if (file_exists($pmp_dir_cast.$name.$ext)) {
				$picname = $name.$ext;
				$found = true;
				break;
			}
		}
	}

	// If still nothing found at this point return blank, otherwise return the image URL
	if (!$found) {
		return '';
	}
	else {
		return $picname;
	}
}

function getScreenshots($id, $praefix = '') {
	$found = false;
	$dir = $praefix.'screenshots/'.utf8_decode($id).'/';
	$thdir = $praefix.'screenshots/thumbs/'.utf8_decode($id).'/';
	$dirfail = false;

	if (is_dir($dir)) {
		$handle = opendir($dir);
		if (is_resource($handle)) {
			while ($file = readdir($handle)) {
				if ($file != "." && $file != "..") {
					if (strtolower(substr($file, -4)) == '.jpg' || strtolower(substr($file, -5)) == '.jpeg') {
						$files[] = $file;

						// Is there a dir for the thumbnail?
						if (!is_dir($thdir) && !$dirfail) {
							if (!mkdir($thdir)) {
								$dirfail = true;
							}
						}
						// Is there a thumbnail for this screenshot?
						if (!file_exists($thdir.$file) && !$dirfail) {
							// Get original image and size
							$src_img = imagecreatefromjpeg($dir.$file);
							$old_x = imageSX($src_img);
							$old_y = imageSY($src_img);
							// Calculate new size
							if ($old_x >= $old_y) {
								$thumb_x = 90;
								$thumb_y = 90 * ($old_y / $old_x);
							}
							else {
								$thumb_y = 90;
								$thumb_x = 90 * ($old_x / $old_y);
							}
							// Create thumb
							$dst_img = ImageCreateTrueColor($thumb_x, $thumb_y);
							imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_x, $thumb_y, $old_x, $old_y);
							// Save thumb
							imagejpeg($dst_img, $thdir.$file);
						}
					}
				}
			}
		}
		return $files;
	}
	return;
}

// Get digits for currency
function get_currency_digits($currency) {
	switch ($currency) {
		case 'JPY':
		case 'KRW':
			return 0;
		default:
			return 2;
	}
}

// Counts the visit of a user with a reload lock of two hours
// If a film id is given the access to a film is counted
function inccounter($filmid = null) {
	$sid = session_id();

	if (!empty($filmid)) {
		$query = 'SELECT COUNT(id) AS cnt FROM pmp_counter_profil WHERE sid = ? AND NOW() < DATE_ADD(date, INTERVAL 2 HOUR)
				  AND film_id = ?';
		$params = [$sid, $filmid];
		$result = dbquery_pdo($query, $params, 'assoc');

		if (count($result) == 0) {
			$sql = 'INSERT INTO pmp_counter_profil (date, film_id, sid) VALUES (NOW(), ?, ?)';
			$params = [$sid, $filmid];
			dbexecute_pdo($sql, $params);
		}

		$query = 'SELECT COUNT(id) AS cnt FROM pmp_counter_profil WHERE film_id = ?';
		$params = [$filmid];
		$result = dbquery_pdo($query, $params, 'assoc');
		if (count($result) > 0) {
			$all = $result[0]['cnt'];
		}

		$query = 'SELECT COUNT(id) AS cnt FROM pmp_counter_profil WHERE date LIKE CONCAT(CURRENT_DATE, \'%\')
				  AND film_id = ?';
		$params = [$filmid];
		$result = dbquery_pdo($query, $params, 'assoc');
		if (count($result) > 0) {
			$today = $result[0]['cnt'];
		}
	}
	else {
		$query = 'SELECT COUNT(id) AS cnt FROM pmp_counter WHERE sid = ? AND NOW() < DATE_ADD(date, INTERVAL 2 HOUR)';
		$params = [$sid];
		$result = dbquery_pdo($query, $params, 'assoc');

		if (count($result) == 0) {
			$sql = 'INSERT INTO pmp_counter_profil (date, sid) VALUES (NOW(), ?)';
			$params = [$sid];
			dbexecute_pdo($sql, $params);
		}

		$query = 'SELECT COUNT(id) AS cnt FROM pmp_counter';
		$result = dbquery_pdo($query, null, 'assoc');
		if (count($result) > 0) {
			$all = $result[0]['cnt'];
		}

		$query = 'SELECT COUNT(*) AS cnt FROM pmp_counter WHERE date LIKE CONCAT(CURRENT_DATE, \'%\')';
		$result = dbquery_pdo($query, null, 'assoc');
		if (count($result) > 0) {
			$today = $result[0]['cnt'];
		}
	}

	return ['all' => $all, 'today' => $today];
}

// Translates $string. If array $args is given, the values will replaced.
//
// Example:
//
// echo t("Hello %u. How are you?",  array("%u" => 'Frank'));
//
// Output: "Moin Frank. Wie geht es dir?"
function t($string, $args = []) {
	global $lang_data, $_SESSION;

	if (!@count($lang_data)) {
		getLang($_SESSION['lang_id']);
	}

	if (empty($lang_data[$string])) {
		return strtr($string, $args);

		// Use this line if you want to search missing translations
		//return '<strong style="color:red">Missing:</strong> ' . strtr($string, $args);
	}
	else {
		return strtr($lang_data[$string], $args);
	}
}

// Loads the translations from XML file
function getLang($lang_id) {
	global $lang_data, $pmp_theme;

	// First we load the language-file from default
	$data = file_get_contents(_PMP_REL_PATH.'/themes/default/locale/'.$lang_id.'.xml');

	while (strpos($data, '<message')) {
		$tmp = gettween($data, '<message', '</message>');
		$lang_data[gettween($tmp, '<id>', '</id>')] = gettween($tmp, '<string>', '</string>');
		$data = substr($data, strpos($data, '</message>') + 10);
	}

	// Now we add and replace the translations from the theme
	$data = file_get_contents(_PMP_REL_PATH.'/themes/'.$pmp_theme.'/locale/'.$lang_id.'.xml');

	while (strpos($data, '<message')) {
		$tmp = gettween($data, '<message', '</message>');
		$lang_data[gettween($tmp, '<id>', '</id>')] = gettween($tmp, '<string>', '</string>');
		$data = substr($data, strpos($data, '</message>') + 10);
	}
}

// Extract the part between $after an $before
function gettween($string, $after, $before) {
	$start = strpos($string, $after) + strlen($after);
	$stop = strpos($string, $before);

	return substr($string, $start, $stop-$start);
}

// Return all supported languages.
function getLangs() {
	global $pmp_theme;

	$dir = _PMP_REL_PATH.'/themes/'.$pmp_theme.'/locale';
	$handle = opendir($dir);

	while (($file = readdir($handle)) !== false) {
		if (is_file($dir.'/'. $file)) {
			$lg[] = str_replace('.xml', '', $file);
		}
	}
	closedir($handle);
	sort($lg);

	return $lg;
}

// Converts currenty $from to $to
function exchange($from, $to, $value) {
	if ($from == 'EUR') {
		$ratefrom = 1;
	}
	else {
		$query = 'SELECT rate FROM pmp_rates WHERE id = ?';
		$params = [$from];
		$result = dbquery_pdo($query, $params, 'assoc');
		if (count($result) > 0) {
			$ratefrom = $result[0]['rate'];
		}
	}

	if ($to == 'EUR') {
		$rateto = 1;
	}
	else {
		$query = 'SELECT rate FROM pmp_rates WHERE id = ?';
		$params = [$to];
		$result = dbquery_pdo($query, $params, 'assoc');
		if (count($result) > 0) {
			$rateto = $result[0]['rate'];
		}
	}

	if (is_numeric($ratefrom) && is_numeric($rateto)) {
		return sprintf('%01.2f', $rateto * $value / $ratefrom);
	}
	else {
		return -1;
	}
}

// Check for valid email adress
function checkEmail($email) {
	if (preg_match('/^[-+\\.0-9=a-z_]+@([-0-9a-z]+\\.)+([0-9a-z]){2,4}$/i', $email)) {
		return true;
	}
	else {
		return false;
	}
}

// Convert html entites to unicode needed for jpgraph
function entity_to_decimal_value($string) {
	// Only entities we used in locale translation files
	$entity_to_decimal = [
		'&Auml;' => '&#196;',
		'&Ouml;' => '&#214;',
		'&Uuml;' => '&#220;',
		'&auml;' => '&#228;',
		'&ouml;' => '&#246;',
		'&uuml;' => '&#252;',
		'&szlig;' => '&#223;',
		'&AElig;' => '&#198;',
		'&aelig;' => '&#230;',
		'&Aring;' => '&#197;',
		'&aring;' => '&#229;',
		'&Oslash;' => '&#216;',
		'&oslash;' => '&#248;',
		'&euml;' => '&#235;',
		'&Euml;' => '&#203;',
		'&iuml;' => '&#239;',
		'&Iuml;' => '&#207;'
	];

	return preg_replace('/&#38;[A-Za-z]+;/', ' ', strtr($string, $entity_to_decimal));
}

function getRemoteContent($site) {
	if (ini_get('allow_url_fopen')) {
		$content = @file_get_contents($site);
		return $content;
	}
	else if (extension_loaded('curl')) {
		$ch = curl_init($site);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$content = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);
		if ($error == '') {
			return $content;
		}
		else {
			return '';
		}
	}
	else if (function_exists('http_get')) {
		$tmp = http_parse_message(http_get($site));
		$content = $tmp->body;
		return $content;
	}
	else if (function_exists('ini_set')) {
		require_once('HTTP/Request2.php');

		$request = new HTTP_Request2($site, HTTP_Request2::METHOD_GET);
		try {
			$response = $request->send();
			if (200 == $response->getStatus()) {
				return $response->getBody();
			} else {
				echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
			}
		} catch (HTTP_Request2_Exception $e) {
			return '';
		}
	}
	else {
		return '';
	}
}

function add_include_path($strIncludePath) {
	$strIncludePath = realpath($strIncludePath);
	if (empty($strIncludePath)) {
		return;
	}

	if (function_exists('ini_set')) {
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$strIncludePath);
	}
	else {
		$arrIncludePaths = explode(PATH_SEPARATOR, get_include_path());
		$arrIncludePaths[] = $strIncludePath;
		$arrIncludePaths = array_unique($arrIncludePaths);
		set_include_path(implode(PATH_SEPARATOR, $arrIncludePaths));
	}
}

// Taken from http://php.net/manual/de/function.is-writable.php
function is__writable($path) {
	// will work in despite of Windows ACLs bug
	// NOTE: use a trailing slash for folders!!!
	// see http://bugs.php.net/bug.php?id=27609
	// see http://bugs.php.net/bug.php?id=30931

	if ($path{strlen($path)-1} == '/') {
		// recursively return a temporary file path
		return is__writable($path.uniqid(mt_rand()).'.tmp');
	}
	else if (is_dir($path)) {
		return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
	}

	// check tmp file for read/write capabilities
	$rm = file_exists($path);
	$f = @fopen($path, 'a');

	if ($f === false) {
		return false;
	}

	fclose($f);

	if (!$rm) {
		unlink($path);
	}

	return true;
}

// Taken from http://php.net/strip_tags
function html2txt($document) {
	$search = [
		'@<script[^>]*?>.*?</script>@si',	// Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',			// Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',	// Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'			// Strip multi-line comments including CDATA
	];

	$text = preg_replace($search, '', $document);
	return $text;
}

// Get all available collections
function get_collections() {
	// This "base" is needed because not every user collection has these three standard collections
	$collections = ['Owned', 'Ordered', 'Wish List'];

	$query = 'SELECT collection FROM pmp_collection WHERE collection NOT IN(\'Owned\', \'Ordered\', \'Wish List\')';
	$result = dbquery_pdo($query, null, 'assoc');
	if (count($result) > 0) {
		foreach ($result as $col) {
			$collections[] = $col["collection"];
		}
	}

	return $collections;
}

// Get base url
function get_base_url() {
	$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'? 'https://' : 'http://';
	return $http.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI'].'?').'/';
}
?>
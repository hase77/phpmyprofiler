<?php
/* phpMyProfiler
 * Copyright (C) 2007-2014 The phpMyProfiler project
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

$pmp_module = 'admin_updateawards';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Update Awards'));
$smarty->assign('header_img', 'updateawards');
$smarty->assign('session', session_name() . "=" . session_id() );

function startElement($parser, $name, $attrs) {
	global $awards, $category_i, $movie_i;

	if ( $name == 'AWARD' ) {
		$awards = array('AWARD' => maskData($attrs['NAME']),
				'YEAR' => maskData($attrs['YEAR']));
	}
	if ( $name == 'CATEGORY' ) {
		$category_i++;
		$movie_i = 0;
		$awards['CATEGORY'][$category_i] = array('NAME' => maskData($attrs['NAME']));
	}
	if ( $name == 'MOVIE' ) {
		$movie_i++;
		$awards['CATEGORY'][$category_i]['MOVIE'][$movie_i] = array('TITLE' => maskData($attrs['NAME']),
			'WINNER' => maskData(getIsset($attrs['WON'])));
	}
}

function endElement($parser, $name) {
	global $awards, $category_i, $movie_i, $tmp;

	$data = $tmp;

	if ( trim($data) != null ) {
		$awards['CATEGORY'][$category_i]['MOVIE'][$movie_i]['NOMINEE'] = maskData(trim($data));
	}

	$tmp = '';

	if ( $name == 'AWARD' ) {
		writeAward();
	}
}

function characterData($parser, $data) {
	global $tmp;

	$tmp .= $data;
}

function writeAward() {
	global $awards, $category_i, $del, $insert, $max_packet;

	// Delete existing awards
	if ( empty($del) ) $del = "DELETE FROM pmp_awards WHERE ";
	$del .= "(award='" . trim(mysql_real_escape_string(stripslashes($awards['AWARD']))) . "' AND awardyear='" . trim(mysql_real_escape_string($awards['YEAR'])) . "') OR ";

	// Go through all categories
	for ($i = 1; $i <= count($awards['CATEGORY']); $i++) {
		// Go through all movies of category
		for ($p = 1; $p <= count($awards['CATEGORY'][$i]['MOVIE']); $p++) {
			// Winner or not
			if ( $awards['CATEGORY'][$i]['MOVIE'][$p]['WINNER'] == 'True' ) {
				$win = 1;
			} else {
				$win = 0;
			}
			if ( empty($insert) ) $insert = "INSERT INTO pmp_awards VALUES ";
			$insert .= "('".trim(mysql_real_escape_string(stripslashes($awards['CATEGORY'][$i]['MOVIE'][$p]['TITLE']))) . "','"
			. "','"
			. trim(mysql_real_escape_string(stripslashes($awards['AWARD']))) . "','"
			. trim(mysql_real_escape_string($awards['YEAR'])) . "','"
			. trim(mysql_real_escape_string($awards['CATEGORY'][$i]['NAME'])) . "','"
			. $win . "','"
			. trim(mysql_real_escape_string(getIsset($awards['CATEGORY'][$i]['MOVIE'][$p]['NOMINEE']))) . "'),";
		}
	}
	if ( isset($insert) && strlen($insert) >= $max_packet ) {
		dbexec(substr($del,0,-4).";");
		$del = '';
		dbexec(substr($insert,0,-1).";");
		$insert = '';
	}
	
	$awards = '';
	$category_i = 0;
}

// Change in the awards folder
chdir('../awards');

// Delete Files
if ( (isset($_GET['action'])) && ($_GET['action'] == "delete") ) {
	if ( file_exists('./' . basename($_GET['file'])) ) {
		if ( @unlink('./' . basename($_GET['file'])) ) {
			$smarty->assign('Success', basename($_GET['file']) . ' ' . t('deleted.'));
		}
		else {
			$smarty->assign('Error', basename($_GET['file']) . ' ' . t('can\'t be deleted.'));
		}
	}
	else {
		$smarty->assign('Error', basename($_GET['file']) . ' ' . t('not found.'));
	}
}

// Delete award
if ( (isset($_GET['action'])) && ($_GET['action'] == "deleteaward") ) {
	if ( isset($_GET['award']) ) {
		dbconnect();

		// Delete existing awards
		$del = 'DELETE FROM pmp_awards WHERE award = \'' . mysql_real_escape_string($_GET['award']) . '\';';
		dbexec($del, true);
	}
}

// Parse into db
if ( (isset($_GET['action'])) && ($_GET['action'] == "parse") ) {
	if ( isset($_GET['file']) ) {

		dbconnect();
		$max_packet = getMaxPacket();

		// This may take longer
		@set_time_limit(0);
		@ignore_user_abort(1);

		$category_i = 0;
		$movie_i = 0;

		$xml_parser = xml_parser_create();
		xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
		xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, false);
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($xml_parser, "characterData");

		if ( !($fp = fopen($_GET['file'], "r")) ) die('could not open XML input');

		while ( $data = fread($fp, 1024) ) {
			if ( !xml_parse($xml_parser, $data, feof($fp)) ) {
				die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
			}
		}
		xml_parser_free($xml_parser);

		if ( !empty($del) ) dbexec(substr($del,0,-4));
		if ( !empty($insert) ) dbexec(substr($insert,0,-1));

		$smarty->assign('Success', basename($_GET['file']) . ' ' . t('parsed.'));

		dbclose();
	}
}

// Build tags
if ( (isset($_GET['action'])) && ($_GET['action'] == "buildtags") ) {
	if ( isset($_GET['award']) ) {
		dbconnect();

		$max_packet = getMaxPacket();

		// Delete existing tags
		$del = "DELETE FROM pmp_tags WHERE name = '" . $_GET['award'] . "';";
		dbexec($del, true);

		// Get winner by orinal title
		$sql = "SELECT DISTINCT id FROM pmp_film LEFT JOIN pmp_awards ON LOWER(pmp_film.originaltitle) = LOWER(pmp_awards.title) WHERE award = '" . mysql_real_escape_string($_GET['award']) . "' AND winner ='1' AND originaltitle != '' AND awardyear BETWEEN pmp_film.prodyear-1 AND pmp_film.prodyear+1;";
		$res = dbexec($sql);
		$count = mysql_num_rows($res);
		while ($row = mysql_fetch_object($res)) {
			if ( empty($insert) ) $insert = "INSERT INTO pmp_tags VALUES ";
			$insert .= "('" . $row->id . "', '" . mysql_real_escape_string($_GET['award']) . "', '" . mysql_real_escape_string($_GET['award']) . "'),";
			if ( isset($insert) && $insert >= $max_packet ) {
				dbexec(substr($insert,0,-1).";");
				$insert = '';
			}
		}
		if ( !empty($insert) ) {
			dbexec(substr($insert,0,-1).";");
			$insert = '';
		}

		// Get winner by title
		$sql = "SELECT DISTINCT id FROM pmp_film LEFT JOIN pmp_awards ON LOWER(pmp_film.title) = LOWER(pmp_awards.title) WHERE award = '" . mysql_real_escape_string($_GET['award']) . "' AND winner ='1' AND originaltitle = '' AND awardyear BETWEEN pmp_film.prodyear-1 AND pmp_film.prodyear+1;";
		$res = dbexec($sql);
		$count = $count + mysql_num_rows($res);
		while ($row = mysql_fetch_object($res)) {
			if ( empty($insert) ) $insert = "INSERT INTO pmp_tags VALUES ";
			$insert .= "('" . $row->id . "', '" . mysql_real_escape_string($_GET['award']) . "', '" . mysql_real_escape_string($_GET['award']) . "'),";
			if ( isset($insert) && $insert >= $max_packet ) {
				dbexec(substr($insert,0,-1).";");
				$insert = '';
			}
		}
		if ( !empty($insert) ) {
			dbexec(substr($insert,0,-1).";");
			$insert = '';
		}

		// Delete cached templates
		delCachedTempPHP();

		$smarty->assign('Success', t('Tags table updated.') . ' ' . $count . ' ' . t('Tags created.'));

		dbclose();
	}
}

// Search for award files
$handle = opendir ('.');

$files = array();

while ( false !== ($file = readdir ($handle)) ) {
	if ( strrchr($file, '.') == '.xml'  ) {
		$size = filesize($file);
		$typ = 'Byte';

		if ( $size > 1024 ) {
			$size = $size/1024;
			$typ = 'Kilobyte';
		}
		if ( $size > 1024 ) {
			$size = $size/1024;
			$typ = 'Megabyte';
		}

		$files[] = array('name' => $file, 'size' => intval($size) . ' ' . $typ);
	}
}
closedir($handle);

// Found one file or not ?
if ( $files ) {
	$smarty->assign('Files', $files);
}
else {
	$smarty->assign('Info', t('First of all you have to upload an award file to the award directory.'));
}

$types = NULL;
dbconnect();
$sql = 'SELECT DISTINCT award FROM pmp_awards ORDER BY award ASC';
$res = dbexec($sql, false);
while ( $row = mysql_fetch_object($res) ) {
	$types[] = stripslashes($row->award);
}
$smarty->assign('Types', $types);
dbclose();

$smarty->display('admin/updateawards.tpl');
?>
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

$pmp_module = 'admin_parse';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../admin/include/Parser.class.php');
require_once('../admin/include/updateStats.class.php');
require_once('../include/banner.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Parse XML file'));
$smarty->assign('header_img', 'parse');
$session = session_name() . "=" . session_id();
$smarty->assign('session', $session );

$smarty->assign('pmp_parser_mode', $pmp_parser_mode);

// Change in the xml folder
chdir('../xml');

// Function to split the xml file
function splitxml($filename) {
	global $pmp_splitxmlafter;

	$in = fopen($filename, "r");
	$keep = false;
	$x = 0;
	$count = 1;
	$over = false;
	$dvd = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Collection>\n";

	while ( !feof($in) ) {
		$line = iconv('Windows-1252', 'UTF-8', fgets($in, 4096));

		// Remove ascii control chars from overview
		if ( strpos($line, '<Overview>') !== false || $over ) {
			$line = preg_replace( '#[\x00-\x08\x0b-\x0c\x0e-\x1f]+#S', '', $line);
			$over = true;
		}
		if ( strpos($line, '</Overview>') !== false ) {
			$over = false;
		}

		// Beginn of dvd data
		if ( (strpos($line, '<DVD>') !== false) && (strpos($line, '</DVD>') === false) ) {
			$keep = !$keep;
		}

		// Data of dvd
		if ( $keep ) {
			$dvd .= $line;
		}

		// End of dvd data / Ken used the DVD tag twice! Media DVD!
		if ( (strpos($line, '</DVD>') !== false) && (strpos($line, '<DVD>') === false) ) {
			file_put_contents('./split/' . str_replace('.xml', '', $filename) . '_' . str_pad($count, 3, '0', STR_PAD_LEFT) . '.xml', $dvd, FILE_APPEND);

			$keep = false;
			unset($dvd);
			$dvd = '';

			if ( ++$x >= $pmp_splitxmlafter ) {
				file_put_contents('./split/' . str_replace('.xml', '', $filename) . '_' . str_pad($count, 3, '0', STR_PAD_LEFT) . '.xml',"</Collection>" , FILE_APPEND);
				$x = 0;
				$count++;
				$dvd = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Collection>\n";
			}
		}
	}

	fclose ($in);

	if ( $x != 0 ) {
		file_put_contents('./split/' . str_replace('.xml', '', $filename) . '_' . str_pad($count, 3, '0', STR_PAD_LEFT) . '.xml',"</Collection>" , FILE_APPEND);
	}
}

// Function to stop the time to inport the file
function microtime_float() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

// This may take longer
@set_time_limit(0);
@ignore_user_abort(1);

// Delete Files
if  ( (isset($_GET['action'])) && ($_GET['action'] == 'delete') ) {
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

if ( (isset($_GET['action'])) && ($_GET['action'] == 'split') ) {
	// Delete old files when not deleted by failed parse
	$handle = opendir('./split');
	while ( ($file = readdir($handle)) !== false ) {
		if ( strrchr($file, '.') == '.xml' ) {
			unlink('./split/' . basename($file));
		}
	}
	closedir($handle);

	$start = microtime_float();

	// Split
	splitxml('./' . basename($_GET['file']));

	// Get first file
	$dh = opendir('./split');
	if ( $dh ) {
		$files = array();
		while ( ($file = readdir($dh)) !== false ) {
			if ( substr($file, strlen($file) - 4) == '.xml' ) {
				array_push($files, $file);
			}
		}

		closedir($dh);
		sort($files);
	}

	header("Location:parse.php?action=parse&empty=true&file=" . $files[0] . "&start=" . $start . "&" . $session);
	exit();
}

if ( (isset($_GET['action'])) && ($_GET['action'] == 'parse') ) {
	if ( isset($_GET['file']) ) {
		if ( isset($_GET['empty']) ) {
			$empty = true;
		} else {
			$empty = false;
		}

		if ( isset($_GET['count']) ) {
			$count = $_GET['count'];
		} else {
			$count = 0;
		}
		if ( isset($_GET['splits']) ) {
			$splits = $_GET['splits'];
		} else {
			$splits = 0;
		}

		if ( $pmp_parser_mode == 0 ) {
			$start = $_GET['start'];
		} else {
			$start = microtime_float();
		}

		dbconnect();

		if ( $pmp_parser_mode != 0 ) {
			// Used when last parse failed
			if ( mysql_num_rows(dbexec("SHOW TABLES LIKE 'pmp_temptable'") ) != 0) {
				dbexec("TRUNCATE TABLE pmp_temptable");
			} else {
				// Build a temporary table to identify deleted profiles
				dbexec("CREATE TABLE pmp_temptable (`id` VARCHAR(20), `type` VARCHAR(9), PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
			}
		}

		// Parse the split
		$Parser = new Parser;
		$Parser->cleanDB($empty);
		#$Parser->lockTables();
		if ( $pmp_parser_mode == 0 ) {
			$count += $Parser->start('./split/' . $_GET['file']);
		}
		else {
			$count += $Parser->start('./'.$_GET['file']);
		}
		#$Parser->unlockTables();
		dbclose();
		$splits++;

		if ( $pmp_parser_mode == 0 ) {
			// Delete the split
			unlink('./split/' . $_GET['file']);

			// Get next file to parse
			$dh = opendir('./split');
			if ( $dh ) {
				$files = array();
				while ( ($file = readdir($dh)) !== false ) {
					if ( substr($file, strlen($file) - 4) == '.xml' ) {
						array_push($files, $file);
					}
				}
				closedir($dh);
				sort($files);
			}
		}

		if ( !empty($files) ) {
			header("Location:parse.php?action=parse&file=" . $files[0] . "&count=" . $count . "&splits=" . $splits . "&start=" . $start . "&" . $session);
			exit();
		}
		else {
			header("Location:parse.php?action=finish&count=" . $count . "&splits=" . $splits . "&start=" . $start . "&" . $session);
			exit();
		}
	}
}

if ( (isset($_GET['action'])) && ($_GET['action'] == 'finish') ) {
	$deleted = 0;

	// Update stats table
	dbconnect();
	$updateStats = new updateStats;
	$updateStats->update();

	// Build reviews
	if ( $pmp_parser_mode != 0 ) {
		$sql = "SELECT DISTINCT (id) FROM pmp_temptable WHERE `type` != 'unaltered'";
	} else {
		$sql = "SELECT DISTINCT (id) FROM pmp_reviews_connect";
	}
	$result = dbexec($sql);
	if ( mysql_num_rows($result) != 0 ) {
		while ( $film = mysql_fetch_object($result) ) {
			$review = 0;
			$votes = 0;
			$sql = "SELECT * FROM pmp_reviews_connect LEFT JOIN pmp_reviews_external ON review_id = pmp_reviews_external.id WHERE pmp_reviews_connect.id = '" . $film->id . "'";
			$res = dbexec($sql);
			while ( $row = mysql_fetch_object($res) ) {
				if ( $row->review != 0 && $row->votes != 0 ) {
					if ( $row->type == 'rotten_u' ) {
						$review = $review + ( ( 2 * $row->review ) * $row->votes );
					}
					else {
						$review = $review + ( $row->review * $row->votes );
					}
					$votes = $votes + ( $row->votes );
				}
			}
			if ( $votes != 0 && $review != 0 ) {
				$review = $review / $votes;
				dbexec("UPDATE pmp_film SET review = '" . $review . "' WHERE id = '" . $film->id . "'");
			}
		}
	}

	if ( $pmp_parser_mode != 0 ) {
		// What's changed while parsing?
		$sql = "SELECT `type`, COUNT(*) AS count FROM pmp_temptable GROUP BY `type`";
		$res = dbexec($sql);
		if ( mysql_num_rows($res) != 0 ) {
			while ( $row = mysql_fetch_object($res) ) {
				$profiles[$row->type] = $row->count;
			}
			if ( $pmp_parser_mode == 1 ) {
				$sql = "SELECT id FROM pmp_film WHERE id NOT IN (SELECT id FROM pmp_temptable)";
				$res = dbexec($sql);
				$profiles['deleted'] = mysql_num_rows(dbexec($sql));

				// Delete missing profiles
				if ($profiles['deleted'] != 0) {
					$tables = array('pmp_film',
						'pmp_actors',
						'pmp_credits',
						'pmp_features',
						'pmp_format',
						'pmp_locks',
						'pmp_tags',
						'pmp_audio',
						'pmp_subtitles',
						'pmp_discs',
						'pmp_events',
						'pmp_genres',
						'pmp_regions',
						'pmp_studios',
						'pmp_media_companies',
						'pmp_boxset',
						'pmp_hash',
						'pmp_counter_profil');
					foreach ( $tables AS $table ) {
						$sql = "DELETE FROM ".$table." WHERE id NOT IN (SELECT id FROM pmp_temptable)";
						dbexec($sql);
					}
				}
			}
		}
		// Delete temporary table
		$sql = "DROP TABLE pmp_temptable";
		dbexec($sql);
	}

	dbclose();
	
	// Flush smarty cache
	// Don't use $smarty->clear_all_cache(), this will also delete all thumbnails
	delCachedTempPHP();
	
	// Generate external review top and screenshot tags
	genTopTags();
	list ($ids, $link, $indb, $notindb, $symlink, $windows) = getScreenshotsAdm('../screenshots');
	genScreenshotTag($indb);

	// ToDo: Award tags and on/off option

	if ( ($pmp_gdlib == true) && ($pmp_thumbnail_cache == true) ) {
		// Delete unneeded cached thumbnails
		$handle = opendir('../cache/');
		while ( ($file = readdir($handle)) !== false ) {
			// Don't delete generated captcha-images
			if ( ((strrchr($file, '.') == '.jpg') && (stristr($file, 'b2evo_captcha') === false )) || (strrchr($file, '.') == '.png') ) {
				// Get name of original file
				$sourceFilename = substr($file, strrpos($file, '_')+1);

				// Delete thumbnails where cover are not exists
				if ( !is_file('../cover/' . $sourceFilename) ) {
					@unlink('../cache/' . basename($file));
					$deleted++;
				}
				// Delete thumbnails where cover has changed
				else if ( md5_file('../cover/' . $sourceFilename) != substr($file, strpos($file, '_')+1, strrpos($file, '_')-strpos($file, '_')-1) ) {
					@unlink('../cache/' . basename($file));
					$deleted++;
				}

				// Delete generated cache files by jpgraph
				if ( (strrchr($file, '.') == '.png') == true) {
					@unlink('../cache/' . basename($file));
				}
			}
		}

		closedir($handle);
	}

	if ( isset($pmp_build_banners) && $pmp_build_banners != 0) {
		if ( !buildBanners() ) $smarty->assign('Error','Something went wrong when building banner(s).');
	}

	chdir('../xml/');
	$end = microtime_float();

	$smarty->assign('count', $_GET['count']);
	if ( $pmp_parser_mode == 0 ) $smarty->assign('split', $_GET['splits']);
	$smarty->assign('time', $end - $_GET['start']);
	$smarty->assign('deleted', $deleted);
	if ( isset($profiles) ) $smarty->assign('profiles', $profiles);
}

// Search for Collection Files in XML Format
$handle = opendir ('.');

$files = array();

while ( false !== ($file = readdir($handle)) ) {
	if ( strrchr($file, '.') == '.xml' ) {
		$size = filesize($file);
		$typ = "Byte";

		if ( $size > 1024 ) {
			$size = $size/1024;
			$typ = "Kilobyte";
		}
		if ( $size > 1024 ) {
			$size = $size/1024;
			$typ = "Megabyte";
		}

		$files[] = array('name' => $file, 'size' => intval($size) . ' ' . $typ);
	}
}

closedir($handle);

// Found one file or not?
if ( $files ) {
	$smarty->assign('Files', $files);
}
else {
	$smarty->assign('Info', t('First of all you have to upload the exported XML-file to the xml directory. Also you can compress this file and upload a zip-file with the form of this page.'));
}

$smarty->display('admin/parse.tpl');
?>
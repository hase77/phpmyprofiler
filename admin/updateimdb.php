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

define('_PMP_REL_PATH', '..');

$pmp_module = 'admin_updateimdb';

require_once('../config.inc.php');
require_once('../custom_media.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../admin/include/extRatings.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Update external reviews'));
$smarty->assign('header_img', 'updateimdb');
$session = session_name() . "=" . session_id();
$smarty->assign('session', session_name() . "=" . session_id());

if (isset($_GET['action']) && ($_GET['action'] == 'update') && !isset($_GET['start'])) {
	@list($db, $wh) = preg_split('/_/', $_GET['what']);

	$sql = "SELECT ext_id, type, lastupdate FROM pmp_reviews_external ";
	if ($db == 'rotten') {
		$sql .= "WHERE type = 'rotten_c'";
	}
	else {
		$sql .= "WHERE type = '".$db."'";
	}
	if ( isset($wh) ) {
		if ($wh == 'old') {
			$sql .= " AND (to_days(lastupdate) < (to_days(now())-28) OR lastupdate = '0000-00-00')";
		}
		elseif ($wh == 'new') {
			$sql .= " AND lastupdate = '0000-00-00'";
		}
		elseif ($wh == 'oldest') {
			$sql .= " ORDER BY lastupdate ASC LIMIT 0, 50";
		}
	}

	dbconnect();
	$result = dbexec($sql);
	$maxids = mysql_num_rows($result);
	dbclose();

	if ( $maxids == 0 ) {
		$smarty->assign('Error', t('Nothing to do.'));
	}
	else {
		if ( isset($wh) ) {
			header("Location:updateimdb.php?action=update&what=".$db."_".$wh."&start=1&end=" . $maxids . "&" . $session);
		}
		else {
			header("Location:updateimdb.php?action=update&what=".$db."&start=1&end=" . $maxids . "&" . $session);
		}
		exit;
	}
}

if (isset($_GET['action']) && ($_GET['action'] == 'update') && isset($_GET['start'])) {
	$lastround = false;
	@list($db, $wh) = preg_split('/_/', $_GET['what']);
	$maxids = $_GET['end'];
	$startid = $_GET['start'] - 1;
	$endid = $startid + 100;
	if ($endid >= $maxids) {
		$endid = $maxids;
		$lastround = true;
	}

	$sql = "SELECT * FROM pmp_reviews_external ";
	if ($db == 'rotten') {
		$sql .= "WHERE type = 'rotten_c'";
	} else {
		$sql .= "WHERE type = '".$db."'";
	}
	if (isset($wh)) {
		if ( $wh == 'old' ) {
			$sql .= " AND (to_days(lastupdate) < (to_days(now())-28) OR lastupdate = '0000-00-00') LIMIT 0, " . ( $endid - $startid );
		} elseif ( $wh == 'new' ) {
			$sql .= " AND lastupdate = '0000-00-00' LIMIT 0, " . ( $endid - $startid );
		} elseif ( $wh == 'oldest' ) {
			$sql .= " ORDER BY lastupdate ASC LIMIT 0, 50";
		}
	} else {
		$sql .= " LIMIT " . $startid . " , " . ( $endid - $startid );
	}

	dbconnect();
	$result = dbexec($sql);

	// We need some time to do this
	@set_time_limit(0);
	@ignore_user_abort(1);

	$replace = "REPLACE INTO pmp_reviews_external (id,type,ext_id,review,votes,top250,bottom100,lastupdate) VALUES ";

	while ( $row = mysql_fetch_object($result) ) {
		if ( $db == 'imdb' ) {
			$id = $row->ext_id;
			$site = getIMDBSite($id);
			$data = getIMDBRating($site);
			$data[1] = str_replace(',', '', $data[1]);
		}
		elseif ( $db == 'ofdb' ) {
			$id = $row->ext_id;
			$site = getOFDBSite($id);
			$data = getOFDBRating($site);
		}
		else {
			$id = $row->ext_id;
			$site = getRottenSite($id);
			$data = getRottenRating($site);
			$data[1] = str_replace(',', '', $data[1]);
			$data[3] = str_replace(',', '', $data[3]);
		}
		if ( $db == 'rotten' ) {
			$replace .= "('".$row->id."','rotten_c','".$row->ext_id."','".$data[0]."','".$data[1]."',NULL,NULL,'".date('Y-m-d')."'),";
			$replace .= "('".($row->id + 1)."','rotten_u','".$row->ext_id."','".$data[2]."','".$data[3]."',NULL,NULL,'".date('Y-m-d')."'),";
		} else {
			$replace .= "('".$row->id."','".$row->type."','".$row->ext_id."','".$data[0]."','".$data[1]."',".$data[2].",".$data[3].",'".date('Y-m-d')."'),";
		}
	}

	if ( substr($replace, -1) == ',' ) {
		dbexec(substr($replace, 0, -1).';');
	}

	if ($lastround) {
		$sql = "SELECT DISTINCT (id) FROM pmp_reviews_connect";
		$result = dbexec($sql);
		if (mysql_num_rows($result) != 0) {
			$replace = "REPLACE INTO pmp_film (id,review) VALUES ";
			while ( $film = mysql_fetch_object($result) ) {
				$review = 0;
				$votes = 0;
				$sql = "SELECT * FROM pmp_reviews_connect LEFT JOIN pmp_reviews_external ON review_id = pmp_reviews_external.id WHERE pmp_reviews_connect.id = '" . $film->id . "'";
				$res = dbexec($sql);
				while ( $row = mysql_fetch_object($res) ) {
					if ( $row->review != 0 && $row->votes != 0 ) {
						if ( $row->type == 'rotten_u' ) {
							$review = $review + ( ( 2 * $row->review ) * $row->votes );
						} else {
							$review = $review + ( $row->review * $row->votes );
						}
						$votes = $votes + ( $row->votes );
					}
				}
				if ($votes != 0 && $review != 0) {
					$review = $review / $votes;
					dbexec("UPDATE pmp_film SET review = '" . $review . "' WHERE id = '" . $film->id . "'");
				}
			}
		}
		dbclose();
		$smarty->assign('Success', t('Table successfully updated.'));
	} else {
		dbclose();
		$endid++;

		if (isset($wh)) {
			header("Location:updateimdb.php?action=update&what=".$db."_".$wh."&start=".$endid."&end=" . $maxids . "&" . $session);
		} else {
			header("Location:updateimdb.php?action=update&what=".$db."&start=".$endid."&end=" . $maxids . "&" . $session);
		}
		exit;
	}
}

if (isset($_GET['action']) && ($_GET['action'] == 'imdbtop250') ) {
	genTopTags();

	delCachedTempPHP();

	$smarty->assign('Success', t('Tags table updated.'));
}

//Get infos about known data
dbconnect();

// IMDB
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'imdb'";
$smarty->assign('imdb_all', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'imdb' AND (to_days(lastupdate) < (to_days(now())-28) OR lastupdate = '0000-00-00')";
$smarty->assign('imdb_old', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'imdb' AND lastupdate = '0000-00-00'";
$smarty->assign('imdb_new', mysql_num_rows(dbexec($sql)));

// OFDB
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'ofdb'";
$smarty->assign('ofdb_all', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'ofdb' AND (to_days(lastupdate) < (to_days(now())-28) OR lastupdate = '0000-00-00')";
$smarty->assign('ofdb_old', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'ofdb' AND lastupdate = '0000-00-00'";
$smarty->assign('ofdb_new', mysql_num_rows(dbexec($sql)));

// RottenTomatoes
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'rotten_c'";
$smarty->assign('rotten_all', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'rotten_c' AND (to_days(lastupdate) < (to_days(now())-28) OR lastupdate = '0000-00-00')";
$smarty->assign('rotten_old', mysql_num_rows(dbexec($sql)));
$sql = "SELECT id FROM pmp_reviews_external WHERE type = 'rotten_c' AND lastupdate = '0000-00-00'";
$smarty->assign('rotten_new', mysql_num_rows(dbexec($sql)));

dbclose();

$smarty->display('admin/updateimdb.tpl');
?>
<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
 * Copyright (C) 2004-2014 The phpMyProfiler project
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

$pmp_module = 'admin_pictures';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Photos'));
$smarty->assign('header_img', 'photos');
$smarty->assign('session', session_name() . "=" . session_id());

dbconnect();

// Delete picture
if ( (isset($_GET['action'])) && ($_GET['action'] == 'delete') ) {
	if ( !empty($_GET['id']) ) {
		$sql = "SELECT filename FROM pmp_pictures WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'";
		$res = dbexec($sql);
		$row = mysql_fetch_object($res);
		@unlink('../pictures/' . $row->filename);

		$sql = "DELETE FROM pmp_pictures WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'";
		$res = dbexec($sql);

		$smarty->assign('Success', t('The picture was successfully removed.'));
	}
}

// Add new picture
if ( (isset($_GET['action'])) && ($_GET['action'] == 'add') ) {
	if ( (isset($_FILES['picture'])) && ($_FILES['picture']['name'] != '') ) {
		if ( !is_writeable('../pictures/') ) {
			$smarty->assign('Error', t('The directory pictures is not writeable.'));
		}
		else {
			if ( $_FILES['picture']['error'] == UPLOAD_ERR_OK ) {
				$img_info = getimagesize($_FILES['picture']['tmp_name']);
				switch($img_info[2]) {
					case 1: $ext = '.gif'; break;
					case 2: $ext = '.jpg'; break;
					case 3: $ext = '.png'; break;
					case 4: $ext = '.swf'; break;
					default: $ext = false; break;
				}

				if ( $ext !== false ) {
					if ( !empty($_POST['filename']) ) {
						// Not allowed letters
						$notallow = array('>', '<', '?', ':', '/', '*', '"', "\\", '|');

						for ($x = 0; $x < count($notallow); $x++) {
							$_POST['filename'] = str_replace($notallow[$x], '', $_POST['filename']);
						}

						$search = array('/ä/', '/ö/', '/Ü/', '/Ä/', '/Ö/', '/Ü/', '/ß/');
						$replace = array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss');
						$_POST['filename'] = preg_replace($search, $replace, $_POST['filename']);
						$_POST['filename'] = preg_replace('/[ ]+/', ' ', $_POST['filename']);

						$name = trim($_POST['filename']) . $ext;
					}

					if ( (empty($_POST['filename'])) || (strlen($name) < 5) ) {
						if ( strlen($name) < 5 ) {
							$smarty->assign('Error', t("Filename is wrong and can't be used. New Filename generated."));
						}

						// Using the md5-hash as filename, because not all browser tell me the
						// name of the origin file. Using the hash I have always a unambiguous filename.
						$name = md5_file($_FILES['picture']['tmp_name']) . $ext;
					}

					if ( !file_exists('../pictures/' . $name) ) {
						if ( move_uploaded_file($_FILES['picture']['tmp_name'], '../pictures/' . $name) ) {
							@chmod('../pictures/' . $name, 0644);
							$sql = "INSERT INTO pmp_pictures (filename, title) VALUES ('" . mysql_real_escape_string($name)
							. "', '" . mysql_real_escape_string($_POST['title']) . "')";
							$res = dbexec($sql);

							$smarty->assign('Success', t('Added a new picture.'));
						}
						else {
							$smarty->assign('Error', t("Can not move file from tmp into pictures dir."));
						}
					}
					else {
						$smarty->assign('Error', t("File exists."));
					}
				}
				else {
					$smarty->assign('Error', t('Wrong file type!'));
					@unlink($_FILES['picture']['tmp_name']);
				}
			}
			else {
				$smarty->assign('Error', t('Upload failed!') . ' '. t('Error No:') . ' ' . $_FILES['picture']['error']);
			}
		}
	}
	else {
		$smarty->assign('Error', t('You need to select a file first!'));
	}
}

$sql = "SELECT * FROM pmp_pictures";
$res = dbexec($sql);

$pics = array();

while ( $row = mysql_fetch_object($res) ) {
	if ( file_exists('../pictures/' . $row->filename) ) {
		$row->size = filesize('../pictures/' . $row->filename );
		$img_info = getimagesize('../pictures/' . $row->filename );
		$row->x = $img_info[0];
		$row->y = $img_info[1];
		$row->image = str_replace(' ', '%20', $row->filename);
		$row->title = htmlentities($row->title, ENT_QUOTES, 'UTF-8');
		$row->fileexist = true;
	}
	$pics[] = $row;
}

$smarty->assign('pics', $pics);
$smarty->display('admin/pictures.tpl');
?>
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

define('_PMP_REL_PATH', '..');

$pmp_module = 'admin_screenshots';

require_once('../config.inc.php');
require_once('../include/functions.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

function rrmdir($dir) {
	$success = false;
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		$success = rmdir($dir);
	}
	return $success;
}

function entenc($text){
	// This is needed for german umlauts
	$res = '';
	for ($i = 0; $i < strlen($text); $i++) {
		$cc = ord($text{$i});
		if ($cc >= 128 || $cc == 38) {
			$res .= "_";
		} else {
			$res .= chr($cc);
		}
	}
	return $res;
}

function uncompress_all($zip_file, $path) {
	if (file_exists($path.DIRECTORY_SEPARATOR.$zip_file) && ($zip = zip_open($path.DIRECTORY_SEPARATOR.$zip_file))) {
		$i = 1;
		while ( is_dir($path.DIRECTORY_SEPARATOR.'screens-'.sprintf('%1$04d', $i)) ) {
			$i++;
		}
		$dest_dir = $path.DIRECTORY_SEPARATOR.'screens-'.sprintf('%1$04d', $i);
		while ( $zip_entry = zip_read($zip) ) {
			$file_name = entenc(zip_entry_name($zip_entry));
			$file_size = zip_entry_filesize($zip_entry);
			$comp_meth = zip_entry_compressionmethod($zip_entry);
			if ( zip_entry_open($zip, $zip_entry, 'rb') ) {
				$buffer = zip_entry_read($zip_entry, $file_size);
				if ( !strpos($file_name, '/thumbs/') ) {
					if (preg_match('/\/$/', $file_name) && ($comp_meth == 'stored')) {
						$dest_dir = $path.DIRECTORY_SEPARATOR.basename($file_name);
					} else {
						if (!is_dir($dest_dir)) @mkdir($dest_dir, 0777);
						$fp = fopen($dest_dir.DIRECTORY_SEPARATOR.basename($file_name), 'wb');
						fwrite($fp, $buffer);
						fclose($fp);
					}
				}
				zip_entry_close($zip_entry);
			}
		}
		zip_close($zip);
		return true;
	} else {
		return false;
	}
}

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Screenshots'));
$smarty->assign('header_img', 'screenshots');
$smarty->assign('session', session_name() . "=" . session_id());

// We need some time to do this
@set_time_limit(0);
@ignore_user_abort(1);

$path = substr(getcwd(),0,-5).'screenshots';

if ( isset($_GET['action']) && $_GET['action'] == 'upload' ) {
	$uploadDir = '..'.DIRECTORY_SEPARATOR.'screenshots';

	if ( (isset($_FILES['file'])) && ($_FILES['file']['name'] != '') ) {
		if ( !is_writeable($uploadDir) ) {
			$smarty->assign('Error', t('The directory screenshots is not writeable.'));
		} else {
			if ( $_FILES['file']['error'] == UPLOAD_ERR_OK ) {
				$infilename = basename($_FILES['file']['name']);
				$ext = substr($infilename, strrpos($infilename, '.') + 1);
				if ( ($ext == 'zip') ) {
					if ( @move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir.DIRECTORY_SEPARATOR.$infilename) ) {
						if ( uncompress_all($infilename, $uploadDir) ) {
							if ( !@unlink($uploadDir.DIRECTORY_SEPARATOR.$infilename) ) $smarty->assign('Error', t('Can\'t delete compressed file.'));
							$smarty->assign('Success', t('Added new screenshots.'));
						} else {
							$smarty->assign('Error', t('Unable to decompress file.'));
							@unlink($_FILES['file']['tmp_name']);
						}
					} else {
						$smarty->assign('Error', t('Something went wrong.'));
						@unlink($_FILES['file']['tmp_name']);
					}
				} else {
					$smarty->assign('Error', t('Wrong file type!'));
					@unlink($_FILES['file']['tmp_name']);
				}
			} else {
				$smarty->assign('Error', t('Upload failed!') . ' '. t('Error No:') . ' ' . $_FILES['file']['error']);
			}
		}
	} else {
		$smarty->assign('Error', t('You need to select a file first!'));
	}
}

if ( isset($_GET['action']) && $_GET['action'] == 'show' ) {
	$screenshots = getScreenshots(rawurldecode($_GET['id']),'../');

	$smarty->assign('id', rawurldecode($_GET['id']));
	$smarty->assign('screenshots', $screenshots);

	$smarty->assign('show', 1);
}

if ( isset($_GET['action']) && $_GET['action'] == 'relink' ) {
	if ( isset($_GET['id']) && ( isset($_POST['relink']) || isset($_POST['symlink']) ) ) {
		if ( substr($_POST['relink'],-1) == '.' || substr($_POST['symlink'],-1) == '.' ) {
			$smarty->assign('Error','Links must not end with a dot.');
		} else {
			if ( isset($_POST['relink']) && $_POST['relink'] != '' ) {
				$ren = rename($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.$_POST['relink']);
				$ren_t = rename($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$_POST['relink']);
				if ( $ren && $ren_t ) {
					$info = t('Screenshots successfully relinked.');
				} else {
					$error = t('Screenshots could not be relinked.');
				}
				$_GET['id'] = rawurlencode($_POST['relink']);
			}
			if ( isset($_POST['symlink']) && $_POST['symlink'] != '' ) {
				$sym = symlink($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.$_POST['symlink']);
				$sym_t = symlink($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$_POST['symlink']);
				if ( $sym && $sym_t ) {
					if ( !empty($info) ) {
						$info .= '<br />Symlink successfully build.';
					} else {
						$info = 'Symlink successfully build.';
					}
				} else {
					if ( !empty($error) ) {
						$error .= '<br />Symlink could not be build.';
					} else {
						$error = 'Symlink could not be build.';
					}
				}
			}
			if ( !empty($info) ) $smarty->assign('Info',$info);
			if ( !empty($error) ) $smarty->assign('Error',$error);
		}
	}
}


list ($ids, $link, $indb, $notindb, $symlink, $windows) = getScreenshotsAdm($path);
if ($symlink == 1) $smarty->assign('symlinks', 1);

if ( isset($_GET['action']) && ($_GET['action'] == 'buildtags') ) {
	genScreenshotTag($indb);
	
	// Delete cached templates
	delCachedTempPHP();
	
	$smarty->assign('Success', t('Tags table updated.'));
}

if ( isset($_GET['action']) && $_GET['action'] == 'delete' ) {
	if ( isset($_GET['id']) ) {

		// Symlink or directory
		if ( $windows ) {
			$islink = utf8_decode(rawurldecode($_GET['id'])) !== pathinfo(@readlink($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id']))),PATHINFO_BASENAME);
		} else {
			$islink = is_link($path.DIRECTORY_SEPARATOR.$_GET['id']);
		}

		// Delete symlink
		if ( $islink ) {
			if ( $windows ) {
				$del = rmdir($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				if ( is_dir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id']))) ) {
					$del_t = rmdir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				} else {
					$del_t = true; // No thumbs, so it's OK
				}
			} else {
				$del = unlink($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				if ( is_dir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id']))) ) {
					$del_t = unlink($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				} else {
					$del_t = true; // No thumbs, so it's OK
				}
			}
			if ( $del && $del_t ) {
				$smarty->assign('Info','Symlink successfully deleted.');
				if ( isset($indb[rawurldecode($_GET['id'])]) ) {
					unset($indb[rawurldecode($_GET['id'])]);
				} else {
					unset($notindb[rawurldecode($_GET['id'])]);
				}
			} else {
				$smarty->assign('Error','Symlink could not be deleted.');
			}
		}
		// Delete directory
		else {
			// Is there a symlink to this directory
			if ( in_array(rawurldecode($_GET['id']), $link) ) {
				// Delete symlink
				$symlink = array_search(rawurldecode($_GET['id']), $link);
				if ( $windows ) {
					$del = rmdir($path.DIRECTORY_SEPARATOR.$symlink);
					if ( is_dir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$symlink) ) {
						$del_t = rmdir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$symlink);
					} else {
						$del_t = true; // No thumbs, so it's OK
					}
				} else {
					$del = unlink($path.DIRECTORY_SEPARATOR.$symlink);
					if ( is_link($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$symlink) ) {
						$del_t = unlink($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$symlink);
					} else {
						$del_t = true; // No thumbs, so it's OK
					}
				}
				if ( $del && $del_t ) {
					// Rename directory to prior symlink
					$ren = rename($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.$symlink);
					if ( is_dir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id']))) ){
						$ren_t = rename($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])), $path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$symlink);
					} else {
						$ren_t = true; // No thumbs, so it's OK
					}
					if (  $ren && $ren_t ) {
						$smarty->assign('Info','Screenshots successfully moved to prior symlink.');
						if ( isset($indb[rawurldecode($_GET['id'])]) ) {
							unset($indb[rawurldecode($_GET['id'])]);
						} else {
							unset($notindb[rawurldecode($_GET['id'])]);
						}
						unset($link[$symlink]);
					} else {
						$smarty->assign('Error','Screenshots could not be moved to prior symlink.');
					}
				} else {
					$smarty->assign('Error','Symlink could not be deleted.');
				}
			}
			// Delete directory
			else {
				$del = rrmdir($path.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				if ( is_dir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id']))) ) {
					$del_t = rrmdir($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.utf8_decode(rawurldecode($_GET['id'])));
				} else {
					$del_t = true; // No thumbs, so it's OK
				}
				if ( $del && $del_t ) {
					$smarty->assign('Info','Screenshots successfully deleted.');
					if ( isset($indb[rawurldecode($_GET['id'])]) ) {
						unset($indb[rawurldecode($_GET['id'])]);
					} else {
						unset($notindb[rawurldecode($_GET['id'])]);
					}
				} else {
					$smarty->assign('Error','Screenshots could not be deleted.');
				}
			}
		}
	}
}

$smarty->assign('indb', $indb);
$smarty->assign('notindb', $notindb);
$smarty->assign('link', $link);

$smarty->display('admin/screenshots.tpl');
?>
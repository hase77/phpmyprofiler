<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
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

$pmp_module = 'admin_uploadxml';

require_once('../config.inc.php');
include_once('../admin/include/functions.php');
include_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Upload'));
$smarty->assign('header_img', 'upload');
$smarty->assign('session', session_name() . "=" . session_id() );

// We need some time to do this
@set_time_limit(0);
@ignore_user_abort(1);

chdir('../xml');
$uploadDir = '.';

if ( (isset($_FILES['file'])) && ($_FILES['file']['name'] != '') ) {
	if ( !is_writeable($uploadDir) ) {
		$smarty->assign('Error', t('The directory xml is not writeable.'));
	}
	else {
		if ( $_FILES['file']['error'] == UPLOAD_ERR_OK ) {
			$infilename = basename($_FILES['file']['name']);
			$ext = substr($infilename, strrpos($infilename, '.') + 1);
			if ( ($ext == 'zip') || ($ext == 'bz2') || ($ext == 'xml') ) {
				if ( @move_uploaded_file($_FILES['file']['tmp_name'], $infilename) ) {
					if ( ($ext == 'zip') || ($ext == 'bz2') ) {
						if ( uncompress_file($infilename) ) {
							if ( !@unlink($infilename) ) {
								$smarty->assign('Error', t('Can\'t delete compressed collection file'));
							}
							else {
								$smarty->assign('Success', t('Added new Collection.'));
							}
						}
						else {
							$smarty->assign('Error', t('Unable to decompress collection file.'));
							@unlink($_FILES['file']['tmp_name']);
						}
					}
					else {
						$smarty->assign('Success', t('Added new Collection.'));
					}
				}
				else {
					$smarty->assign('Error', t('Something went wrong.'));
					@unlink($_FILES['file']['tmp_name']);
				}
			}
			else {
				$smarty->assign('Error', t('Wrong file type!'));
				@unlink($_FILES['file']['tmp_name']);
			}
		}
		else {
			$smarty->assign('Error', t('Upload failed!') . ' '. t('Error No:') . ' ' . $_FILES['file']['error']);
		}
	}
}
else {
	$smarty->assign('Error', t('You need to select a file first!'));
}

$smarty->display('admin/uploadxml.tpl');
?>
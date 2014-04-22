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

$pmp_module = 'admin_guestbook';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../include/smallDVD.class.php');
require_once('../include/emoticons.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Guestbook'));
$smarty->assign('header_img', 'guestbook');
$smarty->assign('session', session_name() . "=" . session_id() );

dbconnect();

if ( !empty($_GET['id']) ) {
	switch ($_GET['action']) {
		case 'delete':
			$sql = 'DELETE FROM pmp_guestbook WHERE id = ' . mysql_real_escape_string($_GET['id']);
			$res = dbexec($sql);
			$smarty->assign('Success', t('Guestbook entry deleted.'));
			break;

		case 'activate':
			$sql = 'UPDATE pmp_guestbook SET status = 1 WHERE id = ' . mysql_real_escape_string($_GET['id']);
			$res = dbexec($sql);
			$smarty->assign('Success', t('Guestbook entry activated.'));
			break;

		case 'comment':
			$sql = 'UPDATE pmp_guestbook SET comment = \'' . mysql_real_escape_string($_POST['comment'])
			. '\' WHERE id = ' . mysql_real_escape_string($_GET['id']);
			$res = dbexec($sql);
			$smarty->assign('Success', t('Comment changed.'));
			break;
	}
}
else if ( (isset($_GET['action'])) && ($_GET['action'] == "allactivate") ) {
	$sql = 'UPDATE pmp_guestbook SET status = 1 WHERE status = 0';
	$res = dbexec($sql);
	$smarty->assign('Success', t('All Guestbook entries activated.'));
}

$sql = 'SELECT * FROM pmp_guestbook WHERE status = 0 ORDER BY id ASC';
$res = dbexec($sql);

$pending = array();

if ( mysql_num_rows($res) > 0 ) {
	while ( $row = mysql_fetch_object($res) ) {
		$row->date = strftime($pmp_dateformat, strtotime($row->date));
		$row->text = replace_emoticons(nl2br(htmlspecialchars($row->text, ENT_COMPAT, 'UTF-8')));
		$row->comment = htmlspecialchars($row->comment, ENT_COMPAT, 'UTF-8');
		$pending[] = $row;
	}
}
$smarty->assign('pending', $pending);

$sql = 'SELECT * FROM pmp_guestbook WHERE status = 1 ORDER BY id DESC';
$res = dbexec($sql);

$active = array();

if ( mysql_num_rows($res) > 0 ) {
	while ( $row = mysql_fetch_object($res) ) {
		$row->date = strftime($pmp_dateformat, strtotime($row->date));
		$row->text = replace_emoticons(nl2br(htmlspecialchars($row->text, ENT_COMPAT, 'UTF-8')));
		$row->comment = htmlspecialchars($row->comment, ENT_COMPAT, 'UTF-8');
		$active[] = $row;
	}
}
$smarty->assign('active', $active);

$smarty->display('admin/guestbook.tpl');
?>
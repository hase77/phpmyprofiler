<?php
/* phpMyProfiler
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

define('_PMP_REL_PATH', '..');

$pmp_module = 'admin_login';

require_once('../config.inc.php');
require_once('../passwd.inc.php');
include_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../include/formkey.class.php');

// Send utf-8 header
header('Content-type: text/html; charset=utf-8');

$formKey = new formKey();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('nologout', true);
$smarty->assign('Focus', 'user');
$smarty->assign('session', session_name() . '=' . session_id());
$smarty->assign('formkey', $formKey->outputKey());

// Logout
if (isset($_POST['logout'])) {
	unset($_SESSION['isadmin']);
	session_destroy();
	$_SESSION['lastside'] = 'index.php';
}

// Check Login (User / Password)
if (isset($_GET['error']) && $_GET['error'] == 'formkey') {
	//Form key is invalid, show an error
	$smarty->assign('Error', 'Form key error!');
}
else if (isset($_GET['error']) && $_GET['error'] == 'user') {
	$smarty->assign('Error', t('You must enter a username.'));
}
else if (isset($_GET['error']) && $_GET['error'] == 'pass') {
	$smarty->assign('Error', t('You must enter a password.'));
	$smarty->assign('Username', $_GET['user']);
	$smarty->assign('Focus', 'passwd');
}
else if (isset($_GET['error']) && $_GET['error'] == 'usrpsw') {
	$smarty->assign('Error', t('The username or the password is wrong.'));
}

if (!empty($pmp_admin) && !empty($pmp_passwd)) {
	if (empty($_SESSION['isadmin'])) {
		$smarty->display('admin/login.tpl');
	}
}
else {
	saveLastIP();
	session_regenerate_id(true);
	$smarty->assign('session', session_name() . '=' . session_id() );

	// Without a Passwort everybody can administrate phpMyProfiler!
	$_SESSION['isadmin'] = true;
	header("Location:" . $_SESSION['lastside']);
}
?>
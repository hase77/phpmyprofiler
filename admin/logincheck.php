<?php
/* phpMyProfiler
 * Copyright (C) 2006-2015 The phpMyProfiler project
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
require_once('../admin/include/functions.php');
require_once('../admin/include/password.php');
require_once('../include/pmp_Smarty.class.php');
require_once('../include/formkey.class.php');

$formKey = new formKey();

// Check Login (User / Password)
if (isset($_POST['login'])) {
	$session = session_name() . '=' . session_id();

	if(!isset($_POST['form_key']) || !$formKey->validate()) {
		//Form key is invalid, show an error
		header("Location:login.php?error=formkey&" . $session);
	}
	else if (empty($_POST['user'])) {
		header("Location:login.php?error=user&" . $session);
	}
	else if (empty($_POST['passwd'])) {
		header("Location:login.php?error=pass&user=" . $_POST['user'] . '&' . $session);
	}
	else if (($_POST['user'] != $pmp_admin) || !password_verify($_POST['passwd'], $pmp_passwd)) {
		header("Location:login.php?error=usrpsw&" . $session);
	}
	else {
		saveLastIP();
		session_regenerate_id(true);
		$session = session_name() . '=' . session_id();

		$_SESSION['isadmin'] = true;
		header("Location:" . $_SESSION['lastside'] .  '?' . $session);
	}
}
?>
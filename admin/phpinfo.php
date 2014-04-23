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

$pmp_module = 'admin_phpinfo';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('PHP-Info'));
$smarty->assign('header_img', 'phpinfo');
$smarty->assign('session', session_name() . "=" . session_id() );

ob_start();
phpinfo(INFO_GENERAL | INFO_CONFIGURATION | INFO_MODULES | INFO_ENVIRONMENT | INFO_VARIABLES);
$output = ob_get_contents();
ob_end_clean();

preg_match_all('#<body[^>]*>(.*)</body>#siU', $output, $phpinfo);
$phpinfo = preg_replace('#<table#', '<table class="phpinfo" align="center"', $phpinfo[1][0]);
$phpinfo = preg_replace('#border="0" cellpadding="3" width="600"#', 'border="0" cellspacing="0" cellpadding="4" width="100%"', $phpinfo);
$phpinfo = preg_replace('#td class="e"#', 'td class="phpinfo_e" width="200"', $phpinfo);
$phpinfo = preg_replace('#td class="v"#', 'td class="phpinfo_v"', $phpinfo);

// No Lines
$phpinfo = preg_replace('#<hr />#', '', $phpinfo);

// Header
$phpinfo = preg_replace('#<th#', '<th class="phpinfo_th"', $phpinfo);
$phpinfo = preg_replace('#<h1 class="p">#', '<h1>', $phpinfo);
$phpinfo = preg_replace('#<h1#', '<h1 class="phpinfo_h1"', $phpinfo);
$phpinfo = preg_replace('#<h2#', '<h2 class="phpinfo_h2"', $phpinfo);

// Optic
$phpinfo = preg_replace('#<td>\n<a href="http://www.php.net/">#', '<td align="center" style="text-align: center"><a href="http://www.php.net/">', $phpinfo);
$phpinfo = preg_replace('#<td>\n<a href="http://www.zend.com/">#', '<td align="center" style="text-align: center; background-color: #cccccc"><a href="http://www.zend.com/">', $phpinfo);
$phpinfo = preg_replace('#alt="Zend logo" /></a>#', 'alt="Zend logo" /></a><br />', $phpinfo);

$phpinfo = preg_replace('#,#', ', ', $phpinfo);

// W3C: Value of Attribute "name" must be a single token
$phpinfo = preg_replace('#<a name="module_Zend Optimizer">#', '<a name="module_Zend_Optimizer">', $phpinfo);

$smarty->assign('phpinfo', $phpinfo);
$smarty->display('admin/phpinfo.tpl');
?>
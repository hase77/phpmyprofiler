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

$pmp_module = 'admin_updaterates';

require_once('../config.inc.php');
require_once('../admin/include/functions.php');
require_once('../include/pmp_Smarty.class.php');

isadmin();

$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->compile_dir = '../templates_c';

$smarty->assign('header', t('Exchange Rates'));
$smarty->assign('header_img', 'updaterates');
$smarty->assign('session', session_name() . "=" . session_id() );

dbconnect();

// Update rates from ECB
function updateRates() {
	$xmlrates = getRemoteContent('http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml');

	if ( $xmlrates != '' ) {
		preg_match("/<Cube time='(.*)'>/i", $xmlrates,  $date);
		preg_match_all("/<Cube currency='(.*)' rate='(.*)'/i", $xmlrates,  $tmp);
		$rates = array_combine($tmp[1], $tmp[2]);

		foreach ( $rates as $curr=>$rate ) {
			dbexec('INSERT INTO pmp_rates (id, rate, date) VALUES (\'' . mysql_real_escape_string($curr) . '\', ' . mysql_real_escape_string($rate) . ', \'' . mysql_real_escape_string($date[1]) . '\')');
		}

		return true;
	}
	else {
		return false;
	}
}

if ( (isset($_GET['action'])) && ($_GET['action'] == 'update') ) {
	dbexec('DELETE FROM pmp_rates');

	if ( updateRates() ) {
		$smarty->assign('Success', t('Rates updated.'));
	}
	else {
		$smarty->assign('Error', t('Rates not updated.'));
	}
}

$res = dbexec('SELECT * FROM pmp_rates');

$rates = array();

if ( mysql_num_rows($res) > 0 ) {
	while ( $row = mysql_fetch_object($res) ) {
		$rates[] = $row;
	}
}
$smarty->assign('rates', $rates);

dbclose();

$smarty->display('admin/updaterates.tpl');
?>
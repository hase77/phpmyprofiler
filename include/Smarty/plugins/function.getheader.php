<?php
/* phpMyProfiler
 * Copyright (C) 2005-2012 The phpMyProfiler project
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

function smarty_function_getheader($params, $smarty) {
	global $_SERVER, $_SESSION;

	if ( empty($params['column']) ) {
		$smarty->trigger_error("assign: missing 'column' parameter");
		return;
	}

	if ( strtolower($params['column']) == strtolower($_SESSION['list_orderby']) ) {
		if ( $_SESSION['list_orderdir'] == 'asc' ) {
			$orderdir = 'desc';
		}
		else {
			$orderdir = 'asc';
		}
	}
	else {
		$orderdir = 'asc';
	}

	return '<a href="?orderby=' . $params['column'] . '&amp;orderdir=' . $orderdir . '">' . (empty($params['caption'])?t($params['spalte']):t($params['caption'])) . '</a>' ;
}
?>

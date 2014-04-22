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

function smarty_modifier_flag($state) {
	$flag = getFlagName($state);

	if ( empty($flag) ) {
		return '<img src="' . _PMP_REL_PATH . '/themes/default/images/flags/Noflag.gif" alt="' . t($state) . '" title="'. t($state) . '" style="width: 23px; height: 15px;" />';
	}
	else {
		return '<img src="' . _PMP_REL_PATH . '/themes/default/images/flags/' . $flag . '" alt="' . t($state) . '" title="'. t($state) . '" style="width: 23px; height: 15px;" />';
	}
}
?>

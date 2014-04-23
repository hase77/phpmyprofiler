<?php
/* phpMyProfiler
 * Copyright (C) 2008-2012 The phpMyProfiler project
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

function smarty_modifier_casetype($casetype) {
	global $pmp_theme;

	$pics['Keep Case'] = 'additional/keepcase.gif';
	$pics['Jewel'] = 'additional/superjewelcase.gif';
	$pics['Slip Case'] = 'additional/slipcase.gif';
	$pics['Snapper'] = 'additional/snappercase.gif';
	$pics['SteelBook'] = 'additional/steelbook.gif';
	$pics['Digipak'] = 'additional/digipak.gif';
	$pics['Clamshell'] = 'additional/clamshell.gif';
	$pics['Drawer'] = 'additional/drawercase.gif';
	$pics['Custom'] = 'additional/custom.gif';
	#$pics['Box'] = 'additional/box.gif';
	#$pics['Digibook'] = 'additional/digibook.gif';

	if ( isset($pics[$casetype]) && is_string($pics[$casetype]) ) {
	return '<img src="' . _PMP_REL_PATH . '/themes/' . $pmp_theme . '/images/' .$pics[$casetype] . '" alt="'. $casetype . '" title="'. $casetype . '" style="vertical-align: middle;" />';
	}
}
?>

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

// filter:				Field in the database
// value:				Value after which should filtered, ?? is replaced with value
// caption:				Caption of link
// caption_active:			Caption of link if filter is active
// caption_inactive:			Caption of link if filter is inactive
// show_active:				Show nothing if filter is active and showactive is set to 'False'
// show_inactive:			Show nothing if filter is inactive and showadective is set to 'False'
// class:				Classname for class="(in)active_$class"
// switch				Set links as switch
// combobox				Return filter as option, not link

function smarty_function_getfilter($params, $smarty) {
	global $_SERVER, $_SESSION;

	if ( empty($params['filter']) ) {
		$smarty->trigger_error("assign: missing 'filter' parameter");
		return;
	}

	if ( strpos($params['value'], '[dot]') ) {
		$params['caption'] = str_replace('??', substr($params['value'], strpos($params['value'], '[dot]')+5), $params['caption']);
	}
	else {
		$params['caption'] = str_replace('??', $params['value'], $params['caption']);
	}

	$found = false;


	if ( count($_SESSION['list_where']) > 0 ) {
		foreach ( $_SESSION['list_where'] as $key => $val ) {

			if ( $val['field'] == $params['filter'] ) {

				if ( $val['value'] == $params['value'] ) {
					$found = true;
					break;
				}
			}
		}
	}

	$class = empty($params['class'])?'filter':$params['class'];

	if ( $found ) {
		// Active filter
		if ( !isset($params['show_active']) || $params['show_active'] != 'False' ) {
			if ( isset($params['switch']) && $params['switch'] == 'True' ) {
				return '<span class="active_'. $class .'">' . (empty($params['caption_active'])?t($params['caption']):t($params['caption_active'])) . '</span>' ;
			}
			else {
				return '<a class="active_'. $class .'" href="' . $_SERVER['SCRIPT_NAME'] . '?delwhere=' . rawurlencode($params['filter']) . '&amp;whereval=' . rawurlencode($params['value']) . '">' . (empty($params['caption_active'])?t($params['caption']):t($params['caption_active'])) . '</a>' ;
			}
		}
	}
	else {
		// Inactive filter
		if ( isset($params['combobox']) && $params['combobox'] == 'True' ) {
			if (isset( $params['show_inactive']) && $params['show_inactive'] != 'False' ) {
				return '<option value="' . $params['value'] . '">' . (empty($params['caption_inactive'])?t($params['caption']):t($params['caption_inactive'])) . '</option>';
			}
		}
		else {
			if ( isset( $params['show_inactive']) && $params['show_inactive'] != 'False' ) {
				if ( $params['switch'] == 'True' ) {
					return '<a class="inactive_'. $class .'" href="' . $_SERVER['SCRIPT_NAME'] . '?addwhere=' . rawurlencode($params['filter']).  '&amp;delwhere=' . rawurlencode($params['filter']) . '&amp;whereval=' . rawurlencode($params['value']) . '">' . (empty($params['caption_inactive'])?t($params['caption']):t($params['caption_inactive'])) . '</a>' ;
				}
				else {
					return '<a class="inactive_'. $class .'" href="' . $_SERVER['SCRIPT_NAME'] . '?addwhere=' . rawurlencode($params['filter']) . '&amp;whereval=' . rawurlencode($params['value']) . '">' . (empty($params['caption_inactive'])?t($params['caption']):t($params['caption_inactive'])) . '</a>' ;
				}
			}
		}
	}
}
?>

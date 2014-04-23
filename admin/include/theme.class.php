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

class theme {
	public $id;
	public $name;
	public $wrongversion;

	public function theme($name) {
		$this->id = $name;
		$this->_load();
	}

	public function _load() {
		global $_SESSION, $pmp_version;

		$lg = $_SESSION['lang_id'];

		$data = @file_get_contents(_PMP_REL_PATH . '/themes/' . $this->id . '/description.xml');

		if ( $data !== false ) {
			// Get name of theme
			$find = '/<name lang="' . $lg . '">(.*)\<\/name>/';
			if ( preg_match($find, $data, $tmp) == 0 ) {
				$find = '/<name\>(.*)<\/name>/';
				preg_match($find, $data, $tmp);
			}
			$this->name = $tmp[1];

			// Get the supported pmp versions
			$find = '/<pmp_version>(.*)\<\/pmp_version>/';
			if ( preg_match_all($find, $data, $tmp) != 0 ) {
				foreach ( $tmp[1] as $version ) {
					if ( $version == $pmp_version ) {
						$this->wrongversion = false;
						break;
					}
				}
			}
			else {
				$this->wrongversion = true;
			}
		}
		// There is no description file
		else {
			$this->id = false;
		}
	}
}
?>
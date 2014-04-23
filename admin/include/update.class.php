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

class update {
	public $id;
	public $ExecSQL;
	public $Author;
	public $Date;
	public $Description;

	public function update($file) {
		$tmpcontent = file($file);
		$content = implode(' ', array_map('trim', $tmpcontent));

		preg_match('/<id>(.*?)<\/id>/i', $content, $tmp);
		$this->id = $tmp[1];

		preg_match_all('/<ExecSQL>(.*?)<\/ExecSQL>/i', $content, $tmp);
		$this->ExecSQL = $tmp[1];

		preg_match('/<Author>(.*?)<\/Author>/i', $content, $tmp);
		$this->Author = $tmp[1];

		preg_match('/<Date>(.*?)<\/Date>/i', $content, $tmp);
		$this->Date = $tmp[1];

		preg_match('/<Description>(.*?)<\/Description>/i', $content, $tmp);
		$this->Description = $tmp[1];
	}

	public function doit() {
		foreach ( $this->ExecSQL as $sql ) {
			$res = dbexec(trim($sql), true);

			if ( !$res ) {
				break;
			}
		}

		if ( $res ) {
			$sql = 'INSERT INTO pmp_update (id, date) VALUES (' . mysql_real_escape_string($this->id) . ', now())';
			$res = dbexec($sql, true);

			if ( $res ) {
				$this->lasterror = true;
				return $this->Description;
			}
			else {
				$this->lasterror = mysql_error() . '<br /><br />Query:<br />' . replace_table_prefix($sql);
				return false;
			}
		}
		else {
			$this->lasterror = mysql_error() . '<br /><br />Query:<br />' . $sql;
			return false;
		}
	}
}
?>
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

define('OPTION_PASSWORD', 3);

class option {
	public $Var;
	public $Child;  // 1 = Text, 2 = Selection, 3 = Password
	public $Name;
	public $Description;
	public $Value;
	public $Optionlist;

	public function option($Var, $Name, $Description, $Value, $Optionlist = '') {
		$this->Var = $Var;
		$this->Name = $Name;
		$this->Description = $Description;

		$var = filter_input(INPUT_POST, $this->Var, FILTER_SANITIZE_STRING);

		if (!empty($var)) {
			$this->Value = $var;
		}
		else {
			$this->Value = $Value;
		}

		if (is_array($Optionlist)) {
			$this->Child = 2;
			$this->Optionlist = $Optionlist;
		}
		else if ($Optionlist == OPTION_PASSWORD) {
			$this->Child = 3;
		}
		else {
			$this->Child = 1;
			unset($this->Optionlist);
		}
	}

	public function getSkript() {
		$res  = "// " . html_entity_decode(t($this->Name), ENT_COMPAT, 'UTF-8') . "\n";
		$res .= "// \n";

		if ($this->Description !== '') {
			$res .= "// " . html_entity_decode(t($this->Description), ENT_COMPAT, 'UTF-8') . "\n";
			$res .= "// \n";
		}

		if ($this->Child == 2) {
			$res .= "// " . html_entity_decode(t('Possible values:'), ENT_COMPAT, 'UTF-8') . "\n";
			foreach ($this->Optionlist as $key => $value) {
				$res .= "//    $key => " . html_entity_decode(t($value), ENT_COMPAT, 'UTF-8') . "\n";
			}
			$res .= "// \n";
		}

		if (is_numeric($this->Value)) {
			$res .= '$' . $this->Var . ' = ' . $this->Value . ';' . "\n";
		}
		else {
			$res .= '$' . $this->Var . ' = \'' . addslashes($this->Value) . '\';' . "\n";
		}

		$res .= "\n";

		return $res;
	}
}
?>
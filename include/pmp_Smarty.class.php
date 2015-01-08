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

require_once(_PMP_REL_PATH.'/include/Smarty/Smarty.class.php');

class pmp_Smarty extends Smarty {

	public function __construct(){
		// selfpointer needed by some other class methods
		$this->smarty = $this;
		if (is_callable('mb_internal_encoding')) {
			mb_internal_encoding(SMARTY_RESOURCE_CHAR_SET);
		}
		$this->start_time = microtime(true);
		// set default dirs
		$this->setTemplateDir('.'.DS.'templates'.DS);
		$this->setCompileDir('.'. DS.'templates_c'.DS);
		$this->setPluginsDir(SMARTY_PLUGINS_DIR);
		$this->setCacheDir('.'.DS.'cache'.DS);
		$this->setConfigDir('.'.DS.'configs'.DS);

		$this->debug_tpl = 'file:'.dirname(__FILE__).'/debug.tpl';
		if (isset($_SERVER['SCRIPT_NAME'])) {
			$this->assignGlobal('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);
		}
	}

	public function setTemplateDir($template) {
		global $pmp_theme;

		if (file_exists(_PMP_REL_PATH.'/themes/'.$pmp_theme.'/templates/'.$template)) {
			$template_dir = _PMP_REL_PATH.'/themes/'.$pmp_theme.'/templates';
		}
		else {
			$template_dir = _PMP_REL_PATH.'/themes/default/templates';
		}
		parent::setTemplateDir($template_dir);
	}

	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
		global $_SESSION, $pmp_theme;

		$this->setTemplateDir($template);

		foreach ($GLOBALS as $key => $val) {
			if (substr($key, 0, 4) == 'pmp_') {
				$this->assign($key, $val);
			}
		}

		parent::display( $template, $cache_id, $pmp_theme.'_'.$_SESSION['lang_id'], $parent);
	}

	public function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null) {
		global $_SESSION, $pmp_theme;

		$this->setTemplateDir($template);

		return parent::isCached($template, $cache_id, $pmp_theme.'_'.$_SESSION['lang_id'], $parent);
	}
}
?>
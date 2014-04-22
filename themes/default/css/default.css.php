<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
 * Copyright (C) 2005-2009 The phpMyProfiler project
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

require_once('../../../config.inc.php');

header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);

ob_start("compress");

function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

include($pmp_theme_css);

ob_end_flush();
?>

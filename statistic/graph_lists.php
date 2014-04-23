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

$pmp_module = 'statistic';

if ( !isset($_SERVER['HTTP_REFERER']) || stristr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) === false ) {
	echo "Not allowed! Possible hacking attempt detected!";
	exit();
}

require_once('../config.inc.php');
require_once('../include/functions.php');
DEFINE("TTF_DIR", '../include/font/');
DEFINE("CACHE_DIR", "../cache/");
DEFINE("USE_CACHE", $pmp_thumbnail_cache);
require_once('../include/jpgraph/jpgraph.php');
require_once('../include/jpgraph/jpgraph_pie.php');
require_once('../include/jpgraph/jpgraph_pie3d.php');
require_once('../custom_media.inc.php');

if ( $pmp_thumbnail_cache && is_file('../cache/graph_lists_'.$_SESSION['lang_id'].'.png') ) {
	$filename = '../cache/graph_lists_'.$_SESSION['lang_id'].'.png';
	header('Content-Type: image/png');
	header("Cache-Control: must-revalidate");
	header($ExpStr);
	header('Content-Disposition: inline; filename=' . $filename . ';');
	@readfile($filename);
}
else {
	dbconnect();
	$pmp_collections = get_collections();

	$query = "SELECT type AS collectiontype, data AS count FROM pmp_statistics WHERE (";
	foreach ( $pmp_collections as $collection ) {
		$query .= "type = '" . $collection . "' OR ";
	}
	$query = substr($query,0,-4).") AND data > 0 ORDER BY collectiontype";
	$result = dbexec($query);

	if ( mysql_num_rows($result) == 0 ) {
		header('Content-Type: image/gif');
		header("Cache-Control: must-revalidate");
		header($ExpStr);
		header('Content-Disposition: inline; filename=empty.gif; ');
		@readfile('../themes/default/images/empty.gif');
	}
	else {
		$types = 0;
		while ( $row = mysql_fetch_object($result) ) {
			$List[] = $row->count;
			$Legend[] = entity_to_decimal_value(t($row->collectiontype));
			$types++;
		}

		if ( $pmp_stat_use_ttf == true ) {
			$fontbig = FF_ARIAL;
			$fontmedium = FF_ARIAL;
			$fontsmall = FF_ARIAL;
		}
		else {
			$fontbig = FF_FONT2;
			$fontmedium = FF_FONT1;
			$fontsmall = FF_FONT0;
		}

		// Setup the graph
		$graph = new PieGraph(500, 210, 'graph_lists_'.$_SESSION['lang_id'].'.png');
		$theme_class = new pmpTheme;
		$graph->SetTheme($theme_class);

		$p1 = new PiePlot3D($List);
		for ( $i = 0; $i <= $types; $i++ ) {
			$p1->ExplodeSlice($i);
		}
		$p1->SetCenter(0.30);
		$p1->SetLegends($Legend);

		$p1->value->SetFont($fontmedium, FS_NORMAL, 10);
		$p1->value->SetColor('#000000');
		$p1->value->SetFormat("%d");
		$p1->SetValueType(PIE_VALUE_ABS);
		$graph->legend->SetFont($fontmedium, FS_NORMAL, 10);
		$graph->legend->Pos(0.1, 0.1, "right", "top");
		$graph->legend->SetColumns(1);

		$graph->Add($p1);

		// Finally send the graph to the browser and our own header
		header('Content-Type: image/png');
		header("Cache-Control: must-revalidate");
		header($ExpStr);
		$graph->img->SetExpired(false);
		$graph->Stroke();
	}

	dbclose();
}
?>
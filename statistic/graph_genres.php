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
DEFINE("CACHE_DIR", '../cache/');
DEFINE("USE_CACHE", $pmp_thumbnail_cache);
require_once('../include/jpgraph/jpgraph.php');
require_once('../include/jpgraph/jpgraph_bar.php');

if ( $pmp_thumbnail_cache && is_file('../cache/graph_genres_'.$_SESSION['lang_id'].'.png') ) {
    $filename = '../cache/graph_genres_'.$_SESSION['lang_id'].'.png';
    header('Content-Type: image/png');
    header("Cache-Control: must-revalidate");
    header($ExpStr);
    header('Content-Disposition: inline; filename=' . $filename . ';');
    @readfile($filename);
}
else {
    dbconnect();

    $query = 'SELECT name AS genre, data AS count FROM pmp_statistics WHERE type = \'genres_top10\' ORDER BY LPAD(data, 20, \'0\') DESC';
    $result = dbexec($query);

    if ( mysql_num_rows($result) == 0 ) {
	header('Content-Type: image/gif');
	header("Cache-Control: must-revalidate");
	header($ExpStr);
	header('Content-Disposition: inline; filename=empty.gif; ');
	@readfile('../themes/default/images/empty.gif');
    }
    else {
	while ( $row = mysql_fetch_object($result) ) {
	    $Genre[] = $row->count;
	    $Legend[] = trunc($row->genre, 30);
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
	$graph = new Graph(550, 160, 'graph_genres_'.$_SESSION['lang_id'].'.png');
	$graph->SetScale('textlin');
	$theme_class = new pmpTheme;
	$graph->SetTheme($theme_class);
	$graph->Set90AndMargin(150, 20, 20, 20);

	// Setup color for axis and labels
	$graph->xaxis->SetColor('black', 'black');
	$graph->yaxis->SetColor('black', 'black');

	// Setup font for axis
	$graph->xaxis->SetFont($fontsmall, FS_NORMAL, 8);
	$graph->yaxis->SetFont($fontmedium, FS_NORMAL, 10);

	// Setup X-axis title (color & font)
	$graph->xaxis->title->SetColor('black');
	$graph->xaxis->title->SetFont($fontmedium, FS_NORMAL, 10);

	// Setup the grid
	$graph->xgrid->SetColor('#2a2a2a');
	$graph->xgrid->SetLineStyle('dashed');

	// Create the bar pot
	$bplot = new BarPlot($Genre);
	$bplot->SetWidth(.5);

	// Setup X-axis labels
	$graph->xaxis->SetTickLabels($Legend);

	// Setup color for gradient fill style
	$tcol = array(255, 204, 00);
	$fcol = array(255, 100, 100);
	$bplot->SetFillGradient($fcol, $tcol, GRAD_HOR);
	$graph->Add($bplot);

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
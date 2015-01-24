<?php
/* phpMyProfiler
 * Copyright (C) 2004 by Tim Reckmann [www.reckmann.org] & Powerplant [www.powerplant.de]
 * Copyright (C) 2005-2014 The phpMyProfiler project
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

// Instructions for use:
//
// ?reset=1
//		Reset all filters and sort
// ?list_page=foo
//		Show page
//
// Sort:
// =====
//
// ?orderby=foo&orderdir=[asc|desc]
//		Sort with with direction orderdir. If no orderdir is set, desc is used as default.
//
// Filter:
// ======
//
// ?delwhere=foo
//		Delete all filters for database field foo.
// ?delwhere=foo&whereval=bar
//		Delete filter bar for database field foo.
// ?addwhere=foo&whereval=bar
//		Add filter for database field foo with value bar.
// ?addwhere=foo&delwhere=foo&whereval=bar
//		Add filter for database field forr with value bar and delete all existing filter for database field foo.
//
// More options for addwhere:
//		?caption=qux
//			Add the caption qux to the filter.
//		?trim=True
//			Remove all unnecessary characters ("whitespace") from the end and beginning of whereval.
//		?addwildcardafter=True
//			Add wildcard ("%") at the end of whereval.
//		?addwildcardbefore=True
//			Add wildcard ("%") at the beginning of whereval.
//		?addwildcardboth=True
//			Add wildcard ("%") at the end and the beginning of whereval.
//
// Notes:
//
//	If an addwhere or orderby contains a "[tab]", it will be replaced with the corresponding
//  tablename, e.g. "pmp_film.".
//
//	If a parameter contains a "[dot]", it will be replaced with a  ".".
//
//	Table-Joins:
//
//	?addwhere=foreigntable.ref_field&whereval=foreignfield.valueforeinfield
//		became to:
//		inner join foreigntable t1 on pmp_film.id = t1.ref_field and t1.foreignfield = 'valueforeignfield'
//
//		foreigntable: 		Table which should be joined
//		ref_field:			Field in the foreigntable that pointed topmp_film.id
//		foreignfield:		Field after which the foreigntable should be filtered, e.g. Genre.
//		valueforeignfield:	Value after which the foreignfield should be filtered, e.g. Comedy.

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$pmp_module = 'menue';

dbconnect();

// ToDo: Allow more than one filter at one time

// Generate sql select for dvd list
function generateSql($count = false) {
	global $_SESSION;
	global $pmp_dvd_menue, $pmp_exclude_tag, $sortcount;
	global $pmp_mysql_ver;
	$j = 0;

	$join[] = 'LEFT JOIN pmp_boxset ON pmp_film.id = pmp_boxset.childid LEFT JOIN pmp_collection ON pmp_film.collectiontype = pmp_collection.collection';

	if ( isset($_SESSION['letter']) ) {
		if ( $_SESSION['letter'] == '#' ) {
			$where[] = "pmp_film.sorttitle NOT RLIKE '^[A-Z,a-z]'";
		}
		else {
			$where[] = "pmp_film.sorttitle RLIKE '^" . $_SESSION['letter'] . "'";
		}
	}

	if ( isset($_SESSION['list_where']) ) {
		foreach ( $_SESSION['list_where'] as $feld => $val ) {
			// Special handling for media types
			if ( $val['field'] == 'media') {
				if ( $val['value'] == 'DVD') {
					$where[] = "pmp_film.media_dvd = '1'";
				}
				else if ( $val['value'] == 'HD DVD') {
					$where[] = "pmp_film.media_hddvd = '1'";
				}
				else if ( $val['value'] == 'Blu-ray') {
					$where[] = "pmp_film.media_bluray = '1'";
				}
				else if ( $val['value'] != '' ) {
					$where[] = "pmp_film.media_custom = '" . mysql_real_escape_string($val['value']) . "'";
				}
			}
			else if ( $val['field'] == 'title') {
				$where[] = "title like '" . mysql_real_escape_string($val['value']) . "'";
			}
			else if ( strpos($val['field'], '[dot]') ) {
				$j++;
				$tmp1 = explode('[dot]', $val['field']);
				$tmp2 = explode('[dot]', $val['value']);
				$join[] = 'INNER JOIN ' . $tmp1[0] . " t$j ON pmp_film.id = t$j." . $tmp1[1];
				$where[] = "t$j." .$tmp2[0] ." = '" . mysql_real_escape_string($tmp2[1]) . "'";
			}
			else {
				if ( strpos($val['field'], '[tab]') === false ) {
					$val['field'] = 'pmp_film.' . $val['field'];
				}
				else {
					$val['field'] = str_replace('[tab]', 'pmp_film.', $val['field']);
				}

				if ( (strpos($val['value'], '_') !== false) || (strpos($val['value'], '%') !== false) ) {
					$where[] = $val['field'] . " like '" . mysql_real_escape_string($val['value']) . "'";
				}
				else {
					if ($val['value'] == 'Owned') {
						$where[] = "pmp_collection.partofowned = '1'";
					}
					else {
						$where[] = $val['field'] . " = '" . mysql_real_escape_string($val['value']) . "'";
					}
				}
			}
		}
	}

	// Add exclude filter if exists
	if ( $pmp_exclude_tag != '' ) {
		$where[] = "pmp_film.id NOT IN (SELECT id FROM pmp_tags where name = '" . mysql_real_escape_string($pmp_exclude_tag) . "')";
	}

	// If any search defined get all id's, childs and parents, no box-set handling
	$sortcount = count($_SESSION['list_where']);
	if ( $sortcount == 1 ) {
		$where[] = 'pmp_boxset.childid IS NULL';
	}

	$zwisql  = implode(" \n", $join) . " \n";
	$zwisql .= 'WHERE ' . implode(" AND \n", $where) . " \n";

	if ( !$count ) {
		$sql = 'SELECT DISTINCT pmp_film.id FROM pmp_film ' . $zwisql;
	}
	else {
		$sql = 'SELECT COUNT(distinct pmp_film.id ) AS c FROM pmp_film ' . $zwisql;
	}

	if ( isset($_SESSION['list_orderby']) ) {
		if ( strpos($_SESSION['list_orderby'], '[tab]') === false ) {
			$sql .= 'ORDER BY pmp_film.' . $_SESSION['list_orderby'] . ' ' . $_SESSION['list_orderdir'] . ' ';
		}
		else {
			$sql .= 'ORDER BY ' . str_replace('[tab]', 'pmp_film.', $_SESSION['list_orderby']) . ' ' . $_SESSION['list_orderdir'] . ' ';
		}
	}

	if ( !$count ) {
		$sql .= 'LIMIT ' . ((int)$_SESSION['list_page']-1) * $pmp_dvd_menue . ', ' . $pmp_dvd_menue . ' ';
	}

	$sql = str_replace('[dot]', '.', $sql);

	return $sql;
}

// Set default filters
function setDefaultFilter() {
	global $_SESSION, $pmp_menue_sortby, $pmp_menue_sortdir;

	if ( !isset($_SESSION['list_where']) ) {
		$_SESSION['list_where'][] = array('field' => 'collectiontype', 'value' => 'Owned');
	}

	if ( !isset($_SESSION['list_orderby']) ) {
		$_SESSION['list_orderby'] = getColumns($pmp_menue_sortby, 'Sort');
		$_SESSION['list_orderdir'] = $pmp_menue_sortdir;
	}

	if ( !isset($_SESSION['list_page']) ) {
		$_SESSION['list_page'] = 1;
	}
}

// Reset filters if wanted
if ( isset($_GET['reset']) ) {
	unset($_SESSION['list_where']);
	$_SESSION['list_where'][] = array('field' => 'collectiontype', 'value' => 'Owned');
	unset($_SESSION['list_sort']);
	unset($_SESSION['list_page']);
	unset($_SESSION['list_orderby']);
	unset($_SESSION['list_orderdir']);
	unset($_SESSION['letter']);
}

// Stripslashes from values
if ( isset($_GET['addwhere']) ) {
	$_GET['addwhere'] = stripslashes($_GET['addwhere']);
}
if ( isset($_GET['delwhere']) ) {
	$_GET['delwhere'] = stripslashes($_GET['delwhere']);
}
if ( isset($_GET['orderby']) ) {
	$_GET['orderby'] = stripslashes($_GET['orderby']);
}

// Which sort direction?
if ( !empty($_GET['orderby']) ) {
	$_SESSION['list_orderby'] = strtolower($_GET['orderby']);

	if ( $_GET['orderdir'] == 'asc' ) {
		$_SESSION['list_orderdir'] = 'asc';
	}
	else {
		$_SESSION['list_orderdir'] = 'desc';
	}
}

// Delete filter
if ( isset($_GET['delwhere']) ) {
	if ( isset($_SESSION['list_where']) ) {
		foreach ( $_SESSION['list_where'] as $key => $val ) {
			if ( $val['field'] == $_GET['delwhere'] ) {
				if ( isset($_GET['whereval']) ) {
					if ( ($val['value'] == $_GET['whereval']) || (!empty($_GET['delwhere']) && (!empty($_GET['addwhere']))) ) {
						unset($_SESSION['list_where'][$key]);
					}
				}
				else {
					unset($_SESSION['list_where'][$key]);
				}

			}
		}
	}
}

// Wildcards for values?
if ( !empty($_GET['trim']) ) {
	if ( $_GET['trim'] == 'True' ) {
		$_GET['whereval'] = trim($_GET['whereval']);
	}
}
if ( !empty($_GET['addwildcardafter']) ) {
	if ( $_GET['addwildcardafter'] == 'True' ) {
		$_GET['whereval'] = $_GET['whereval'] . '%';
	}
}
if ( !empty($_GET['addwildcardbefore']) ) {
	if ( $_GET['addwildcardbefore'] == 'True' ) {
		$_GET['whereval'] = '%' . $_GET['whereval'];
	}
}
if ( !empty($_GET['addwildcardboth']) ) {
	if ( $_GET['addwildcardboth'] == 'True' ) {
		$_GET['whereval'] = '%' . $_GET['whereval'] . '%';
	}
}

// Add filter
if ( !empty($_GET['addwhere']) && isset($_GET['whereval']) ) {
	$found = false;

	if ( isset($_SESSION['list_where']) ) {
		foreach ( $_SESSION['list_where'] as $key => $val ) {
			if ( $val['field'] == $_GET['addwhere'] ) {
				if ( $val['value'] == $_GET['whereval'] ) {
					$found = true;
					break;
				}
			}
		}
	}

	if ( !$found ) {
		if ( isset($_GET['caption']) ) {
			$_SESSION['list_where'][] = array('field' => $_GET['addwhere'], 'value' => $_GET['whereval'], 'caption' => $_GET['caption']);
		}
		else {
			$_SESSION['list_where'][] = array('field' => $_GET['addwhere'], 'value' => $_GET['whereval']);
		}
		$_SESSION['list_page'] = 1;
	}
}

setDefaultFilter();

// Which page selected?
if ( isset($_GET['list_page']) ) {
	$_SESSION['list_page'] = $_GET['list_page'];
}
// Which letter selected?
if ( isset($_GET['letter']) ) {
	if ( $_GET['letter'] == 'off' ) {
		$_SESSION['letter'] = NULL;
	}
	else if ( $_GET['letter'] == '0' ) {
		$_SESSION['letter'] = '#';
	}
	else {
		$_SESSION['letter'] = $_GET['letter'];
	}
}
if ( !isset($_SESSION['letters']) ) {
	$_SESSION['letters'] = str_split('#ABCDEFGHIJKLMNOPQRSTUVWXYZ');
}

// Generate sql with filters
$sql = generateSql();
// Save statement
$_SESSION['list_sql'] = $sql;

// Set caching for menue.tpl
$smarty = new pmp_Smarty;
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->caching = $pmp_smarty_caching;
$smarty->cache_lifetime = $pmp_cache_lifetime;

if ( !$smarty->isCached('menue.tpl', crc32($sql)) ) {
	$res = dbexec($sql, true);

	if ( $res === false ) {
		$oldsql = $sql;
		unset($_SESSION['list_where']);
		unset($_SESSION['list_orderby']);
		setDefaultFilter();
		$sql = generateSql();
		$olderror = mysql_error();
		$res = dbexec($sql);
		$smarty->assign('Error', t('An error occured during your query. To continue working all filters will be set to default values.'));
	}

	$dvds = array();
	while ( $row = mysql_fetch_object($res) ) {
		$dvds[] = new smallDVD($row->id);
	}

	$smarty->assign('dvds', $dvds);

	// Get extern filters
		$extFilter = array();
		foreach ( $_SESSION['list_where'] as $feld => $val ) {
		if ( isset($val['caption']) ) {
			$extFilter[] = $val;
		}
	}

	$smarty->assign('extFilter', $extFilter);

	// Number of DVDs
	$res = dbexec(generateSql(true));
	$row = mysql_fetch_object($res);
	$dvdcount = $row->c;

	$smarty->assign('sort', $sortcount);
	$smarty->assign('count', $dvdcount);
	$smarty->assign('page', (int)$_SESSION['list_page']);
	$smarty->assign('pages', (int)($dvdcount / $pmp_dvd_menue + ((($dvdcount % $pmp_dvd_menue)==0)? 0 : 1)));
	if (isset( $_SESSION['letter']) ) $smarty->assign('letter', $_SESSION['letter']);
	$smarty->assign('letters', $_SESSION['letters']);
	// Locations
	$res = dbexec('SELECT DISTINCT locality FROM pmp_film');
	$loc = array();
	while ( $row = mysql_fetch_object($res) ) {
		$loc[] = $row->locality;
	}

	$smarty->assign('locations', $loc);

	// Origins
	$res = dbexec('SELECT DISTINCT country FROM pmp_countries_of_origin where country != \'\'');
	$origin = array();
	while ( $row = mysql_fetch_object($res) ) {
		$origin[] = $row->country;
	}

	$smarty->assign('origins', $origin);

	$pmp_menue_column_1 = getColumns($pmp_menue_column_1);
	$pmp_menue_column_2 = getColumns($pmp_menue_column_2);
	$pmp_menue_column_3 = getColumns($pmp_menue_column_3);
	$pmp_menue_column_4 = getColumns($pmp_menue_column_4);
	$pmp_menue_column_5 = getColumns($pmp_menue_column_5);
	$pmp_menue_column_6 = getColumns($pmp_menue_column_6);

	$menue_columns = 0;

	// How many columns we get?
	if ( isset($pmp_menue_column_6['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( isset($pmp_menue_column_5['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( isset($pmp_menue_column_4['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( isset($pmp_menue_column_3['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( isset($pmp_menue_column_2['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( isset($pmp_menue_column_1['Output']) != '' ) {
		$menue_columns += 1;
	}
	if ( $pmp_menue_column_0 != '0' ) {
		$menue_columns +=1;
	}

	$smarty->assign('menue_columns', $menue_columns);
}

dbclose();

// Uncomment for developing/debugging
#echo "<b>SQL data:</b><br/>";
#echo $sql . "<br/>";
#echo "<b>Old SQL data:</b><br/>";
#echo $oldsql . "<br/>";
#echo "<b>Old error data:</b><br/>";
#echo $olderror . "<br/>";

// Show menue
$smarty->display('menue.tpl', crc32($sql));
?>
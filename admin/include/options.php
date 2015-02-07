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

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$Options[] = 'Main settings';
$Options[] = new option('pmp_sqlhost', 'Database server', '', $pmp_sqlhost);
$Options[] = new option('pmp_sqluser', 'Database user', '', $pmp_sqluser);
$Options[] = new option('pmp_sqlpass', 'Database password', '', $pmp_sqlpass, OPTION_PASSWORD);
$Options[] = new option('pmp_sqldatabase', 'Database name', '', $pmp_sqldatabase);
$Options[] = new option('pmp_table_prefix', 'Table prefix', '', $pmp_table_prefix);

$Options[] = 'Basic settings';
$Options[] = new option('pmp_admin_name', 'Administrator\'s name', '', $pmp_admin_name);
$Options[] = new option('pmp_admin_mail', 'Administrator\'s Email', '', $pmp_admin_mail);
$Options[] = new option('pmp_pagetitle', 'Page title', '', $pmp_pagetitle);
$Options[] = new option('pmp_smarty_caching', 'Cache templates', 'Cache templates in cache directory (must be writeable). This will speed up your phpMyProfiler a lot, but you will need som additional webspace for the chached templates.', $pmp_smarty_caching, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_cache_lifetime', 'Cache lifetime', 'Lifetime of a cached template. After this time the template will rendered new. When parsing a new collection, the cache is flushed automatically, so using unlimited should be no problem.', $pmp_cache_lifetime, array(3600 => '1 hour', 7200 => '2 hours', 10800 => '3 hours', 43200 => '12 hours', 86400 => '24 hours', -1 => 'unlimited' ));
$Options[] = new option('pmp_checkforupdates', 'Check for updates', 'Contact www.phpmyprofiler.de when entering the admin-menu and check if a new version is available.', $pmp_checkforupdates, array(1 => 'Yes', 0 => 'No'));

$Options[] = 'Imprint';
$Options[] = new option('pmp_imprint', 'Show imprint?', 'If you you choose no, you can skip this category.', $pmp_imprint, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_admin_full', 'Full name', '', $pmp_admin_full);
$Options[] = new option('pmp_admin_loc', 'Place of residence', '', $pmp_admin_loc);
$Options[] = new option('pmp_admin_zip', 'Zip code', '', $pmp_admin_zip);
$Options[] = new option('pmp_admin_adr', 'Adress', '', $pmp_admin_adr);
$Options[] = new option('pmp_admin_cnt', 'Country', '', $pmp_admin_cnt);

$Options[] = 'Language settings';
$Options[] = new option('pmp_lang_default', 'Default language', '', $pmp_lang_default, array('en' => 'English', 'de' => 'German', 'dk' => 'Danish', 'no' => 'Norwegian', 'nl' => 'Dutch'));
$Options[] = new option('pmp_dateformat', 'Date format', '', $pmp_dateformat, array('%m/%d/%y' => 'MM/DD/YY', '%d.%m.%Y' => 'DD.MM.YYYY', '%Y/%m/%d' => 'YYYY-MM-DD'));
$Options[] = new option('pmp_usecurrency', 'Preferred currency', '', $pmp_usecurrency, getCurrencies());
$Options[] = new option('pmp_dec_point', 'Decimal point', '', $pmp_dec_point, array('.' => 'point', ',' => 'comma'));
$Options[] = new option('pmp_thousands_sep', 'Thousands seperator', '', $pmp_thousands_sep, array(',' => 'comma', '.' => 'point'));
$Options[] = new option('pmp_timezone', 'Timezone', '', $pmp_timezone, getTimezones());

$Options[] = 'Parser settings';
$Options[] = new option('pmp_parser_mode', 'Parser mode', "'Build from scratch' will delete all profiles, 'Update with delete' will only delete profiles not in xml, 'Update without delete' will delete no profiles but update those in xml.", $pmp_parser_mode, array(0 => 'Build from scratch', 1 => 'Update with delete', 2 => 'Update without delete'));
$Options[] = new option('pmp_splitxmlafter', 'Split collection after x DVDs', "If your server is too slow to parse all dvds at once (timeout error occurs), you can split the file into smaller pieces. This setting is used only in 'Build from scratch'-Mode.", $pmp_splitxmlafter);
$Options[] = new option('pmp_build_banners', 'Build banners for use in a signature', "This will create banners for the last ten added and/or watched movies.", $pmp_build_banners, array(0 => 'No banner', 1 => 'Last added banner only', 2 => 'Last watched banner only', 3 => 'Both banners'));
$Options[] = new option('pmp_banner_name', 'Build banners for', "This will insert the name to the banner title. Notice that this will also filter for watched movies by this person.", $pmp_banner_name);

$Options[] = 'Graphic settings';
$Options[] = new option('pmp_gdlib', 'Use graphic funtions', 'Set to yes, if GD-Libs are installed', $pmp_gdlib, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_thumbnail_cache', 'Cache thumbnails', 'Cached thumbnails in cache directory (must be writeable). This will speed up your phpMyProfiler but you will need some additional webspace for the thumbnails.', $pmp_thumbnail_cache, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_stat_use_ttf', 'Use true type fonts in graphs', 'You need to use true type fonts for languages with special characters (eg. Norwegian &Oslash;)', $pmp_stat_use_ttf, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_hdbanner', 'Show HD banner', 'Will only work if GD-Libs are enabled', $pmp_hdbanner, array(0 => 'No', 1 => 'Yes'));

$Options[] = 'Display settings';
$Options[] = new option('pmp_theme', 'Theme', '', $pmp_theme, listthemes());
$Options[] = new option('pmp_theme_css', 'Theme CSS', '', $pmp_theme_css, getThemeCSS());
$Options[] = new option('pmp_dvd_start', 'Number of DVDs at start page', '', $pmp_dvd_start);
$Options[] = new option('pmp_dvd_menue', 'Number of DVDs in DVD list per page', '', $pmp_dvd_menue);
$Options[] = new option('pmp_entries_side', 'Number of entries in guestbook per page', '', $pmp_entries_side);
$Options[] = new option('pmp_picture_page', 'Number of photos in photo gallery per page', '', $pmp_picture_page);
$Options[] = new option('pmp_news_page', 'Number of news in news archive per page', '', $pmp_news_page);
$Options[] = new option('pmp_cover_page', 'Number of covers in cover gallery per page', '', $pmp_cover_page);
$Options[] = new option('pmp_cover_per_row', 'Number of covers in cover gallery per line', '', $pmp_cover_per_row);
$Options[] = new option('pmp_people_per_row', 'Number of pictures in person gallery per line', '', $pmp_people_per_row);
$Options[] = new option('pmp_people_per_page', 'Number of pictures in person gallery per page', '', $pmp_people_per_page);
$Options[] = new option('pmp_events_showtime', 'Show time information on event page', '', $pmp_events_showtime, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_disable_newsarchive', 'Disable newsarchive', '', $pmp_disable_newsarchive, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_disable_guestbook', 'Disable guestbook', '', $pmp_disable_guestbook, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_disable_contact', 'Disable contact', '', $pmp_disable_contact, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_disable_links', 'Disable phpMyProfiler website and forum links', '', $pmp_disable_links, array(0 => 'No', 1 => 'Yes'));

$Options[] = 'Display settings for profiles';
$Options[] = new option('pmp_show_mediatype', 'Show media type before title', '', $pmp_show_mediatype, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_exclude_tag', 'Exclude tag', 'Don\'t show media with this selected tag', $pmp_exclude_tag, getTags());
$Options[] = new option('pmp_html_notes', 'Use HTML-Code in notices', '', $pmp_html_notes, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_review_type', 'Type of review', '', $pmp_review_type, array(0 => 'Default (Movie, DVD)', 1 => 'Simple (Movie)', 2 => 'Detailed (Movie, Video, Audio, Extras)', 3 => 'Deactivated'));
$Options[] = new option('pmp_extern_reviews', 'Activate external reviews', '', $pmp_extern_reviews, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_show_brief_review', 'Show review summary graph', '', $pmp_show_brief_review, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_show_links', 'Show external links on profile page', '', $pmp_show_links, array(0 => 'Auto', 1 => 'My Links', 2 => 'External Links', 3 => 'All', 4 => 'None'));
$Options[] = new option('pmp_disable_reviews', 'Disable reviews', '', $pmp_disable_reviews, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_use_countas', 'Use Count As value from DVDProfiler for statistics', '', $pmp_use_countas, array(0 => 'No', 1 => 'Yes'));

$Options[] = 'Other settings';
$Options[] = new option('pmp_guestbook_activatenew', 'Activate guestbooks entries automatically', '', $pmp_guestbook_activatenew, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_guestbook_showcode', 'Use security code in guestbook', '', $pmp_guestbook_showcode , array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_review_activatenew', 'Activate reviews automatically', '', $pmp_review_activatenew, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_start_sort_order', 'Sort order of latest DVDs', '', $pmp_start_sort_order, array('collectionnumber' => 'Number', 'purchdate' => 'Date of purchase'));
$Options[] = new option('pmp_statistic_showprice', 'Show price informations in statistics', '', $pmp_statistic_showprice, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_dir_cast', 'Relative path to cast directory', 'Change this value only if you know what your are doing.', $pmp_dir_cast);
$Options[] = new option('pmp_google', 'Enable Google Analytics', '', $pmp_google, array(0 => 'No', 1 => 'Yes'));
$Options[] = new option('pmp_tracking_code', 'Google Analytics Tracking Code', 'No support for Google Universal Analytics!', $pmp_tracking_code);
$Options[] = new option('pmp_compression', 'Turn on gzip output buffer', '', $pmp_compression, array(0 => 'No', 1 => 'Yes'));

$Options[] = 'DVD-List';
$Options[] = new option('pmp_menue_sortby', 'Default sort order', '', $pmp_menue_sortby, getColumnsasOption());
$Options[] = new option('pmp_menue_sortdir', 'Default sort order direction', '', $pmp_menue_sortdir, array('asc' => 'Ascending', 'desc' => 'Descending'));
$Options[] = new option('pmp_menue_childs', 'Default sort order of child profiles', '', $pmp_menue_childs, array('collectionnumber' => 'Number', 'prodyear' => 'Year', 'sorttitle' => 'Title'));
$Options[] = new option('pmp_menue_column_0', 'Show sequential number', '', $pmp_menue_column_0, array(1 => 'Yes', 0 => 'No'));
$Options[] = new option('pmp_menue_column_1', 'Column 1', 'Hide column 1 also hide the "+" before Boxsets and the films are not clickable.', $pmp_menue_column_1, getColumnsasOption());
$Options[] = new option('pmp_menue_column_2', 'Column 2', '', $pmp_menue_column_2, getColumnsasOption());
$Options[] = new option('pmp_menue_column_3', 'Column 3', '', $pmp_menue_column_3, getColumnsasOption());
$Options[] = new option('pmp_menue_column_4', 'Column 4', '', $pmp_menue_column_4, getColumnsasOption());
$Options[] = new option('pmp_menue_column_5', 'Column 5', '', $pmp_menue_column_5, getColumnsasOption());
$Options[] = new option('pmp_menue_column_6', 'Column 6', '', $pmp_menue_column_6, getColumnsasOption());

function listthemes() {
	$data = getThemes();

	foreach ($data as $th) {
		if ($th->wrongversion) {
			$res[$th->id] = $th->name . ' ' . t('(Warning: Version mismatch)');
		}
		else {
			$res[$th->id] = $th->name;
		}
	}

	return $res;
}
?>
<?php
/* phpMyProfiler
 * Copyright (C) 2008-2012 The phpMyProfiler project
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

function smarty_modifier_rating($rating, $locality) {
	global $pmp_theme;

	$pics['united states']['G']		= array('Image' => 'rating/us_g.gif', 'Desc' => "General Audience");
	$pics['united states']['PG']	= array('Image' => 'rating/us_pg.gif', 'Desc' => "Parental Guidance Suggested");
	$pics['united states']['PG-13']	= array('Image' => 'rating/us_pg13.gif', 'Desc' => "Parents Strongly Cautioned");
	$pics['united states']['NC-17']	= array('Image' => 'rating/us_nc17.gif', 'Desc' => "No one 17 and under admitted");
	$pics['united states']['R']		= array('Image' => 'rating/us_r.gif', 'Desc' => "Restricted");

	$pics['canada']['G']		= array('Image' => 'rating/ca_g.gif', 'Desc' => "General (G)");
	$pics['canada']['PG']		= array('Image' => 'rating/ca_pg.gif', 'Desc' => "Parental Guidance (PG)");
	$pics['canada']['14A']		= array('Image' => 'rating/ca_14a.gif', 'Desc' => "14 Adult Accompaniment (14A)");
	$pics['canada']['18A']		= array('Image' => 'rating/ca_18a.gif', 'Desc' => "18 Adult Accompaniment (18A)");
	$pics['canada']['R']		= array('Image' => 'rating/ca_r.gif', 'Desc' => "Restricted (R)");

	$pics['united kingdom']['U']	= array('Image' => 'rating/uk_u.png', 'Desc' => "Universal Classification");
	$pics['united kingdom']['UC']	= array('Image' => 'rating/uk_uc.png', 'Desc' => "Universal Children Classification");
	$pics['united kingdom']['PG']	= array('Image' => 'rating/uk_pg.png', 'Desc' => "'PG' Parental Guidance");
	$pics['united kingdom']['12']	= array('Image' => 'rating/uk_12.png', 'Desc' => "Suitable for 12 years and over");
	$pics['united kingdom']['15']	= array('Image' => 'rating/uk_15.png', 'Desc' => "Suitable only for 15 years and over");
	$pics['united kingdom']['18']	= array('Image' => 'rating/uk_18.png', 'Desc' => "Suitable only for adults");
	$pics['united kingdom']['R']	= array('Image' => 'rating/uk_r.png', 'Desc' => "'R18' - To be shown only in specially licensed cinemas, or supplied only in licensed sex shops, and to adults of not less than 18 years.");

	$pics['germany']['FSK-0']	= array('Image' => 'rating/de_fsk0.png', 'Desc' => "Freigegeben ohne Altersbeschr&auml;nkung");
	$pics['germany']['FSK-6']	= array('Image' => 'rating/de_fsk6.png', 'Desc' => "Freigegeben ab 6 Jahren");
	$pics['germany']['FSK-12']	= array('Image' => 'rating/de_fsk12.png', 'Desc' => "Freigegeben ab 12 Jahren");
	$pics['germany']['FSK-16']	= array('Image' => 'rating/de_fsk16.png', 'Desc' => "Freigegeben ab 16 Jahren");
	$pics['germany']['FSK-18/KJ']	= array('Image' => 'rating/de_fsk18.png', 'Desc' => "Keine Jugendfreigabe");
	$pics['germany']['SPIO/JK SU']	= array('Image' => 'rating/de_spio.gif', 'Desc' => "Juristisch gepr&uuml;ft/strafrechtlich unbedenklich");

	$pics['austria']['FSK-0']	= array('Image' => 'rating/de_fsk0.png', 'Desc' => "Freigegeben ohne Altersbeschr&auml;nkung");
	$pics['austria']['FSK-6']	= array('Image' => 'rating/de_fsk6.png', 'Desc' => "Freigegeben ab 6 Jahren");
	$pics['austria']['FSK-12']	= array('Image' => 'rating/de_fsk12.png', 'Desc' => "Freigegeben ab 12 Jahren");
	$pics['austria']['FSK-16']	= array('Image' => 'rating/de_fsk16.png', 'Desc' => "Freigegeben ab 16 Jahren");
	$pics['austria']['FSK-18/KJ']	= array('Image' => 'rating/de_fsk18.png', 'Desc' => "Keine Jugendfreigabe");
	$pics['austria']['SPIO/JK SU']	= array('Image' => 'rating/de_spio.png', 'Desc' => "Juristisch gepr&uuml;ft/strafrechtlich unbedenklich");

	$pics['switzerland']['FSK-0']	= array('Image' => 'rating/de_fsk0.png', 'Desc' => "Freigegeben ohne Altersbeschr&auml;nkung");
	$pics['switzerland']['FSK-6']	= array('Image' => 'rating/de_fsk6.png', 'Desc' => "Freigegeben ab 6 Jahren");
	$pics['switzerland']['FSK-12']	= array('Image' => 'rating/de_fsk12.png', 'Desc' => "Freigegeben ab 12 Jahren");
	$pics['switzerland']['FSK-16']	= array('Image' => 'rating/de_fsk16.png', 'Desc' => "Freigegeben ab 16 Jahren");
	$pics['switzerland']['FSK-18/KJ']= array('Image' => 'rating/de_fsk18.png', 'Desc' => "Keine Jugendfreigabe");
	$pics['switzerland']['SPIO/JK SU'] = array('Image' => 'rating/de_spio.png', 'Desc' => "Juristisch gepr&uuml;ft/strafrechtlich unbedenklich");

	$pics['australia']['G']		= array('Image' => 'rating/aus_g.gif', 'Desc' => "General");
	$pics['australia']['PG']	= array('Image' => 'rating/aus_pg.gif', 'Desc' => "Parental guidance recommended");
	$pics['australia']['M']		= array('Image' => 'rating/aus_m.gif', 'Desc' => "Recommended for mature audiences");
	$pics['australia']['M15']	= array('Image' => 'rating/aus_ma.gif', 'Desc' => "Not suitable for people under 15. Under 15s must be accompanied by a parent or adult guardian");
	$pics['australia']['R18']	= array('Image' => 'rating/aus_r18.gif', 'Desc' => "Restricted to 18 and over");
	$pics['australia']['X18']	= array('Image' => 'rating/aus_x18.gif', 'Desc' => "Restricted to 18 and over");

	$pics['netherlands']['ALL']	= array('Image' => 'rating/nl_all.gif', 'Desc' => "Niet schadelijk/Alle Leeftijden");
	$pics['netherlands']['6']	= array('Image' => 'rating/nl_6.gif', 'Desc' => "Let op met kinderen tot 6 jaar");
	$pics['netherlands']['9']	= array('Image' => 'rating/nl_9.gif', 'Desc' => "Let op met kinderen tot 9 jaar");
	$pics['netherlands']['12']	= array('Image' => 'rating/nl_12.gif', 'Desc' => "Let op met kinderen tot 12 jaar");
	$pics['netherlands']['16']	= array('Image' => 'rating/nl_16.gif', 'Desc' => "Let op met kinderen tot 16 jaar");
	$pics['netherlands']['18+']	= array('Image' => 'rating/nl_18+.gif', 'Desc' => "Voor personen ouder dan 18 jaar");

	if ( isset($pics[strtolower($locality)][$rating]) && is_array($pics[strtolower($locality)][$rating]) ) {
		return '<img src="' . _PMP_REL_PATH . '/themes/' . $pmp_theme . '/images/' . $pics[strtolower($locality)][$rating]['Image'] . '" alt="'. $rating . '" title="'. $pics[strtolower($locality)][$rating]['Desc'] . '" style="height: 40px; vertical-align: middle;" />';
	}
}
?>

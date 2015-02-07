<?php
/* phpMyProfiler
 * Copyright (C) 2006-2015 The phpMyProfiler project
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

/*
 * Replace Emoticons like ;) or :) with Smilies
*/

// Disallow direct access
defined('_PMP_REL_PATH') or die('Not allowed! Possible hacking attempt detected!');

$emoticons[':)'] = 'regular.png';
$emoticons[':-)'] = 'regular.png';
$emoticons[';)'] = 'wink.png';
$emoticons[';-)'] = 'wink.png';
$emoticons[':-p'] = 'tongue.png';
$emoticons[':p'] = 'tongue.png';
$emoticons[':-P'] = 'tongue.png';
$emoticons[':P'] = 'tongue.png';
$emoticons[':-d'] = 'megasmile.png';
$emoticons[':d'] = 'megasmile.png';
$emoticons[':-D'] = 'megasmile.png';
$emoticons[':D'] = 'megasmile.png';
$emoticons[':-('] = 'sad.png';
$emoticons[':('] = 'sad.png';
$emoticons[':\'('] = 'cry.png';
$emoticons[':@'] = 'angry.png';
$emoticons[':-@'] = 'angry.png';
$emoticons[':S'] = 'confused.png';
$emoticons[':s'] = 'confused.png';
$emoticons[':$'] = 'embarrassed.png';
$emoticons[':-$'] = 'embarrassed.png';
$emoticons[':O)'] = 'omg.png';
$emoticons[':o'] = 'omg.png';
$emoticons[':-|'] = 'ugly.png';
$emoticons[':|'] = 'ugly.png';
$emoticons['(h)'] = 'shade.png';
$emoticons['(H)'] = 'shade.png';
$emoticons['8o|'] = 'bearingteeth.png';
$emoticons['&amp;lt;o)'] = 'party.png';
$emoticons['|-)'] = 'sleepy.png';
$emoticons['|)'] = 'sleepy.png';
$emoticons['+o('] = 'sick.png';
$emoticons['*-)'] = 'thinking.png';
$emoticons['*)'] = 'thinking.png';
$emoticons[':^)'] = 'dunno.png';
$emoticons[':-#'] = 'sshh.png';
$emoticons[':#'] = 'sshh.png';
$emoticons[':-*'] = 'secret.png';
$emoticons[':*'] = 'secret.png';
$emoticons['8-)'] = 'nerd.png';
$emoticons['8)'] = 'nerd.png';
$emoticons['8-)'] = 'eyeroll.png';
$emoticons['8)'] = 'eyeroll.png';
$emoticons['^o)'] = 'sarcastic.png';

function replace_emoticons($text) {
	global $emoticons;

	$path = _PMP_REL_PATH.'/themes/default/images/emoticons/';
	$img = '<img src="'.$path.'%s" alt="%s"/>';

	foreach ($emoticons as $emoticon => $pic) {
		$fullpic = sprintf($img, $pic, $emoticon);
		$text = str_replace($emoticon, $fullpic, $text);
	}

	return $text;
}
?>
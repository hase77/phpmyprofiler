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

class smallDVD {
	function smallDVD($id) {
		global $pmp_db, $pmp_dateformat, $pmp_usecurrency, $pmp_html_notes, $pmp_thousands_sep, $pmp_dec_point, $pmp_exclude_tag, $pmp_menue_childs;

		if (isset($id)) {
			$query = 'SELECT * FROM pmp_film WHERE id = ?';

			if (!empty($pmp_exclude_tag)) {
				$query .= ' AND id NOT IN (SELECT id FROM pmp_tags where name = ?)';
				$params = [$id, $pmp_exclude_tag];
			}
			else {
				$params = [$id];
			}

			$row = dbquery_pdo($query, $params, 'assoc');

			if (count($row) > 0) {
				$this->id = $id;

				$this->ProfileDate = strftime($pmp_dateformat, strtotime($row[0]['profiletimestamp']));

				if ($row[0]['media_bluray'] == 1) {
					$this->Media = 'Blu-ray';
				}
				else if ($row[0]['media_hddvd'] == 1) {
					$this->Media = 'HD DVD';
				}
				else if ($row[0]['media_dvd'] == 1) {
					$this->Media = 'DVD';
				}
				else if ($row[0]['media_custom'] != '') {
					$this->Media = $row[0]['media_custom'];
				}

				$this->UPC = $row[0]['upc'];
				if ($row[0]['collectionnumber'] != 0) {
					$this->Number = $row[0]['collectionnumber'];
				}
				else {
					$this->Number = '';
				}
				$this->Owned = $row[0]['collectiontype'];
				$this->Title = htmlspecialchars($row[0]['title'], ENT_COMPAT, 'UTF-8');
				$this->Edition = htmlspecialchars($row[0]['disttrait'], ENT_COMPAT, 'UTF-8');
				$this->OriginalTitle = htmlspecialchars($row[0]['originaltitle'], ENT_COMPAT, 'UTF-8');
				$this->Year = $row[0]['prodyear'];
				if ($row[0]['released'] != '0000-00-00') {
					$this->Released = strftime($pmp_dateformat, strtotime($row[0]['released']));
				}
				else {
					$this->Released = '';
				}
				$this->Length = $row[0]['runningtime'];
				$this->LengthHours = sprintf("%d", $row[0]['runningtime']/60);
				$this->LengthMins = sprintf("%02d", $row[0]['runningtime']%60);
				$this->RatingSystem = htmlspecialchars($row[0]['ratingsystem'], ENT_COMPAT, 'UTF-8');
				$this->Rating = $row[0]['rating'];
				$this->RatingAge = $row[0]['ratingage'];
				$this->RatingVariant = $row[0]['ratingvariant'];
				$this->RatingDetails = $row[0]['ratingdetails'];
				$this->Casetype = $row[0]['casetype'];
				$this->Slipcover = $row[0]['slipcover'];
				if ($row[0]['srp'] != '0.00') {
					$this->Price = number_format($row[0]['srp'], get_currency_digits($row[0]['srpid']), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->Price = $row[0]['srp'];
				}
				$this->CurrencyID = $row[0]['srpid'];
				$this->convAvgCurrency = $pmp_usecurrency;
				if ( $row[0]['srp'] != '0.00' ) {
					$this->convAvgPrice = number_format(exchange($row[0]['srpid'], $pmp_usecurrency, $row[0]['srp']), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->convAvgPrice = $row[0]['srp'];
				}
				if ($row[0]['gift'] == 1) {
					$this->Gift = true;
					$query = "SELECT * FROM pmp_users WHERE user_id = ?";
					$params = [$row[0]['giftfrom']];
					$result = dbquery_pdo($query, $params, 'assoc');
					if (count($result) > 0) {
						$this->GiftFrom = new stdClass();
						$this->GiftFrom->FirstName = $result[0]['firstname'];
						$this->GiftFrom->LastName = $result[0]['lastname'];
						$this->GiftFrom->Email = $result[0]['email'];
						$this->GiftFrom->Phone = $result[0]['phone'];
					}
				} else {
					$this->Gift = false;
				}
				$this->Overview = str_replace("&", "&amp;", html_entity_decode($row[0]['overview'], ENT_COMPAT, 'UTF-8'));
				$this->Easteregg  = htmlspecialchars($row[0]['easteregg'], ENT_COMPAT, 'UTF-8');
				$this->LastEdited = strftime($pmp_dateformat, strtotime($row[0]['lastedit']));
				$this->WishPriority = $row[0]['wishpriority'];
				if ($row[0]['purchprice'] != '0.00') {
					$this->PurchPrice = number_format($row[0]['purchprice'], get_currency_digits($row[0]['purchcurrencyid']), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->PurchPrice = $row[0]['purchprice'];
				}
				$this->PurchCurrencyID = $row[0]['purchcurrencyid'];
				$this->ConvCurrency = $pmp_usecurrency;
				if ($row[0]['purchprice'] != '0.00') {
					$this->ConvPrice = number_format(exchange($row[0]['purchcurrencyid'], $pmp_usecurrency, $row[0]['purchprice']), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->ConvPrice = $row[0]['purchprice'];
				}
				if ($row[0]['purchdate'] != '0000-00-00') {
					$this->PurchDate = strftime($pmp_dateformat, strtotime($row[0]['purchdate']));
				}
				else {
					$this->PurchDate = '';
				}
				$this->PurchPlace = $row[0]['purchplace'];
				$this->PurchPlaceWebsite = $row[0]['purchwebsite'];
				$this->ReviewFilm = $row[0]['reviewfilm'];
				$this->ReviewAudio = $row[0]['reviewaudio'];
				$this->ReviewVideo = $row[0]['reviewvideo'];
				$this->ReviewExtras = $row[0]['reviewextras'];
				if ($row[0]['loaned'] == 1) {
					$this->Loaned = true;
					$query = 'SELECT * FROM pmp_users WHERE user_id = ?';
					$params = [$row[0]['loanedto']];
					$result = dbquery_pdo($query, $params, 'assoc');
					if (count($result) > 0) {
						$this->LoanTo = new stdClass();
						$this->LoanTo->FirstName = $result[0]['firstname'];
						$this->LoanTo->LastName = $result[0]['lastname'];
						$this->LoanTo->Email = $result[0]['email'];
						$this->LoanTo->Phone = $result[0]['phone'];
						$this->LoanReturn = strftime($pmp_dateformat, strtotime($row[0]['loaneddue']));
					}
				} else {
					$this->Loaned = false;
				}
				if ($pmp_html_notes == true) {
					$this->Notices = html_entity_decode($row[0]['notes'], ENT_COMPAT, 'UTF-8');
				}
				else {
					$this->Notices = htmlspecialchars($row[0]['notes'], ENT_COMPAT, 'UTF-8');
				}
				$this->Locality = $row[0]['locality'];
				$this->EPG = $row[0]['epg'];
				$this->Review = $row[0]['review'];

				// Is boxset?
				$query = 'SELECT * FROM pmp_boxset LEFT JOIN pmp_film ON pmp_film.id = pmp_boxset.childid
						  WHERE pmp_boxset.id = ? ORDER BY ?';
				$params = [$id, $pmp_menue_childs];
				$result = dbquery_pdo($query, $params, 'object');

				if (count($result) > 0) {
					$this->Boxset_childs = [];
					foreach ($result as $box_child) {
						if (!empty($box_child->childid) ) {
							$child = new smallDVD($box_child->childid);

							if (!empty($child->id)) {
								$this->Boxset_childs[] = $child;
							}
						}
					}
					if (count($this->Boxset_childs) > 0) {
						$this->isBoxset = true;
					}
				}
				else {
					unset( $this->Boxset_childs );
					$this->isBoxset = false;
				}

				// Or child?
				$query = 'SELECT id FROM pmp_boxset WHERE childid = ?';
				$params = [$id];
				$result = dbquery_pdo($query, $params, 'assoc');
				if (count($result) > 0) {
					$this->partofBoxset = $result[0]['id'];
				}
				else {
					$this->partofBoxset = false;
				}

				// Countries of origin
				$query = 'SELECT country FROM pmp_countries_of_origin WHERE id = ?';
				$params = [$id];
				$result = dbquery_pdo($query, $params, 'object');
				if (count($result) > 0) {
					foreach ($result as $origin) {
						$this->Origins[] = $origin->country;
					}
				}

				// Check for cover
				$this->frontpic = file_exists(_PMP_REL_PATH.'/cover/'.$id.'f.jpg');
				$this->backpic = file_exists(_PMP_REL_PATH.'/cover/'.$id.'b.jpg');
			}
		}
	}

	function getLocationFlag() {
		global $pmp_theme;
		$flag = getFlagName($this->Locality);

		if (empty($flag)) {
			return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/flags/Noflag.gif" alt="'. $this->Locality.'" style="width: 20px; height: 12px;" title="'.t($this->Locality).'"/>';
		}
		else {
			return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/flags/'.$flag.'" alt="'.$this->Locality.'" style="width: 20px; height: 12px;" title="'.t($this->Locality).'"/>';
		}
	}

	function getOriginFlag() {
		global $pmp_theme;
		$origins = '';

		foreach ($this->Origins as $origin) {
			$flag = getFlagName($origin);

			if (empty($flag)) {
				$origins .= '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/flags/Noflag.gif" alt="'.$origin.'" width="20" title="'.$origin.'"/>';
			}
			else {
				$origins .= '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/flags/'.$flag.'" alt="'.$origin.'" width="20" title="'.$origin.'"/>';
			}
		}

		return $origins;
	}

	function getMediaIcon() {
		global $pmp_theme;
		global $pmp_custom_media;

		if ($this->Media == 'DVD') {
			return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/additional/DVD_s.png" alt="'. $this->Media.'"/>';
		}
		else if ($this->Media == 'Blu-ray') {
			return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/additional/BluRay_s.png" alt="'.$this->Media.'"/>';
		}
		else if ($this->Media == 'HD DVD') {
			return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/additional/HDDVD_s.png" alt="'.$this->Media.'" />';
		}
		else {
			// Custom media
			if (isset($pmp_custom_media[$this->Media])) {
				return '<img src="'._PMP_REL_PATH.'/themes/'.$pmp_theme.'/images/additional/'.$pmp_custom_media[$this->Media]['small'].'" alt="'.$this->Media.'"/>';
			}
		}
	}

	function get($f) {
		global $pmp_show_mediatype;

		if (method_exists($this, $f)) {
			return $this->$f();
		}
		else {
			if ($f == 'Title' && $pmp_show_mediatype == 1) {
				return $this->getMediaIcon()." ".$this->$f;
			}
			else {
				return $this->$f;
			}
		}
	}
}
?>
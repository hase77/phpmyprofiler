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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
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
			$query = "SELECT * FROM pmp_film WHERE id = ?";

			if (!empty($pmp_exclude_tag)) {
				$query .= " AND id NOT IN (SELECT id FROM pmp_tags where name = ?')";
				$params = [$id, $pmp_exclude_tag];
			}
			else {
				$params = [$id];
			}

			$rows = dbquery_pdo($query, $params);

			foreach ($rows as $row) {
				foreach ($row as $key => $value) {
					$this->_db[$key] = $value;
					$this->$key = $value;
				}

				$this->ProfileDate = strftime($pmp_dateformat, strtotime($this->_db['profiletimestamp']));
		
				if ($this->_db['media_bluray'] == 1) {
					$this->Media = 'Blu-ray';
				}
				else if ($this->_db['media_hddvd'] == 1) {
					$this->Media = 'HD DVD';
				}
				else if ($this->_db['media_dvd'] == 1) {
					$this->Media = 'DVD';
				}
				else if ($this->_db['media_custom'] != '') {
					$this->Media = $this->_db['media_custom'];
				}
		
				$this->UPC = $this->_db['upc'];
				if ($this->_db['collectionnumber'] != 0) {
					$this->Number = $this->_db['collectionnumber'];
				}
				else {
					$this->Number = '';
				}
				$this->Owned = $this->_db['collectiontype'];
				$this->Title = htmlspecialchars($this->_db['title'], ENT_COMPAT, 'UTF-8');
				$this->Edition = htmlspecialchars($this->_db['disttrait'], ENT_COMPAT, 'UTF-8');
				$this->OriginalTitle = htmlspecialchars($this->_db['originaltitle'], ENT_COMPAT, 'UTF-8');
				$this->Year = $this->_db['prodyear'];
				if ($this->_db['released'] != '0000-00-00') {
					$this->Released = strftime($pmp_dateformat, strtotime($this->_db['released']));
				}
				else {
					$this->Released = '';
				}
				$this->Length = $this->_db['runningtime'];
				$this->LengthHours = sprintf("%d", $this->_db['runningtime']/60);
				$this->LengthMins = sprintf("%02d", $this->_db['runningtime']%60);
				$this->RatingSystem = htmlspecialchars($this->_db['ratingsystem'], ENT_COMPAT, 'UTF-8');
				$this->Rating = $this->_db['rating'];
				$this->RatingAge = $this->_db['ratingage'];
				$this->RatingVariant = $this->_db['ratingvariant'];
				$this->RatingDetails = $this->_db['ratingdetails'];
				$this->Casetype = $this->_db['casetype'];
				$this->Slipcover = $this->_db['slipcover'];
				if ($this->_db['srp'] != '0.00') {
					$this->Price = number_format($this->_db['srp'], get_currency_digits($this->_db['srpid']), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->Price = $this->_db['srp'];
				}
				$this->CurrencyID = $this->_db['srpid'];
				$this->convAvgCurrency = $pmp_usecurrency;
				if ( $this->_db['srp'] != '0.00' ) {
					$this->convAvgPrice = number_format(exchange($this->_db['srpid'], $pmp_usecurrency, $this->_db['srp']), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->convAvgPrice = $this->_db['srp'];
				}
				if ($this->_db['gift'] == 1) {
					$this->Gift = true;

					$query = "SELECT * FROM pmp_users WHERE user_id = ?";
					$params = [$this->_db['giftfrom']];
					$result = dbquery_pdo($query, $params);
					$this->GiftFrom = new stdClass();
					$this->GiftFrom->FirstName = $result[0]['firstname'];
					$this->GiftFrom->LastName = $result[0]['lastname'];
					$this->GiftFrom->Email = $result[0]['email'];
					$this->GiftFrom->Phone = $resul[0]['phone'];					
				} else {
					$this->Gift = false;
				}
				$this->Overview = str_replace("&", "&amp;", html_entity_decode($this->_db['overview'], ENT_COMPAT, 'UTF-8'));
				$this->Easteregg  = htmlspecialchars($this->_db['easteregg'], ENT_COMPAT, 'UTF-8');
				$this->LastEdited = strftime($pmp_dateformat, strtotime($this->_db['lastedit']));
				$this->WishPriority = $this->_db['wishpriority'];
				if ($this->_db['purchprice'] != '0.00') {
					$this->PurchPrice = number_format($this->_db['purchprice'], get_currency_digits($this->_db['purchcurrencyid']), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->PurchPrice = $this->_db['purchprice'];
				}
				$this->PurchCurrencyID = $this->_db['purchcurrencyid'];
				$this->ConvCurrency = $pmp_usecurrency;
				if ($this->_db['purchprice'] != '0.00') {
					$this->ConvPrice = number_format(exchange($this->_db['purchcurrencyid'], $pmp_usecurrency, $this->_db['purchprice']), get_currency_digits($pmp_usecurrency), $pmp_dec_point, $pmp_thousands_sep);
				}
				else {
					$this->ConvPrice = $this->_db['purchprice'];
				}
				if ($this->_db['purchdate'] != '0000-00-00') {
					$this->PurchDate = strftime($pmp_dateformat, strtotime($this->_db['purchdate']));
				}
				else {
					$this->PurchDate = '';
				}
				$this->PurchPlace = $this->_db['purchplace'];
				$this->PurchPlaceWebsite = $this->_db['purchwebsite'];
				$this->ReviewFilm = $this->_db['reviewfilm'];
				$this->ReviewAudio = $this->_db['reviewaudio'];
				$this->ReviewVideo = $this->_db['reviewvideo'];
				$this->ReviewExtras = $this->_db['reviewextras'];
				if ($this->_db['loaned'] == 1) {
					$this->Loaned = true;
					$query = "SELECT * FROM pmp_users WHERE user_id = ?";
					$params = [$this->_db['loanedto']];
					$result = dbquery_pdo($query, $params);
					$this->LoanTo = new stdClass();
					$this->LoanTo->FirstName = $result[0]['firstname'];
					$this->LoanTo->LastName = $result[0]['lastname'];
					$this->LoanTo->Email = $result[0]['email'];
					$this->LoanTo->Phone = $resul[0]['phone'];
					$this->LoanReturn = @strftime($pmp_dateformat, strtotime($this->_db['loaneddue']));
				} else {
					$this->Loaned = false;
				}
				if ($pmp_html_notes == true) {
					$this->Notices = html_entity_decode($this->_db['notes'], ENT_COMPAT, 'UTF-8');
				}
				else {
					$this->Notices = htmlspecialchars($this->_db['notes'], ENT_COMPAT, 'UTF-8');
				}
				$this->Locality = $this->_db['locality'];
				$this->EPG = $this->_db['epg'];
				$this->Review = $this->_db['review'];

				// Is boxset?
				$query = "SELECT * FROM pmp_boxset LEFT JOIN pmp_film ON pmp_film.id = pmp_boxset.childid
						  WHERE pmp_boxset.id = ? ORDER BY ?";
				$params = [$this->id, $pmp_menue_childs];
				$result = dbquery_pdo($query, $params);

				if (count($result) > 0) {
					$this->Boxset_childs = array();
					foreach ($rows as $row) {
						if ( !empty($row->childid) ) {
							$child = new smallDVD($row->childid);

							if ( !empty($child->id) ) {
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
				$params = [$this->id];
				$result = dbquery_pdo($query, $params);

				if (count($result) > 0) {
					$this->partofBoxset = $result[0]['id'];
				}
				else {
					$this->partofBoxset = false;
				}

				// Check for cover
				$this->frontpic = file_exists(_PMP_REL_PATH.'/cover/'.$this->id.'f.jpg');
				$this->backpic = file_exists(_PMP_REL_PATH.'/cover/'.$this->id.'b.jpg');

				if ( strtolower(get_class($this)) == 'smalldvd' ) {
					unset($this->_db);
				}
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

	/*
	function getOriginFlag() {
		global $pmp_theme;
		$flag = getFlagName($this->Origin);

		if ( empty($flag) ) {
			return '<img src="' . _PMP_REL_PATH  . '/themes/' . $pmp_theme . '/images/flags/Noflag.gif" alt="' . $this->Origin. '" width="20" title="' . $this->Origin . '" />';
		}
		else {
			return '<img src="' . _PMP_REL_PATH  . '/themes/' . $pmp_theme . '/images/flags/' . $flag . '" alt="' . $this->Origin. '" width="20" title="' . $this->Origin . '" />';
		}
	}
	*/

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
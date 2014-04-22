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

class Parser {
	private $values, $actor, $credit, $purchase, $srp, $tag, $review, $loaned, $event, $atr;
	private $tmp, $lastelement, $stack, $startelement, $countdvd, $dvdcount, $tables;
	private $inserts, $epg, $last_actor_id, $last_credit_id;
	private $actor_div, $credit_div, $updinsjmp, $mediabanner;

	function startElement($parser, $name, $attrs) {
		global $atr, $startelement, $stack, $lastelement, $actor, $credit, $collectiontype, $purchase, $srp, $review, $tag, $userlink, $actor_div, $credit_div, $mediabanner;

		$atr = $attrs;
		$stack[] = $name;
		$startelement = $name;

		if ( $name == 'ACTOR' ) {
			$actor[] = array('FIRSTNAME' => maskData($attrs['FIRSTNAME']),
				'MIDDLENAME' => maskData($attrs['MIDDLENAME']),
				'LASTNAME' => maskData($attrs['LASTNAME']),
				'BIRTHYEAR' => maskData($attrs['BIRTHYEAR']),
				'ROLE' => maskData($attrs['ROLE']),
				'CREDITEDAS' => maskData($attrs['CREDITEDAS']),
				'VOICE' => maskData($attrs['VOICE']),
				'UNCREDITED' => maskData($attrs['UNCREDITED']));
		}
		else if ( $name == 'CREDIT' ) {
			$credit[] = array('FIRSTNAME' => maskData($attrs['FIRSTNAME']),
				'MIDDLENAME' => maskData($attrs['MIDDLENAME']),
				'LASTNAME' => maskData($attrs['LASTNAME']),
				'BIRTHYEAR' => maskData($attrs['BIRTHYEAR']),
				'CREDITTYPE' => maskData($attrs['CREDITTYPE']),
				'CREDITSUBTYPE' => maskData($attrs['CREDITSUBTYPE']),
				'CREDITEDAS' => maskData($attrs['CREDITEDAS']));
		}
		else if ( $name == 'COLLECTIONTYPE' ) {
			$collectiontype = maskData($attrs['ISPARTOFOWNEDCOLLECTION']);
		}
		else if ( ($name == 'SRP') && !$srp ) {
			$purchase[][$name] = array('DENOMINATIONTYPE' => maskData($attrs['DENOMINATIONTYPE']),
				'DENOMINATIONDESC' => maskData($attrs['DENOMINATIONDESC']),
				'FORMATTEDVALUE' => maskData($attrs['FORMATTEDVALUE']));
			$srp = true;
		}
		else if ( $name == 'PURCHASEPRICE' ) {
			$purchase[][$name] = array('DENOMINATIONTYPE' => maskData($attrs['DENOMINATIONTYPE']),
				'DENOMINATIONDESC' => maskData($attrs['DENOMINATIONDESC']),
				'FORMATTEDVALUE' => maskData($attrs['FORMATTEDVALUE']));
		}
		else if ( $name == 'REVIEW' ) {
			$review = array('FILM' => maskData($attrs['FILM']),
				'VIDEO' => maskData($attrs['VIDEO']),
				'AUDIO' => maskData($attrs['AUDIO']),
				'EXTRAS' => maskData($attrs['EXTRAS']));
		}
		else if ( $name == 'MEDIABANNERS' ) {
			$mediabanner = array('FRONT' => maskData($attrs['FRONT']),
				'BACK' => maskData($attrs['BACK']));
		}
		else if ( $name == 'TAG' ) {
			$tag[] = array('NAME' => maskData($attrs['NAME']),
				'FULLNAME' => maskData($attrs['FULLNAME']));
		}
		else if ( $name == 'USERLINK' ) {
			if ( !isset($attrs['SCORE']) ) $attrs['SCORE'] = '';
			$userlink[] = array('URL' => maskData($attrs['URL']),
				'DESCRIPTION' => maskData($attrs['DESCRIPTION']),
				'CATEGORY' => maskData($attrs['CATEGORY']),
				'SCORE' => maskData($attrs['SCORE']));
		}

		if ( $name == 'DIVIDER' ) {
			if ( ($lastelement == 'ACTOR') || ($lastelement == 'ACTORS') || ($lastelement == 'DIVIDER' && $actor_div == true) ) {
				$actor[] = array('CAPTION' => maskData($attrs['CAPTION']),
					'TYPE' => maskData(getIsset($attrs['TYPE'])));
				$actor_div = true;
				$credit_div = false;
			}
			else if ( ($lastelement == 'CREDIT') || ($lastelement == 'CREDITS') || ($lastelement == 'DIVIDER' && $credit_div == true) ) {
				$credit[] = array('CAPTION' => maskData($attrs['CAPTION']),
					'TYPE' => maskData(getIsset($attrs['TYPE'])));
				$actor_div = false;
				$credit_div = true;
			}
		}

		$lastelement = $name;
	}

	private function endElement($parser, $name) {
		global $lastelement, $stack, $values, $atr, $loaned, $event, $giftfrom, $countdvd, $tmp;

		$data = $tmp;
		$level = count($stack) - 1;

		// Loan
		if ( ($stack[$level] == 'LOANINFO') && ($lastelement == 'USER') ) {
			$loaned = array('FIRSTNAME' => maskData($atr['FIRSTNAME']),
				'LASTNAME' => maskData($atr['LASTNAME']),
				'EMAILADDRESS' => maskData($atr['EMAILADDRESS']),
				'PHONENUMBER' => maskData($atr['PHONENUMBER']));
		}

		// Events
		if ( ($stack[$level] == 'EVENT') && ($lastelement == 'USER') ) {
			$event[] = array('FIRSTNAME' => maskData($atr['FIRSTNAME']),
			'LASTNAME' => maskData($atr['LASTNAME']),
			'EMAILADDRESS' => maskData($atr['EMAILADDRESS']),
			'PHONENUMBER' => maskData($atr['PHONENUMBER']));
		}

		// Gifts
		if ( ($stack[$level] == 'PURCHASEINFO') && ($lastelement == 'GIFTFROM') && ($values['COLLECTION']['DVD']['PURCHASEINFO']['RECEIVEDASGIFT'][0] !== 'false') ) {
			$giftfrom = array('FIRSTNAME' => maskData($atr['FIRSTNAME']),
			'LASTNAME' => maskData($atr['LASTNAME']),
			'EMAILADDRESS' => maskData($atr['EMAILADDRESS']),
			'PHONENUMBER' => maskData($atr['PHONENUMBER']));
		}

		// End of DVD
		if ( $countdvd == 2 ) {
			$countdvd = 0;
			$this->nextDVD();
		}

		if ( $name == 'DVD' ) {
			$countdvd++;
		}

		if ( trim($data) != null ) {
			$tmp = maskData(trim($data));

			if ( $level == 0 ) {
				$values[$stack[0]][] = $tmp;
			}
			else if ( $level == 1 ) {
				$values[$stack[0]][$stack[1]][] = $tmp;
			}
			else if ( $level == 2 ) {
				$values[$stack[0]][$stack[1]][$stack[2]][] = $tmp;
			}
			else if ( $level == 3 ) {
				$values[$stack[0]][$stack[1]][$stack[2]][$stack[3]][] = $tmp;
			}
			else if ( $level == 4 ) {
				$values[$stack[0]][$stack[1]][$stack[2]][$stack[3]][$stack[4]][] = $tmp;
			}
		}

		array_pop($stack);
		$lastelement = $name;
		$tmp = '';
	}

	private function characterData($parser, $data) {
		global $tmp;

		$tmp .= $data;
	}

	// Custom collections
	private function buildCollectionDB() {
		global $values, $collections, $collectiontype;
		$partofowned = $this->getBoolean($collectiontype);
		$collection = $values['COLLECTION']['DVD']['COLLECTIONTYPE'][0];

		if ( isset( $collections[$collection] ) ) {
			if ( $collections[$collection] != $partofowned ) {
				$collections[$collection] = $partofowned;
				$sql = "UPDATE pmp_collection SET partofowned = ".$partofowned." WHERE collection = '".$collection."';";
				dbexec($sql);
			}
		} else {
			$collections[$collection] = $partofowned;
			$sql = "INSERT INTO pmp_collection (collection, partofowned) VALUES ('".$collection."', '".$partofowned."');";
			dbexec($sql);
		}
	}

	// Film Table
	private function buildMoviesDB() {
		global $values, $review, $purchase, $loaned, $mediabanner, $giftfrom, $inserts, $max_packet;

		if ( !empty($loaned) ) {
			$loanedto = $this->checkUser($loaned['FIRSTNAME'], $loaned['LASTNAME'], $loaned['EMAILADDRESS'], $loaned['PHONENUMBER']);
		}
		else {
			$loanedto = '';
		}
		if ( $values['COLLECTION']['DVD']['PURCHASEINFO']['RECEIVEDASGIFT'][0] !== 'false' ) {
			$giftfrom_userid = $this->checkUser($giftfrom['FIRSTNAME'], $giftfrom['LASTNAME'], $giftfrom['EMAILADDRESS'], $giftfrom['PHONENUMBER']);
		}
		else {
			$giftfrom_userid = '';
		}

		if ( empty($inserts["pmp_film"]) ) {
			$inserts["pmp_film"] = "INSERT INTO pmp_film (id, profiletimestamp, media_dvd, media_hddvd, media_bluray, media_custom, upc, collectionnumber, collectiontype, title, disttrait, originaltitle, prodyear, released, runningtime, ratingsystem, rating, ratingage, ratingvariant, ratingdetails, casetype, slipcover, srp, srpid, srpname, overview, easteregg, sorttitle, lastedit, wishpriority, countas, purchprice, purchdate, purchplace, purchcurrencyid, purchcurrencyname, purchwebsite, gift, giftfrom, reviewfilm, reviewvideo, reviewaudio, reviewextras, loaned, loanedto, loaneddue, notes, locality, epg, banner_front, banner_back) VALUES ";
		}

		$inserts["pmp_film"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
		$inserts["pmp_film"] .= "\"".$this->getDateTime($values['COLLECTION']['DVD']['PROFILETIMESTAMP'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['MEDIATYPES']['DVD'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['MEDIATYPES']['HDDVD'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['MEDIATYPES']['BLURAY'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['MEDIATYPES']['CUSTOMMEDIATYPE'][0])."\",";
		$inserts["pmp_film"] .= "\"".$values['COLLECTION']['DVD']['UPC'][0]."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['COLLECTIONNUMBER'][0])."\",";
		$inserts["pmp_film"] .= "\"".$values['COLLECTION']['DVD']['COLLECTIONTYPE'][0]."\",";
		$inserts["pmp_film"] .= "\"".$values['COLLECTION']['DVD']['TITLE'][0]."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISTTRAIT'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['ORIGINALTITLE'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['PRODUCTIONYEAR'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RELEASED'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RUNNINGTIME'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RATINGSYSTEM'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RATING'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RATINGAGE'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RATINGVARIANT'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['RATINGDETAILS'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['CASETYPE'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['CASESLIPCOVER'][0])."\",";
		$inserts["pmp_film"] .= "\"".$values['COLLECTION']['DVD']['SRP'][0]."\",";
		$inserts["pmp_film"] .= "\"".$purchase[0]['SRP']['DENOMINATIONTYPE']."\",";
		$inserts["pmp_film"] .= "\"".$purchase[0]['SRP']['DENOMINATIONDESC']."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['OVERVIEW'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['EASTEREGGS'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['SORTTITLE'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getDateTime($values['COLLECTION']['DVD']['LASTEDITED'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getPriority($values['COLLECTION']['DVD']['WISHPRIORITY'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['COUNTAS'][0])."\",";
		$inserts["pmp_film"] .= "\"".$values['COLLECTION']['DVD']['PURCHASEINFO']['PURCHASEPRICE'][0]."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['PURCHASEINFO']['PURCHASEDATE'][0])."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['PURCHASEINFO']['PURCHASEPLACE'][0])."\",";
		$inserts["pmp_film"] .= "\"".$purchase[1]['PURCHASEPRICE']['DENOMINATIONTYPE']."\",";
		$inserts["pmp_film"] .= "\"".$purchase[1]['PURCHASEPRICE']['DENOMINATIONDESC']."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['PURCHASEINFO']['PURCHASEPLACEWEBSITE'][0])."\",";
		$inserts["pmp_film"] .= $values['COLLECTION']['DVD']['PURCHASEINFO']['RECEIVEDASGIFT'][0].",";
		$inserts["pmp_film"] .= "\"".$giftfrom_userid."\",";
		$inserts["pmp_film"] .= "\"".$review['FILM'][0]."\",";
		$inserts["pmp_film"] .= "\"".$review['VIDEO'][0]."\",";
		$inserts["pmp_film"] .= "\"".$review['AUDIO'][0]."\",";
		$inserts["pmp_film"] .= "\"".$review['EXTRAS'][0]."\",";
		$inserts["pmp_film"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOANINFO']['LOANED'][0])."\",";
		$inserts["pmp_film"] .= "\"".$loanedto."\",";
		$inserts["pmp_film"] .= "\"".getIsset($values['COLLECTION']['DVD']['LOANINFO']['DUE'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getNotes($values['COLLECTION']['DVD']['NOTES'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->getLocation($values['COLLECTION']['DVD']['ID'][0])."\",";
		$inserts["pmp_film"] .= "\"".$this->epg."\",";
		$inserts["pmp_film"] .= "\"".$mediabanner['FRONT']."\",";
		$inserts["pmp_film"] .= "\"".$mediabanner['BACK']."\"),";
		
		if ( isset($inserts["pmp_film"]) && strlen($inserts["pmp_film"]) >= $max_packet ) {
			$this->insertSomeData('pmp_film');
		}
	}

	private function getBoolean(& $value) {
		if ( strtoupper($value) == 'TRUE' ) {
			return 1;
		}
		else {
			return 0;
		}
	}

	private function getDateTime(& $datetime) {
		// Ken uses ISO 8601 date
		if ( $datetime != "" ) {
			return date('Y-m-d H:i:s', strtotime($datetime));
		}
		else {
			return;
		}
	}

	private function getNotes(& $notes) {
		global $review_ids, $video_ids, $max_packet, $values, $inserts, $last_review_id;

		// Get and remove episodeguide indicator from note / Format "<egp=1>"
		if ( preg_match('/epg=1/i', $notes) != 0 ) {
			$this->epg = 1;
			$notes = str_replace("<epg=1>", "", $notes);
		}

		// Un-escape the notes
		$notes = stripslashes($notes);

		// Get and remove ids from notes
		// Also ids are build up as tags, no other tag will be removed
		//
		// Format '<xxx=id /> or <xxx=id>title</xxx> or <xxx number=id /> or <xxx number=id>title</xxx>
		// For now xxx can be for reviews: IMDB, OFDB or ROTTEN
		//                 and for videos: YOUTUBE, VIMEO or MYVIDEO

		if ( preg_match_all( "~\s*<([^=\s]+)(?:\s*number\s*|\s*)=\s*([^>\s]+)\s*(?:>([^<]+)</\\1|/)\s*>\s*~i", $notes, $tag, PREG_SET_ORDER ) ) {
			foreach ($tag as $id) {
				// Is it an review id?
				if ( strtolower($id[1])=='imdb' || strtolower($id[1])=='ofdb' || strtolower($id[1])=='rotten' ) {
					if ( !isset($review_ids) ) {
						$this->getReviewIDs();
					}
					if ( empty($inserts["pmp_reviews_connect"]) ) {
						$inserts["pmp_reviews_connect"] = 'INSERT INTO pmp_reviews_connect (id, review_id, title) VALUES ';
					}
					// Remove id from notes
					if ( !isset($id[3]) ) {
						$notes = trim(preg_replace("~\s*<".$id[1]."(?:\s*number\s*|\s*)=\s*".$id[2]."\s*/\s*>~i", "", $notes));
						$id[3] = 'NULL';
					}
					else {
						$notes = trim(preg_replace("~\s*<".$id[1]."(?:\s*number\s*|\s*)=\s*".$id[2]."\s*>".$id[3]."</".$id[1]."\s*>\s*~i", "", $notes));
						$id[3] = '"'.$id[3].'"';
					}
					// Get real imdb id (tt1234567 can be used as well as 1234567, but we need 1234567)
					if ( strtolower($id[1]) == 'imdb' ) {
						$id[2] = substr($id[2],-7);
					}
					// Get real type (rottentomatoes uses two different reviews: critics and users)
					if ( strtolower($id[1]) == 'rotten' ) {
						$id[1] = 'rotten_c';
					}
					else {
						$id[1] = strtolower($id[1]);
					}
					// Check if id is unknown
					if ( !isset($review_ids[$id[1].$id[2]]) ) {
						$review_ids[$id[1].$id[2]] = ++$last_review_id;
						if ( empty($inserts["pmp_reviews_external"]) ) {
							$inserts["pmp_reviews_external"] = 'INSERT INTO pmp_reviews_external (type, ext_id, lastupdate) VALUES ';
						}
						$inserts["pmp_reviews_external"] .= '("'.$id[1].'","'.$id[2].'","0000-00-00"),';
						// If rottentomatoes, we have to store the users review, too
						if ( $id[1] == 'rotten_c' ) {
							$last_review_id++;
							$inserts["pmp_reviews_external"] .= '("rotten_u","'.$id[2].'","0000-00-00"),';
						}
					}
					$inserts["pmp_reviews_connect"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.$review_ids[$id[1].$id[2]].'",'.$id[3].'),';
					if ($id[1] == 'rotten_c') {
						$inserts["pmp_reviews_connect"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.($review_ids[$id[1].$id[2]]+1).'",'.$id[3].'),';
					}

					if ( isset($inserts["pmp_reviews_external"]) && strlen($inserts["pmp_reviews_external"]) >= $max_packet ){
						$this->insertSomeData('pmp_reviews_external');
					}
					if ( isset($inserts["pmp_reviews_connect"]) && strlen($inserts["pmp_reviews_connect"]) >= $max_packet ) {
						$this->insertSomeData('pmp_reviews_connect');
					}
				}
				// Is it an video id?
				elseif (strtolower($id[1]) == 'youtube' || strtolower($id[1]) == 'vimeo') {
					if ( empty($inserts["pmp_videos"]) ) {
						$inserts["pmp_videos"] = "INSERT INTO pmp_videos (id, type, ext_id, title) VALUES ";
					}
					// Remove id from notes
					if (!isset($id[3])) {
						$notes = trim(preg_replace("~\s*<".$id[1]."(?:\s*number\s*|\s*)=\s*".$id[2]."\s*/\s*>~i", "", $notes));
						$id[3] = 'NULL';
					}
					else {
						$notes = trim(preg_replace("~\s*<".$id[1]."(?:\s*number\s*|\s*)=\s*".$id[2]."\s*>".$id[3]."</".$id[1]."\s*>\s*~i", "", $notes));
						$id[3] = '"'.$id[3].'"';
					}
					$inserts["pmp_videos"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.strtolower($id[1]).'","'.$id[2].'",'.$id[3].'),';

					if ( isset($inserts["pmp_videos"]) && strlen($inserts["pmp_videos"]) >= $max_packet ) {
						$this->insertSomeData('pmp_video_connect');
					}
				}
			}
		}

		// this is used for backwards compatibility reasons only.....
		// Format <IMDB>id</IMDB>
		if ( preg_match_all( "~\s*<IMDB>([^<]+)</\s*IMDB\s*>\s*~i", $notes, $imdb, PREG_SET_ORDER ) ) {
			foreach ($imdb as $id) {
				$notes = trim(preg_replace("~\s*<IMDB>".$id[1]."</\s*IMDB\s*>~i", "", $notes));
				if ( empty($inserts["pmp_reviews_connect"]) ) {
					$inserts["pmp_reviews_connect"] = 'INSERT INTO pmp_reviews_connect (id, review_id, title) VALUES ';
					if ( !isset($review_ids['imdb'.$id[1]]) ) {
						$review_ids['imdb'.$id[1]] = ++$last_review_id;
						if ( empty($inserts["pmp_reviews_external"]) ) {
							$inserts["pmp_reviews_external"] = 'INSERT INTO pmp_reviews_external (type, ext_id, lastupdate) VALUES ';
						}
						$inserts["pmp_reviews_external"] .= '("imdb","'.$id[1].'","0000-00-00"),';
					}
					$inserts["pmp_reviews_connect"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.$review_ids['imdb'.$id[1]].'",NULL),';
				}

				if ( isset($inserts["pmp_reviews_external"]) && strlen($inserts["pmp_reviews_external"]) >= $max_packet ) {
					$this->insertSomeData('pmp_reviews_external');
				}
				if ( isset($inserts["pmp_reviews_connect"]) && strlen($inserts["pmp_reviews_connect"]) >= $max_packet ) {
					$this->insertSomeData('pmp_reviews_connect');
				}
			}
		}

		return mysql_real_escape_string(rtrim($notes,'n'));
	}

	private function getLocation($id) {
		$nr = (int)substr(strrchr($id, '.'), 1);
		
		switch($nr) {
			case 0:  return 'United States'; break;
			case 1:  return 'New Zealand'; break;
			case 2:  return 'Australia'; break;
			case 3:  return 'Canada'; break;
			case 4:  return 'United Kingdom'; break;
			case 5:  return 'Germany'; break;
			case 6:  return 'China'; break;
			case 7:  return 'Former Soviet Union'; break;
			case 8:  return 'France'; break;
			case 9:  return 'Netherlands'; break;
			case 10: return 'Spain'; break;
			case 11: return 'Sweden'; break;
			case 12: return 'Norway'; break;
			case 13: return 'Italy'; break;
			case 14: return 'Denmark'; break;
			case 15: return 'Portugal'; break;
			case 16: return 'Finland'; break;
			case 17: return 'Japan'; break;
			case 18: return 'Korea'; break;
			case 19: return 'Canada (Quebec)'; break;
			case 20: return 'South Africa'; break;
			case 21: return 'Hong Kong'; break;
			case 22: return 'Switzerland'; break;
			case 23: return 'Brazil'; break;
			case 24: return 'Israel'; break;
			case 25: return 'Mexico'; break;
			case 26: return 'Iceland'; break;
			case 27: return 'Indonesia'; break;
			case 28: return 'Taiwan'; break;
			case 29: return 'Poland'; break;
			case 30: return 'Belgium'; break;
			case 31: return 'Turkey'; break;
			case 32: return 'Argentina'; break;
			case 33: return 'Slovakia'; break;
			case 34: return 'Hungary'; break;
			case 35: return 'Singapore'; break;
			case 36: return 'Czech Republic'; break;
			case 37: return 'Malaysia'; break;
			case 38: return 'Thailand'; break;
			case 39: return 'India'; break;
			case 40: return 'Austria'; break;
			case 41: return 'Greece'; break;
			case 42: return 'Vietnam'; break;
			case 43: return 'Philippines'; break;
			case 44: return 'Ireland'; break;
			case 45: return 'Estonia'; break;
			case 46: return 'Romania'; break;
			case 47: return 'Iran'; break;
			case 48: return 'Russia'; break;
			case 49: return 'Chile'; break;
			case 50: return 'Colombia'; break;
			case 51: return 'Peru'; break;
		}
	}

	private function getPriority($priority) {
		$priority = (int)$priority;
		
		switch($priority) {
			case 0: return ''; break;
			case 1: return 'Vague Interest'; break;
			case 2: return 'Like to Have It'; break;
			case 3: return 'Want It'; break;
			case 4: return 'Really Want'; break;
			case 5: return 'Need It'; break;
		}
	}

	// Actors Table
	private function buildActorsDB() {
		global $actor, $values, $inserts, $actor_order, $max_packet;
		$i = 0;

		foreach ( $actor as $key => $value ) {
			if ( empty($inserts["pmp_actors"]) ) {
				$inserts["pmp_actors"] = "INSERT INTO pmp_actors (id, sortorder, actor_id, role, creditedas, voice, uncredited) VALUES ";
			}

			if ( isset($value['FIRSTNAME']) ) {
				if ( $value['BIRTHYEAR'] == '0' ) {
					$value['BIRTHYEAR'] = '';
				}

				// Check if actor exists in common
				$actor_id = $this->checkCommonActor($value['FIRSTNAME'], $value['MIDDLENAME'], $value['LASTNAME'], $value['BIRTHYEAR']);

				$inserts["pmp_actors"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_actors"] .= "\"".$i."\",";
				$inserts["pmp_actors"] .= "\"".$actor_id."\",";
				$inserts["pmp_actors"] .= "\"".$value['ROLE']."\",";
				$inserts["pmp_actors"] .= "\"".$value['CREDITEDAS']."\",";
				$inserts["pmp_actors"] .= "\"".$this->getBoolean($value['VOICE'])."\",";
				$inserts["pmp_actors"] .= "\"".$this->getBoolean($value['UNCREDITED'])."\"),";
			}
			else {
				$inserts["pmp_actors"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_actors"] .= "\"".$i."\",";
				$inserts["pmp_actors"] .= "\"0\",";
				$inserts["pmp_actors"] .= "\"".getIsset($value['TYPE'])."\",";
				$inserts["pmp_actors"] .= "\"".$value['CAPTION']."\",";
				$inserts["pmp_actors"] .= "\"0\",";
				$inserts["pmp_actors"] .= "\"0\"),";
			}

			$i++;
			
			if ( isset($inserts["pmp_actors"]) && strlen($inserts["pmp_actors"]) >= $max_packet ) {
				$this->insertSomeData('pmp_actors');
			}
		}
	}

	private function checkCommonActor($firstname, $middlename, $lastname, $birthyear) {
		global $common_actors;

		if ( !isset($common_actors) ) {
			$this->getCastAndCrew();
		}

		$fullname = trim($firstname);
		if ( !empty($middlename) ) {
			if ( strlen($fullname) > 0 ) $fullname .=  " ";
			$fullname .= trim($middlename);
		}
		if ( !empty($lastname) ) {
			if ( strlen($fullname) >0 ) $fullname .=  " ";
			$fullname .= trim($lastname);
		}

		if ( !empty($common_actors[stripslashes($fullname.$birthyear)]) ) {
			return $common_actors[stripslashes($fullname.$birthyear)];
		} else {
			$actor_id = $this->buildCommonActorsDB($firstname, $middlename, $lastname, $fullname, $birthyear);
			$common_actors[stripslashes($fullname.$birthyear)] = $actor_id;
			return $actor_id;
		}
	}

	private function buildCommonActorsDB($firstname, $middlename, $lastname, $fullname, $birthyear) {
		global $inserts, $max_packet;

		$this->last_actor_id++;

		if (empty($inserts['pmp_common_actors'])) {
			$inserts ['pmp_common_actors'] = "INSERT INTO pmp_common_actors (actor_id, firstname, middlename, lastname, fullname, birthyear) VALUES ";
		}
		$inserts['pmp_common_actors'] .= "(\"".$this->last_actor_id."\",";
		$inserts['pmp_common_actors'] .= "\"".$firstname."\",";
		$inserts['pmp_common_actors'] .= "\"".$middlename."\",";
		$inserts['pmp_common_actors'] .= "\"".$lastname."\",";
		$inserts['pmp_common_actors'] .= "\"".$fullname."\",";
		$inserts['pmp_common_actors'] .= "\"".$birthyear."\"),";

		if ( isset($inserts["pmp_common_actors"]) && strlen($inserts["pmp_common_actors"]) >= $max_packet ) {
			$this->insertSomeData('pmp_common_actors');
		}

		return $this->last_actor_id;
	}

	// Credits Table
	private function buildCreditsDB() {
		global $credit, $values, $inserts, $max_packet;
		$i = 0;

		foreach ( $credit as $key => $value ) {
			if ( empty($inserts["pmp_credits"]) ) {
				$inserts["pmp_credits"] = "INSERT INTO pmp_credits (id, sortorder, credit_id, type, subtype, creditedas) VALUES ";
			}

			if ( isset($value['FIRSTNAME']) ) {
				if ( $value['BIRTHYEAR'] == '0' ) {
					$value['BIRTHYEAR'] = '';
				}

				// Check if actor exists in common
				$credit_id = $this->checkCommonCredit($value['FIRSTNAME'], $value['MIDDLENAME'], $value['LASTNAME'], $value['BIRTHYEAR']);

				$inserts["pmp_credits"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_credits"] .= "\"".$i."\",";
				$inserts["pmp_credits"] .= "\"".$credit_id."\",";
				$inserts["pmp_credits"] .= "\"".$value['CREDITTYPE']."\",";
				$inserts["pmp_credits"] .= "\"".$value['CREDITSUBTYPE']."\",";
				$inserts["pmp_credits"] .= "\"".$value['CREDITEDAS']."\"),";
			}
			else if ( $value['CAPTION'] != null ) {
				$inserts["pmp_credits"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_credits"] .= "\"".$i."\",";
				$inserts["pmp_credits"] .= "\"0\",";
				$inserts["pmp_credits"] .= "\"".getIsset($value['TYPE'])."\",";
				$inserts["pmp_credits"] .= "\"\",";
				$inserts["pmp_credits"] .= "\"".$value['CAPTION']."\"),";
			}

			$i++;

			if ( isset($inserts["pmp_credits"]) && strlen($inserts["pmp_credits"]) >= $max_packet ) {
				$this->insertSomeData('pmp_credits');
			}
		}
	}

	private function checkCommonCredit($firstname, $middlename, $lastname, $birthyear) {
		global $common_credits;

		if ( !isset($common_credits) ) {
			$this->getCastAndCrew();
		}

		$fullname = trim($firstname);
		if ( !empty($middlename) ) {
			if ( strlen($fullname) > 0 ) $fullname .=  " ";
			$fullname .= trim($middlename);
		}
		if ( !empty($lastname) ) {
			if ( strlen($fullname) >0 ) $fullname .=  " ";
			$fullname .= trim($lastname);
		}

		if ( !empty($common_credits[stripslashes($fullname.$birthyear)]) ) {
			return $common_credits[stripslashes($fullname.$birthyear)];
		} else {
			$credit_id = $this->buildCommonCreditsDB($firstname, $middlename, $lastname, $fullname, $birthyear);
			$common_credits[stripslashes($fullname.$birthyear)] = $credit_id;
			return $credit_id;
		}
	}

	private function buildCommonCreditsDB($firstname, $middlename, $lastname, $fullname, $birthyear) {
		global $inserts, $max_packet;

		$this->last_credit_id++;

		if (empty($inserts['pmp_common_credits'])) {
			$inserts['pmp_common_credits'] = "INSERT INTO pmp_common_credits (credit_id, firstname, middlename, lastname, fullname, birthyear) VALUES ";
		}
		$inserts['pmp_common_credits'] .= "(\"".$this->last_credit_id."\",";
		$inserts['pmp_common_credits'] .= "\"".$firstname."\",";
		$inserts['pmp_common_credits'] .= "\"".$middlename."\",";
		$inserts['pmp_common_credits'] .= "\"".$lastname."\",";
		$inserts['pmp_common_credits'] .= "\"".$fullname."\",";
		$inserts['pmp_common_credits'] .= "\"".$birthyear."\"),";

		if ( isset($inserts["pmp_common_credits"]) && strlen($inserts["pmp_common_credits"]) >= $max_packet ) {
			$this->insertSomeData('pmp_common_credits');
		}

		return $this->last_credit_id;
	}

	private function checkUser($firstname, $lastname, $email, $phone) {
		global $users;

		if ( !isset($users) ) $this->getUsers();

		$fullname = trim($firstname);
		if ( !empty($lastname) ) {
			if ( strlen($fullname) >0 ) $fullname .=  " ";
			$fullname .= trim($lastname);
		}

		if ( empty($fullname) ) return false;

		if ( !empty($users[$fullname]) ) {
			if ( $users[$fullname]['email'] != $email || $users[$fullname]['phone'] != $phone ) {
				$users[$fullname] = array( 'id' => $users[$fullname]['id'], 'email' => $email, 'phone' => $phone);
				$sql = "UPDATE pmp_users SET email = '".$email."', phone = '".$phone."' WHERE id = '".$users[$fullname]['id']."';";
				dbexec($sql);
			}
			return $users[$fullname]['id'];
		} else {
			$user_id = $this->buildUsersDB($firstname, $lastname, $email, $phone);
			$users[$fullname] = array( 'id' => $user_id, 'email' => $email, 'phone' => $phone);
			return $user_id;
		}
	}

	private function buildUsersDB($firstname, $lastname, $email, $phone) {
		$this->last_user_id++;

		$sql = "INSERT INTO pmp_users (user_id, firstname, lastname, email, phone) VALUES ";
		$sql .= "(".$this->last_user_id.",";
		$sql .= "\"".$firstname."\",";
		$sql .= "\"".$lastname."\",";
		$sql .= "\"".$email."\",";
		$sql .= "\"".$phone."\")";
		dbexec($sql);

		return $this->last_user_id;
	}

	// Countries of Origin Table
	private function buildOriginsDB() {
		global $tag, $values, $inserts, $max_packet;
	
		if ( empty($inserts["pmp_countries_of_origin"]) ) {
			$inserts["pmp_countries_of_origin"] = "INSERT INTO pmp_countries_of_origin (id, country) VALUES ";
		}

		$inserts["pmp_countries_of_origin"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
		$inserts["pmp_countries_of_origin"] .= "\"".getIsset($values['COLLECTION']['DVD']['COUNTRYOFORIGIN'][0])."\"),";

		if ( getIsset($values['COLLECTION']['DVD']['COUNTRYOFORIGIN2'][0]) ) {
			$inserts["pmp_countries_of_origin"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
			$inserts["pmp_countries_of_origin"] .= "\"".getIsset($values['COLLECTION']['DVD']['COUNTRYOFORIGIN2'][0])."\"),";
		}
		if ( getIsset($values['COLLECTION']['DVD']['COUNTRYOFORIGIN3'][0]) ) {
			$inserts["pmp_countries_of_origin"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
			$inserts["pmp_countries_of_origin"] .= "\"".getIsset($values['COLLECTION']['DVD']['COUNTRYOFORIGIN3'][0])."\"),";
		}
	
		if ( isset($inserts["pmp_countries_of_origin"]) && strlen($inserts["pmp_countries_of_origin"]) >= $max_packet ) {
			$this->insertSomeData('pmp_countries_of_origin');
		}
	}

	// Features Table
	private function buildFeaturesDB() {
		global $tag, $values, $inserts, $max_packet;

		if ( empty($inserts["pmp_features"]) ) {
			$inserts["pmp_features"] = "INSERT INTO pmp_features (id, sceneaccess, comment, trailer, bonustrailer, gallery, deleted, makingof, prodnotes, game, dvdrom, multiangle, musicvideos, interviews, storyboard, outtakes, closedcaptioned, thx, pip, bdlive, digitalcopy, other) VALUES ";
		}

		$inserts["pmp_features"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURESCENEACCESS'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURECOMMENTARY'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURETRAILER'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREBONUSTRAILER'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREPHOTOGALLERY'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREDELETEDSCENES'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREMAKINGOF'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREPRODUCTIONNOTES'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREGAME'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREDVDROMCONTENT'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREMULTIANGLE'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREMUSICVIDEOS'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREINTERVIEWS'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURESTORYBOARDCOMPARISONS'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREOUTTAKES'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURECLOSEDCAPTIONED'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATURETHXCERTIFIED'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREPIP'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREBDLIVE'][0])."\",";
		$inserts["pmp_features"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FEATURES']['FEATUREDIGITALCOPY'][0])."\",";
		$inserts["pmp_features"] .= "\"".getIsset($values['COLLECTION']['DVD']['FEATURES']['OTHERFEATURES'][0])."\"),";
		
		if ( isset($inserts["pmp_features"]) && strlen($inserts["pmp_features"]) >= $max_packet ) {
			$this->insertSomeData('pmp_features');
		}
	}

	// Format Table
	private function buildFormatDB() {
		global $tag, $values, $inserts, $max_packet;

		if ( empty($inserts["pmp_format"]) ) {
			$inserts["pmp_format"] = "INSERT INTO pmp_format (id, ratio, video, clrcolor, clrblackandwhite, clrcolorized, clrmixed, panandscan, fullframe, widescreen, anamorph, dualside, duallayer, dim2d, anaglyph, bluray3d) VALUES ";
		}

		$inserts["pmp_format"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
		$inserts["pmp_format"] .= "\"".getIsset($values['COLLECTION']['DVD']['FORMAT']['FORMATASPECTRATIO'][0])."\",";
		$inserts["pmp_format"] .= "\"".getIsset($values['COLLECTION']['DVD']['FORMAT']['FORMATVIDEOSTANDARD'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['COLORFORMAT']['CLRCOLOR'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['COLORFORMAT']['CLRBLACKANDWHITE'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['COLORFORMAT']['CLRCOLORIZED'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['COLORFORMAT']['CLRMIXED'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMATPANANDSCAN'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMATFULLFRAME'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMATLETTERBOX'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMAT16X9'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMATDUALSIDED'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['FORMATDUALLAYERED'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['DIMENSIONS']['DIM2D'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['DIMENSIONS']['DIM3DANAGLYPH'][0])."\",";
		$inserts["pmp_format"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['FORMAT']['DIMENSIONS']['DIM3DBLURAY'][0])."\"),";
		
		if ( isset($inserts["pmp_format"]) && strlen($inserts["pmp_format"]) >= $max_packet ) {
			$this->insertSomeData('pmp_format');
		}
	}

	// Locks Table
	private function buildLocksDB() {
		global $tag, $values, $inserts, $max_packet;

		if ( isset($values['COLLECTION']['DVD']['LOCKS']) ) {
			if ( empty($inserts["pmp_locks"]) ) {
				$inserts["pmp_locks"] = "INSERT INTO pmp_locks (id, lockentire, lockcovers, locktitle, lockmedia, lockoverview, lockregions, lockgenres, locksrp, lockstudios, lockdiscinfo, lockcast, lockcrew, lockfeatures, lockaudio, locksubtitles, lockeastereggs, lockrunningtime, lockreleasedate, lockprodyear, lockcasetype, lockvideoformat, lockrating) VALUES ";
			}

			$inserts["pmp_locks"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['ENTIRE'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['COVERS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['TITLE'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['MEDIATYPE'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['OVERVIEW'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['REGIONS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['GENRES'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['SRP'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['STUDIOS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['DISCINFORMATION'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['CAST'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['CREW'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['FEATURES'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['AUDIOTRACKS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['SUBTITLES'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['EASTEREGGS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['RUNNINGTIME'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['RELEASEDATE'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['PRODUCTIONYEAR'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['CASETYPE'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['VIDEOFORMATS'][0])."\",";
			$inserts["pmp_locks"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['LOCKS']['RATING'][0])."\"),";
		}

		if ( isset($inserts["pmp_locks"]) && strlen($inserts["pmp_locks"]) >= $max_packet ) {
			$this->insertSomeData('pmp_locks');
		}
    }

	// Tags Table
	private function buildTagsDB() {
		global $tag, $values, $inserts, $max_packet;

		foreach ( $tag as $key => $value ) {
			if ( ($value['NAME'] != null) || ($value['FULLNAME'] != null) ) {
				if ( empty($inserts["pmp_tags"]) ) {
					$inserts["pmp_tags"] = "INSERT INTO pmp_tags (id, name, fullname) VALUES ";
				}

				$inserts["pmp_tags"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_tags"] .= "\"".$value['NAME']."\",";
				$inserts["pmp_tags"] .= "\"".$value['FULLNAME']."\"),";
			}
		}

		if ( isset($inserts["pmp_tags"]) && strlen($inserts["pmp_tags"]) >= $max_packet ) {
			$this->insertSomeData('pmp_tags');
		}
	}

	// MyLinks Table
	private function buildMyLinksDB() {
		global $userlink, $values, $inserts, $max_packet, $review_ids, $last_review_id;

		foreach ( $userlink as $key => $value ) {
			if ( strtolower ( substr ( $value['URL'], 0, 7) ) ) {
				// Insert MyLinks 
				if ( empty($inserts["pmp_mylinks"]) ) {
					$inserts["pmp_mylinks"] = "INSERT INTO pmp_mylinks (id, url, description, category, score) VALUES ";
				}
				// Encode category
				if ( $value['CATEGORY'] == 'Official Websites' ) {
					$category = '1';
				} elseif ( $value['CATEGORY'] == 'Fan Sites' ) {
					$category = '2';
				} elseif ( $value['CATEGORY'] == 'Trailers and Clips' ) {
					$category = '3';
				} elseif ( $value['CATEGORY'] == 'Reviews' ) {
					$category = '4';
				} elseif ( $value['CATEGORY'] == 'Ratings' ) {
					$category = '5';
				} elseif ( $value['CATEGORY'] == 'General Information' ) {
					$category = '6';
				} elseif ( $value['CATEGORY'] == 'Games' ) {
					$category = '7';
				} elseif ( $value['CATEGORY'] == 'Other' ) {
					$category = '8';
				} else {
					$category = '9';
				}
				// Get description
				if ( $value['DESCRIPTION'] == '' || $category == '9' ) {
					preg_match ( "~\w+://(?:.*?\.)?([^\.]+)\.([^/]+)/~i", $value['URL'], $tmp);
					$description = $tmp[1].'.'.$tmp[2];
				} else {
					$description = $value['DESCRIPTION'];
				}
				$inserts["pmp_mylinks"] .= "('".$values['COLLECTION']['DVD']['ID'][0]."',";
				$inserts["pmp_mylinks"] .= "'".$value['URL']."',";
				$inserts["pmp_mylinks"] .= "'".$description."',";
				$inserts["pmp_mylinks"] .= "'".$category."',";
				$inserts["pmp_mylinks"] .= "'".$value['SCORE']."'),";

				// Maybe we can use a link for external sources
				$db = '';
				if ( strpos ( strtolower ( $value['URL'] ), 'imdb.com' ) && !strpos ( strtolower ( $value['URL'] ), 'find?q=' ) ) {
					$db = 'imdb';
					$id = substr ( $value['URL'], -8, 7 );
					if ( strtolower ( $value['DESCRIPTION'] ) == 'imdb' ) {
						$title = 'NULL';
					} else {
						$title = '"'.$value['DESCRIPTION'].'"';
					}
				}
				if ( strpos ( strtolower ( $value['URL'] ), 'ofdb.de' ) ) {
					$db = 'ofdb';
					#$id = substr ( $value['URL'], 24, strpos($value['URL'],',')-24 );
					$id = substr ( $value['URL'], 24 );
					if ( strtolower ( $value['DESCRIPTION'] ) == 'ofdb' ) {
						$title = 'NULL';
					} else {
						$title = '"'.$value['DESCRIPTION'].'"';
					}
				}
				if ( strpos ( strtolower ( $value['URL'] ), 'rottentomatoes.com' ) && !strpos ( strtolower ( $value['URL'] ), 'search/?search=' ) ) {
					$db = 'rotten_c';
					$id = substr ( $value['URL'], strrpos ( $value['URL'], '/', -2 ) + 1, -1 );
					if ( strtolower ( $value['DESCRIPTION'] ) == 'rotten tomatoes' ) {
						$title = 'NULL';
					} else {
						$title = '"'.$value['DESCRIPTION'].'"';
					}
				}
				if ( strpos ( strtolower ( $value['URL'] ), 'metacritic.com' ) ) {
					$db = 'metacrit';
					$id = substr ( $value['URL'], strrpos ( $value['URL'], '/', -2 ) + 1 );
					if ( strtolower ( $value['DESCRIPTION'] ) == 'metacritic' ) {
						$title = 'NULL';
					} else {
						$title = '"'.$value['DESCRIPTION'].'"';
					}
				}
				if ( $db != '' ) {
					if ( !isset($review_ids) ) $this->getReviewIDs();
					if ( empty($inserts["pmp_reviews_connect"]) ) $inserts["pmp_reviews_connect"] = 'INSERT INTO pmp_reviews_connect (id, review_id, title) VALUES ';
					// Check if id is unknown
					if ( !isset($review_ids[$db.$id]) ) {
						$review_ids[$db.$id] = ++$last_review_id;
						if ( empty($inserts["pmp_reviews_external"]) ) $inserts["pmp_reviews_external"] = 'INSERT INTO pmp_reviews_external (type, ext_id, lastupdate) VALUES ';
						$inserts["pmp_reviews_external"] .= '("'.$db.'","'.$id.'","0000-00-00"),';
						// If rottentomatoes, we have to store the users review, too
						if ( $db == 'rotten_c' ) {
							$last_review_id++;
							$inserts["pmp_reviews_external"] .= '("rotten_u","'.$id.'","0000-00-00"),';
						}
					}
					$inserts["pmp_reviews_connect"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.$review_ids[$db.$id].'",'.$title.'),';
					if ($id[1] == 'rotten_c') $inserts["pmp_reviews_connect"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.($review_ids[$db.$id]+1).'",'.$title.'),';

					if ( isset($inserts["pmp_reviews_external"]) && strlen($inserts["pmp_reviews_external"]) >= $max_packet ) $this->insertSomeData('pmp_reviews_external');
					if ( isset($inserts["pmp_reviews_connect"]) && strlen($inserts["pmp_reviews_connect"]) >= $max_packet ) $this->insertSomeData('pmp_reviews_connect');
				}
				$db = '';
				if ( strpos ( strtolower ( $value['URL'] ), 'youtube.com' ) || strpos ( strtolower ( $value['URL'] ), 'youtu.be' ) ) {
					$db = 'youtube';
					$id = substr ( $value['URL'], -11 );
					if ( strtolower ( $value['DESCRIPTION'] ) == 'youtube' ) {
						$title = 'NULL';
					} else {
						$title = '"'.$value['DESCRIPTION'].'"';
					}
				}
				if ( $db != '' ) {
					if ( empty($inserts["pmp_videos"]) ) $inserts["pmp_videos"] = "INSERT INTO pmp_videos (id, type, ext_id, title) VALUES ";
					$inserts["pmp_videos"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.$db.'","'.$id.'",'.$title.'),';

					if ( isset($inserts["pmp_videos"]) && strlen($inserts["pmp_videos"]) >= $max_packet ) $this->insertSomeData('pmp_video_connect');
				}
			}
		}

		if ( isset($inserts["pmp_mylinks"]) && strlen($inserts["pmp_mylinks"]) >= $max_packet ) $this->insertSomeData('pmp_mylinks');
	}

	// Audio Table
	private function buildAudioDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['AUDIO']['AUDIOTRACK']['AUDIOCONTENT'][$i]) ) {
				if ( empty($inserts["pmp_audio"]) ) {
					$inserts["pmp_audio"] = "INSERT INTO pmp_audio (id, content, format, channels) VALUES ";
				}

				$inserts["pmp_audio"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_audio"] .= "\"".$values['COLLECTION']['DVD']['AUDIO']['AUDIOTRACK']['AUDIOCONTENT'][$i]."\",";
				$inserts["pmp_audio"] .= "\"".getIsset($values['COLLECTION']['DVD']['AUDIO']['AUDIOTRACK']['AUDIOFORMAT'][$i])."\",";
				$inserts["pmp_audio"] .= "\"".getIsset($values['COLLECTION']['DVD']['AUDIO']['AUDIOTRACK']['AUDIOCHANNELS'][$i])."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_audio"]) && strlen($inserts["pmp_audio"]) >= $max_packet ) {
			$this->insertSomeData('pmp_audio');
		}
	}

	// Subtitles Table
	private function buildSubtitleDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['SUBTITLES']['SUBTITLE'][$i]) ) {
				if ( empty($inserts["pmp_subtitles"]) ) {
					$inserts["pmp_subtitles"] = "INSERT INTO pmp_subtitles (id, subtitle) VALUES ";
				}

				$inserts["pmp_subtitles"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_subtitles"] .= "\"".$values['COLLECTION']['DVD']['SUBTITLES']['SUBTITLE'][$i]."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_subtitles"]) && strlen($inserts["pmp_subtitles"]) >= $max_packet ) {
			$this->insertSomeData('pmp_subtitles');
		}
	}

	// Discs Table
	private function buildDiscsDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['DISCS']['DISC']['DESCRIPTIONSIDEA'][$i]) ) {
				if ( empty($inserts["pmp_discs"]) ) {
					$inserts["pmp_discs"] = "INSERT INTO pmp_discs (id, descsidea, descsideb, discidsidea, discidsideb, labelsidea, labelsideb, duallayersidea, duallayersideb, dualsided, location, slot) VALUES ";
				}

				$inserts["pmp_discs"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['DESCRIPTIONSIDEA'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['DESCRIPTIONSIDEB'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['DISCIDSIDEA'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['DISCIDSIDEB'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['LABELSIDEA'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['LABELSIDEB'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['DISCS']['DISC']['DUALLAYEREDSIDEA'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['DISCS']['DISC']['DUALLAYEREDSIDEB'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".$this->getBoolean($values['COLLECTION']['DVD']['DISCS']['DISC']['DUALSIDED'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['LOCATION'][$i])."\",";
				$inserts["pmp_discs"] .= "\"".getIsset($values['COLLECTION']['DVD']['DISCS']['DISC']['SLOT'][$i])."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_discs"]) && strlen($inserts["pmp_discs"]) >= $max_packet ) {
			$this->insertSomeData('pmp_discs');
		}
	}

	// Events Table
	private function buildEventsDB() {
		global $values, $event, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['EVENTS']['EVENT']['EVENTTYPE'][$i]) ) {
				if ( empty($inserts["pmp_events"]) ) {
					$inserts["pmp_events"] = "INSERT INTO pmp_events (id, eventtype, timestamp, note, user_id) VALUES ";
				}

				$user_id = $this->checkUser($event[$i]['FIRSTNAME'], $event[$i]['LASTNAME'], $event[$i]['EMAILADDRESS'], $event[$i]['PHONENUMBER']);

				$inserts["pmp_events"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_events"] .= "\"".$values['COLLECTION']['DVD']['EVENTS']['EVENT']['EVENTTYPE'][$i]."\",";
				$inserts["pmp_events"] .= "\"".$this->getDateTime($values['COLLECTION']['DVD']['EVENTS']['EVENT']['TIMESTAMP'][$i])."\",";
				if ( !isset($values['COLLECTION']['DVD']['EVENTS']['EVENT']['NOTE'][$i]) ) $values['COLLECTION']['DVD']['EVENTS']['EVENT']['NOTE'][$i] = '';
				$inserts["pmp_events"] .= "\"".$values['COLLECTION']['DVD']['EVENTS']['EVENT']['NOTE'][$i]."\",";
				if ( $user_id !== false ) {
					$inserts["pmp_events"] .= "\"".$user_id."\"),";
				} else {
					$inserts["pmp_events"] .= "NULL),";
				}
				unset ($user_id);
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_events"]) && strlen($inserts["pmp_events"]) >= $max_packet ) {
			$this->insertSomeData('pmp_events');
		}
	}

	// Genres Table
	private function buildGenresDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['GENRES']['GENRE'][$i]) ) {
				if ( empty($inserts["pmp_genres"]) ) {
					$inserts["pmp_genres"] = "INSERT INTO pmp_genres (id, genre) VALUES ";
				}

				$inserts["pmp_genres"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_genres"] .= "\"".$values['COLLECTION']['DVD']['GENRES']['GENRE'][$i]."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_genres"]) && strlen($inserts["pmp_genres"]) >= $max_packet ) {
			$this->insertSomeData('pmp_genres');
		}
	}

	// Regions Table
	private function buildRegionsDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['REGIONS']['REGION'][$i]) ) {
				if ( empty($inserts["pmp_regions"]) ) {
					$inserts["pmp_regions"] = "INSERT INTO pmp_regions (id, region) VALUES ";
				}

				$inserts["pmp_regions"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_regions"] .= "\"".$values['COLLECTION']['DVD']['REGIONS']['REGION'][$i]."\"),";

				$i++;
			}
			else {
				if ( $i == 0 ) {
					if ( empty($inserts["pmp_regions"]) ) {
						$inserts["pmp_regions"] = "INSERT INTO pmp_regions (id, region) VALUES ";
					}

					$inserts["pmp_regions"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
					$inserts["pmp_regions"] .= "\"0\"),";
				}

				$run = false;
			}
		}

		if ( isset($inserts["pmp_regions"]) && strlen($inserts["pmp_regions"]) >= $max_packet ) {
			$this->insertSomeData('pmp_regions');
		}
	}

	// Studios Table
	private function buildStudiosDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['STUDIOS']['STUDIO'][$i]) ) {
				if ( empty($inserts["pmp_studios"]) ) {
					$inserts["pmp_studios"] = "INSERT INTO pmp_studios (id, studio) VALUES ";
				}

				$inserts["pmp_studios"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_studios"] .= "\"".$values['COLLECTION']['DVD']['STUDIOS']['STUDIO'][$i]."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_studios"]) && strlen($inserts["pmp_studios"]) >= $max_packet ) {
			$this->insertSomeData('pmp_studios');
		}
	}

	// Media Companies Table
	private function buildMediaCompaniesDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['MEDIACOMPANIES']['MEDIACOMPANY'][$i]) ) {
				if ( empty($inserts["pmp_media_companies"]) ) {
					$inserts["pmp_media_companies"] = "INSERT INTO pmp_media_companies (id, company) VALUES ";
				}

				$inserts["pmp_media_companies"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_media_companies"] .= "\"".$values['COLLECTION']['DVD']['MEDIACOMPANIES']['MEDIACOMPANY'][$i]."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_media_companies"]) && strlen($inserts["pmp_media_companies"]) >= $max_packet ) {
			$this->insertSomeData('pmp_media_companies');
		}
	}

	// Boxset Table
	private function buildBoxsetDB() {
		global $values, $inserts, $max_packet;
		$run = true;
		$i = 0;

		while ( $run ) {
			if ( isset($values['COLLECTION']['DVD']['BOXSET']['CONTENTS']['CONTENT'][$i]) ) {
				if ( empty($inserts["pmp_boxset"]) ) {
					$inserts["pmp_boxset"] = "INSERT INTO pmp_boxset (id, childid) VALUES ";
				}

				$inserts["pmp_boxset"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
				$inserts["pmp_boxset"] .= "\"".$values['COLLECTION']['DVD']['BOXSET']['CONTENTS']['CONTENT'][$i]."\"),";
			}
			else {
				$run = false;
			}

			$i++;
		}

		if ( isset($inserts["pmp_boxset"]) && strlen($inserts["pmp_boxset"]) >= $max_packet ) {
			$this->insertSomeData('pmp_boxset');
		}
	}

	// Build unique hash for dvd set and make an update check
	private function buildHash() {
		global $values, $inserts, $pmp_parser_mode, $hashs, $max_packet, $deletes, $tag, $review, $purchase, $actor, $credit, $collectiontype, $userlink;

		$hash = crc32(serialize($values).serialize($tag).serialize($review).serialize($collectiontype).serialize($purchase).serialize($userlink).crc32(serialize($actor)).crc32(serialize($credit)));

		if ( $pmp_parser_mode == 0 || ( isset($hashs[$values['COLLECTION']['DVD']['ID'][0]]) && $hash != $hashs[$values['COLLECTION']['DVD']['ID'][0]]) || !isset($hashs[$values['COLLECTION']['DVD']['ID'][0]]) ) {
			if ($pmp_parser_mode != 0 && isset($hashs[$values['COLLECTION']['DVD']['ID'][0]])) {
				if ( empty($deletes['pmp_hash']) ) {
					$deletes['pmp_hash'] = "DELETE FROM pmp_hash WHERE ";
				}
				$deletes['pmp_hash'] .= "id='".$values['COLLECTION']['DVD']['ID'][0]."' OR ";
			}
			if ( empty($inserts["pmp_hash"]) ) {
				$inserts["pmp_hash"] = "INSERT INTO pmp_hash (id, hash) VALUES ";
			}
			$inserts["pmp_hash"] .= "(\"".$values['COLLECTION']['DVD']['ID'][0]."\",";
			$inserts["pmp_hash"] .= "\"".$hash."\"),";
		
			if ( isset($inserts["pmp_hash"]) && strlen($inserts["pmp_hash"]) >= $max_packet ) {
				$this->insertSomeData('pmp_hash');
			}

			if ( isset($hashs[$values['COLLECTION']['DVD']['ID'][0]]) && $hash != $hashs[$values['COLLECTION']['DVD']['ID'][0]] ) {
				return 2;
			} else {
				return 1;
			}
		}
		else {
			return 0;
		}
	}

	public function cleanDB($emptyDB) {
		global $tables;

		if ( $emptyDB ) {
			foreach ( $tables as $table ) {
				dbexec('TRUNCATE TABLE ' . $table);
			}
			dbexec("INSERT INTO `pmp_collection` ( `collection`, `partofowned`) VALUES ( 'Owned', TRUE ), ( 'Ordered', FALSE ), ( 'Wish List', FALSE )");
		}
	}

	private function cleanProfile() {
		global $values, $profile_tables, $deletes;
	
		foreach ( $profile_tables as $table ) {
			if ( empty($deletes[$table]) )
				$deletes[$table] = "DELETE FROM ".$table." WHERE ";
			$deletes[$table] .= "id='".$values['COLLECTION']['DVD']['ID'][0]."' OR ";
		}
	}

	private function buildTempDB($tmp) {
		global $values, $inserts, $types, $max_packet;

		if (empty($inserts["pmp_temptable"])) {
			$inserts["pmp_temptable"] = 'INSERT INTO pmp_temptable (`id`, `type`) VALUES ';
		}
		$inserts["pmp_temptable"] .= '("'.$values['COLLECTION']['DVD']['ID'][0].'","'.$types[$tmp].'"),';
		
		if ( isset($inserts["pmp_temptable"]) && strlen($inserts["pmp_temptable"]) >= $max_packet ) {
			$this->insertSomeData('pmp_temptable');
		}
	}

	private function nextDVD() {
		global $dvdcount, $pmp_parser_mode, $added, $pmp_splitxmlafter;

		$tmp = $this->buildHash();

		if ( $pmp_parser_mode != 0 ) {
			// Build a table with all IDs inside parsed XML to recognise deleted profiles
			$this->buildTempDB($tmp);
		}

		// 2 means updated profile, so delete all old data concerning this profile
		if ( $tmp == 2 ) {
			$this->cleanProfile();
		}

		// 0 means old & non-updated profile, so there's nothing to do
		if ( $tmp != 0 ) {
			$this->buildCollectionDB();
			$this->buildMoviesDB();
			$this->buildActorsDB();
			$this->buildCreditsDB();
			$this->buildOriginsDB();
			$this->buildFeaturesDB();
			$this->buildFormatDB();
			$this->buildLocksDB();
			$this->buildTagsDB();
			$this->buildMyLinksDB();
			$this->buildAudioDB();
			$this->buildSubtitleDB();
			$this->buildDiscsDB();
			$this->buildEventsDB();
			$this->buildGenresDB();
			$this->buildRegionsDB();
			$this->buildStudiosDB();
			$this->buildMediaCompaniesDB();
			$this->buildBoxsetDB();
		}

		$this->initalize();
		$dvdcount++;
	}

	private function initalize() {
		global $tmp, $startelement, $values, $atr, $tag, $userlink, $actor, $credit, $purchase, $review, $srp;
		global $loaned, $event, $giftfrom, $actor_order, $actor_div, $credit_div;

		$tmp = '';
		$startelement = '';
		$values = array();
		$actor = array();
		$credit = array();
		$review = array();
		$purchase = array();
		$srp = false;
		$loaned = array();
		$event = array();
		$giftfrom = array();
		$atr = array();
		$tag = array();
		$userlink = array();
		$this->epg = 0;
		$actor_div = false;
		$credit_div = false;
	}

	public function start($file) {
		global $dvdcount, $inserts, $last_actor_id, $lastelement, $deletes, $added;

		$this->initalize();
		$lastelement = '';
		$countdvd = 0;
		$dvdcount = 0;
		$added = 0;

		$xml_parser = xml_parser_create('UTF-8');
		xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
		xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, false);
		xml_set_object($xml_parser, $this);
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($xml_parser, "characterData");

		if ( !($fp = fopen($file, "r")) ) {
			die('could not open XML input');
		}

		// Get last id's from common tables
		$this->getLastActorId();
		$this->getLastCreditId();
		$this->getLastUserID();

		// It's faster to load some data into an array
		$this->getHashs();
		$this->getCollections();


		while ( $data = fread($fp, 1024) ) {
			if ( !xml_parse($xml_parser, $data, feof($fp)) ) {
				die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
			}
		}

		xml_parser_free($xml_parser);

		$this->insertAllData();

		return $dvdcount;
	}

	private function getHashs() {
		global $hashs;

		$res = dbexec("SELECT * FROM pmp_hash");
		while ( $row=mysql_fetch_object($res) ) {
			$hashs[$row->id] = $row->hash;
		}
	}

	private function getCollections() {
		global $collections;

		$res = dbexec("SELECT * FROM pmp_collection");
		while ( $row=mysql_fetch_object($res) ) {
			$collections[$row->collection] = $row->partofowned;
		}
	}

	private function getCastAndCrew() {
		global $common_actors, $common_credits;

		$res = dbexec("SELECT fullname, birthyear, actor_id FROM pmp_common_actors");
		while ( $row=mysql_fetch_object($res) ) {
			$common_actors[stripslashes($row->fullname.$row->birthyear)] = $row->actor_id;
		}
		$res = dbexec("SELECT fullname, birthyear, credit_id FROM pmp_common_credits");
		while ( $row=mysql_fetch_object($res) ) {
			$common_credits[stripslashes($row->fullname.$row->birthyear)] = $row->credit_id;
		}
	}

	private function getReviewIDs() {
		global $review_ids, $last_review_id;

		$res = dbexec("SELECT id, ext_id, type FROM pmp_reviews_external");
		$last_review_id = mysql_num_rows($res);
		while ( $row=mysql_fetch_object($res) ) {
			if ( $row->type == 'imdb' ) {
				$review_ids[$row->type . substr ( $row->ext_id, 0, 7 )] = $row->id;
			} else {
				$review_ids[$row->type . $row->ext_id] = $row->id;
			}
		}
	}

	private function getUsers() {
		global $users;

		$res = dbexec("SELECT user_id, firstname, lastname, email, phone FROM pmp_users");
		while ( $row=mysql_fetch_object($res) ) {
			$fullname = trim($row->firstname);
			if ( !empty($row->lastname) ) {
				if ( strlen($fullname) >0 ) $fullname .=  " ";
				$fullname .= trim($row->lastname);
			}
			$users[$fullname] = array( 'id' => $row->user_id, 'email' => $row->email, 'phone' => $row->phone);
		}
	}

	private function insertAllData() {
		global $deletes, $inserts;

		// Delete data
		foreach ( $deletes as $sql ) {
			$sql = substr($sql, 0, strlen($sql)-4).';';
			dbexec($sql);
		}

		// Insert data
		foreach ( $inserts as $sql ) {
			$sql[strlen($sql)-1] = ';';
			dbexec($sql);
		}
	}

	private function insertSomeData($table) {
		global $inserts, $deletes;

		if (!empty($deletes[$table])) {
			$sql = substr($deletes[$table], 0, strlen($deletes[$table])-4).';';
			dbexec($sql);
			unset($deletes[$table]);
		}
		
		$sql = substr($inserts[$table], 0, strlen($inserts[$table])-1).';';
		dbexec($sql);
		unset($inserts[$table]);
	}

	private function getLastActorId() {
		// Is needed to find the dividers later in the filmprofile
		$sql  = 'INSERT IGNORE INTO pmp_common_actors (actor_id, firstname, middlename, lastname, fullname, birthyear) ';
		$sql .= 'VALUES (\'0\', \'\', \'\', \'\', \'[DIVIDER]\', \'\')';
		dbexec($sql);

		$sql = 'SELECT MAX(actor_id) as id FROM pmp_common_actors';
		$res = dbexec($sql);
		if ( mysql_num_rows($res) > 0 ) {
			$row = mysql_fetch_object($res);
			$this->last_actor_id = $row->id;
		}
		else {
			$this->last_actor_id = 0;
		}
	}

	private function getLastCreditId() {
		// Is needed to find the dividers later in the filmprofile
		$sql  = 'INSERT IGNORE INTO pmp_common_credits (credit_id, firstname, middlename, lastname, fullname, birthyear) ';
		$sql .= 'VALUES (\'0\', \'\', \'\', \'\', \'[DIVIDER]\', \'\')';
		dbexec($sql);

		$sql = 'SELECT MAX(credit_id) as id FROM pmp_common_credits';
		$res = dbexec($sql);
		if ( mysql_num_rows($res) > 0 ) {
			$row = mysql_fetch_object($res);
			$this->last_credit_id = $row->id;
		}
		else {
			$this->last_credit_id = 0;
		}
	}

	private function getLastUserId() {
		// Is needed to find the dividers later in the filmprofile
		$sql = 'SELECT MAX(user_id) AS id FROM pmp_users';
		$res = dbexec($sql);
		if ( mysql_num_rows($res) > 0 ) {
			$row = mysql_fetch_object($res);
			$this->last_user_id = $row->id;
		}
		else {
			$this->last_user_id = 0;
		}
	}

	public function Parser() {
		global $tables, $profile_tables, $inserts, $hashs, $deletes, $types, $max_packet;

		$tables = array('pmp_film',
			'pmp_actors',
			'pmp_common_actors',
			'pmp_credits',
			'pmp_collection',
			'pmp_common_credits',
			'pmp_users',
			'pmp_countries_of_origin',
			'pmp_features',
			'pmp_format',
			'pmp_locks',
			'pmp_tags',
			'pmp_audio',
			'pmp_subtitles',
			'pmp_discs',
			'pmp_events',
			'pmp_genres',
			'pmp_regions',
			'pmp_studios',
			'pmp_media_companies',
			'pmp_boxset',
			'pmp_hash',
			'pmp_reviews_connect',
			'pmp_videos',
			'pmp_mylinks');

		$profile_tables = array('pmp_film',
			'pmp_actors',
			'pmp_credits',
			'pmp_features',
			'pmp_countries_of_origin',
			'pmp_format',
			'pmp_locks',
			'pmp_tags',
			'pmp_audio',
			'pmp_subtitles',
			'pmp_discs',
			'pmp_events',
			'pmp_genres',
			'pmp_regions',
			'pmp_studios',
			'pmp_media_companies',
			'pmp_boxset',
			'pmp_hash',
			'pmp_reviews_connect',
			'pmp_videos',
			'pmp_mylinks');

		$types = array( 0 => 'unaltered', 1 => 'new', 2 => 'altered' );

		$inserts = array();
		$hashs = array();
		$deletes = array();

		$res = dbexec("SHOW VARIABLES like 'max_allowed_packet'");
		$row = mysql_fetch_object($res);
		$max_packet = $row->Value * .99;
	}

	// Lock tables before inserts, should give some minor speed-up
	public function lockTables() {
		global $tables;
		
		$sql = 'LOCK TABLES ';

		foreach ( $tables as $table ) {
			$sql .= $table . ' WRITE,';
		}

		$sql[strlen($sql)-1] = ';';

		dbexec($sql);
	}

	public function unlockTables() {
		dbexec('UNLOCK TABLES;');
	}
}
?>
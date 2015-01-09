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

require_once('include/smallDVD.class.php');

class DVD extends smallDVD {
	function DVD($id) {
		global $pmp_db, $pmp_dir_cast, $pmp_thousands_sep, $pmp_dec_point, $pmp_extern_reviews, $pmp_dateformat;

		if (isset($id)) {
			$this->smallDVD($id);

			// Features
			$query = 'SELECT * FROM pmp_features WHERE id = ?';
			$params = [$id];
			$row = dbquery_pdo($query, $params, 'object');
			if (count($row) > 0) {
				$this->Scenes = $row[0]->sceneaccess;
				$this->Comment = $row[0]->comment;
				$this->Trailer = $row[0]->trailer;
				$this->BonusTrailer = $row[0]->bonustrailer;
				$this->PhotoGallery = $row[0]->gallery;
				$this->Deleted = $row[0]->deleted;
				$this->MakingOf = $row[0]->makingof;
				$this->Notes = $row[0]->prodnotes;
				$this->Game = $row[0]->game;
				$this->DVDrom = $row[0]->dvdrom;
				$this->Multiangle = $row[0]->multiangle;
				$this->Musicvideos = $row[0]->musicvideos;
				$this->Interviews = $row[0]->interviews;
				$this->Storyboard = $row[0]->storyboard;
				$this->Outtakes = $row[0]->outtakes;
				$this->ClosedCaptioned = $row[0]->closedcaptioned;
				$this->THX = $row[0]->thx;
				$this->PictureInPicture = $row[0]->pip;
				$this->BDLive = $row[0]->bdlive;
				$this->DigitalCopy = $row[0]->digitalcopy;
				$this->Other = htmlspecialchars($row[0]->other, ENT_COMPAT, 'UTF-8');
			}

			// Format
			$query = 'SELECT * FROM pmp_format WHERE id = ?';
			$params = [$id];
			$row = dbquery_pdo($query, $params, 'object');
			if (count($row) > 0) {
				$this->Ratio = $row[0]->ratio;
				$this->Video = $row[0]->video;
				$this->Color = $row[0]->clrcolor;
				$this->BlackWhite = $row[0]->clrblackandwhite;
				$this->Colorized = $row[0]->clrcolorized;
				$this->Mixed = $row[0]->clrmixed;
				$this->PanAndScan = $row[0]->panandscan;
				$this->FullFrame = $row[0]->fullframe;
				$this->Widescreen = $row[0]->widescreen;
				$this->Anamorph = $row[0]->anamorph;
				$this->DualSide = $row[0]->dualside;
				$this->DualLayer = $row[0]->duallayer;
				$this->Dim2D = $row[0]->dim2d;
				$this->Anaglyph = $row[0]->anaglyph;
				$this->Bluray3D = $row[0]->bluray3d;
			}

			// Regioncode
			$query = 'SELECT region FROM pmp_regions WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Regions[] = $row->region;
				}
			}

			// Genres
			$query = 'SELECT genre FROM pmp_genres WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Genres[] = $row->genre;
				}
			}

			// Studios
			$query = 'SELECT studio FROM pmp_studios WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Studios[] = htmlspecialchars($row->studio, ENT_COMPAT, 'UTF-8');
				}
			}

			// Media Companies
			$query = 'SELECT company FROM pmp_media_companies WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->MediaCompanies[] = htmlspecialchars($row->company, ENT_COMPAT, 'UTF-8');
				}
			}

			// Subtitles
			$query = 'SELECT subtitle FROM pmp_subtitles WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Subtitles[] = htmlspecialchars($row->subtitle, ENT_COMPAT, 'UTF-8');
				}
			}

			// Audio
			$query = 'SELECT content, format, channels FROM pmp_audio WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				$this->dd = false;
				$this->dts = false;
				
				foreach ($rows as $row) {
					$this->Audio[] = [
						'Content' => $row->content,
						'Format' => $row->format,
						'Channels' => $row->channels
					];

					if (preg_match('/\bDolby Digital\b/i', $row->format)) {
						$this->dd = true;
					}
					if (preg_match('/\bDTS\b/i', $row->format)) {
						$this->dts = true;
					}
				}
			}

			// Discs
			$query = 'SELECT * FROM pmp_discs WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$row->descsidea = htmlspecialchars($row->descsidea, ENT_COMPAT, 'UTF-8'); 
					$row->descsideb = htmlspecialchars($row->descsideb, ENT_COMPAT, 'UTF-8'); 
					$this->Discs[] = $row;
				}
			}

			// Events
			$query = "SELECT *, DATE_FORMAT(timestamp, '%H:%i:%s') AS time, DATE_FORMAT(timestamp, ?) AS date
					  FROM pmp_events LEFT JOIN pmp_users ON pmp_events.user_id = pmp_users.user_id WHERE id = ?";
			$params = [$pmp_dateformat, $id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Events[] = $row;
				}
			}

			// Credits
			$query  = 'SELECT firstname, middlename, lastname, fullname as full, birthyear, type, subtype, creditedas
					   FROM pmp_common_credits, pmp_credits WHERE pmp_credits.id = ? 
					   AND pmp_credits.credit_id = pmp_common_credits.credit_id ORDER BY sortorder';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$row->full_encoded = rawurlencode($row->full);
					$row->picname = getHeadshot($row->full, $row->birthyear, $row->firstname, $row->middlename, $row->lastname);
					$row->pic = !empty($row->picname);
					$this->Credits[] = $row;
				}
			}

			// Cast
			$query  = 'SELECT firstname, middlename, lastname, fullname as full, birthyear, role, uncredited, voice, creditedas
					   FROM pmp_common_actors, pmp_actors WHERE pmp_actors.id = ?
					   AND pmp_actors.actor_id = pmp_common_actors.actor_id ORDER BY sortorder';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$row->full_encoded = rawurlencode($row->full);
					$row->picname = getHeadshot($row->full, $row->birthyear, $row->firstname, $row->middlename, $row->lastname);
					$row->pic = !empty($row->picname);
					$this->Cast[] = $row;
				}
			}

			// Tags
			$query = 'SELECT name, fullname FROM pmp_tags WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Tags[] = [
						'fullname' => $row->fullname,
						'name' => $row->name
					];
				}
			}

			// Reviews
			$query = "SELECT name, title, email, date_format(date, ?) AS date, text, vote
					  FROM pmp_reviews WHERE film_id = ? and status = 1 ORDER BY date DESC";
			$params = [$pmp_dateformat, $id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Reviews[] = [
						"Name" => $row->name,
						"Title" => $row->title,
						"eMail" => $row->email,
						"Text" => $row->text,
						"Vote" => $row->vote,
						"Date" => $row->date
					];
				}
			}

			// Awards
			if (!$this->OriginalTitle) {
				$query = 'SELECT award, awardyear, category, winner, nominee FROM pmp_awards WHERE LOWER(title) = LOWER(?)
						  AND awardyear BETWEEN ? AND ?+1 ORDER BY award, winner DESC';
				$params = [html_entity_decode($this->Title, ENT_QUOTES, 'UTF-8'), $this->Year, $this->Year];
			}
			else {
				$sql = 'SELECT award, awardyear, category, winner, nominee FROM pmp_awards WHERE LOWER(title) = LOWER(?)
						AND awardyear BETWEEN ? AND ?+1 ORDER BY award, winner DESC';
				$params = [html_entity_decode($this->OriginalTitle, ENT_QUOTES, 'UTF-8'), $this->Year, $this->Year];
			}
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Awards[] = $row;
				}
			}

			// Videos
			$query = 'SELECT type, ext_id, title FROM pmp_videos WHERE id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->Videos[] = $row;
				}
			}

			// Get external reviews
			$i = 0;
			$query = 'SELECT * FROM pmp_reviews_connect LEFT JOIN pmp_reviews_external ON review_id = pmp_reviews_external.id WHERE pmp_reviews_connect.id = ?';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->extReviews[$i] = new stdClass();
					if ($row->type == 'imdb') {
						$this->extReviews[$i]->imdbRating = $row->review;
						$this->extReviews[$i]->imdbVotes = $row->votes;
						$this->extReviews[$i]->imdbTop250 = $row->top250;
						$this->extReviews[$i]->imdbBottom100 = $row->bottom100;
						if (!isset($this->imdbID)) {
							$this->imdbID = $row->ext_id;
						}
					}
					if ($row->type == 'ofdb') {
						$this->extReviews[$i]->ofdbRating = $row->review;
						$this->extReviews[$i]->ofdbVotes = $row->votes;
						$this->extReviews[$i]->ofdbTop250 = $row->top250;
						$this->extReviews[$i]->ofdbBottom100 = $row->bottom100;
						if (!isset($this->ofdbID)) {
							$this->ofdbID = $row->ext_id;
						}
					}
					if ($row->type == 'rotten_c') {
						$this->extReviews[$i]->rotcRating = $row->review;
						$this->extReviews[$i]->rotcVotes = $row->votes;
						if (!isset($this->rottenID)) {
							$this->rottenID = $row->ext_id;
						}
					}
					if ($row->type == 'rotten_u') {
						$this->extReviews[$i]->rotuRating = $row->review;
						$this->extReviews[$i]->rotuVotes = $row->votes;
					}
					$i++;
				}
			}
			if ($i > 0) {
				$this->reviewTitleNum = $i;
			}

			// My Links
			$query = 'SELECT * FROM pmp_mylinks WHERE id = ? ORDER BY category';
			$params = [$id];
			$rows = dbquery_pdo($query, $params, 'object');
			if (count($rows) > 0) {
				foreach ($rows as $row) {
					$this->MyLinks[] = $row;
				}
			}
		}
		else {
			return false;
		}
	}
}
?>
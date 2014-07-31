-- --------------------------------------------------------

--
-- Falls Tabellen schon existieren erst löschen
--

DROP TABLE IF EXISTS `pmp_actors`;
DROP TABLE IF EXISTS `pmp_common_actors`;
DROP TABLE IF EXISTS `pmp_audio`;
DROP TABLE IF EXISTS `pmp_boxset`;
DROP TABLE IF EXISTS `pmp_credits`;
DROP TABLE IF EXISTS `pmp_common_credits`;
DROP TABLE IF EXISTS `pmp_countries_of_origin`;
DROP TABLE IF EXISTS `pmp_discs`;
DROP TABLE IF EXISTS `pmp_events`;
DROP TABLE IF EXISTS `pmp_features`;
DROP TABLE IF EXISTS `pmp_format`;
DROP TABLE IF EXISTS `pmp_genres`;
DROP TABLE IF EXISTS `pmp_locks`;
DROP TABLE IF EXISTS `pmp_film`;
DROP TABLE IF EXISTS `pmp_regions`;
DROP TABLE IF EXISTS `pmp_studios`;
DROP TABLE IF EXISTS `pmp_media_companies`;
DROP TABLE IF EXISTS `pmp_subtitles`;
DROP TABLE IF EXISTS `pmp_tags`;
DROP TABLE IF EXISTS `pmp_statistics`;
DROP TABLE IF EXISTS `pmp_guestbook`;
DROP TABLE IF EXISTS `pmp_news`;
DROP TABLE IF EXISTS `pmp_awards`;
DROP TABLE IF EXISTS `pmp_pictures`;
DROP TABLE IF EXISTS `pmp_rates`;
DROP TABLE IF EXISTS `pmp_reviews`;
DROP TABLE IF EXISTS `pmp_update`;
DROP TABLE IF EXISTS `pmp_counter`;
DROP TABLE IF EXISTS `pmp_counter_profil`;
DROP TABLE IF EXISTS `pmp_imdb`;
DROP TABLE IF EXISTS `pmp_reviews_external`;
DROP TABLE IF EXISTS `pmp_reviews_connect`;
DROP TABLE IF EXISTS `pmp_videos`;
DROP TABLE IF EXISTS `pmp_hash`;
DROP TABLE IF EXISTS `pmp_collection`;
DROP TABLE IF EXISTS `pmp_mylinks`;
DROP TABLE IF EXISTS `pmp_users`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_actors`
--

CREATE TABLE `pmp_actors` (
  `id` varchar(20) NOT NULL,
  `actor_id` int(10) NOT NULL,
  `sortorder` int(5) NOT NULL,
  `role` varchar(100),
  `creditedas` varchar(100),
  `voice` tinyint(1) NOT NULL default '0',
  `uncredited` tinyint(1) NOT NULL default '0',
  INDEX `idx_actors_id` (`id`),
  INDEX `idx_actors_actor_id` (`actor_id`),
  INDEX `idx_actors_creditedas` (`creditedas`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_common_actors`
--

CREATE TABLE `pmp_common_actors` (
  `actor_id` int(10) NOT NULL,
  `firstname` varchar(75),
  `middlename` varchar(75),
  `lastname` varchar(75),
  `fullname` varchar(150),
  `birthyear` varchar(4),
  PRIMARY KEY  (`actor_id`),
  INDEX `idx_com_actors_fullname_birthyear` (`fullname`,`birthyear`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_audio`
--

CREATE TABLE `pmp_audio` (
  `id` varchar(20) NOT NULL,
  `content` varchar(35),
  `format` varchar(45),
  `channels` varchar(45),
  INDEX `idx_audio_id` (`id`),
  INDEX `idx_audio_content` (`content`),
  INDEX `idx_audio_format` (`format`),
  INDEX `idx_audio_channels` (`channels`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_boxset`
--

CREATE TABLE `pmp_boxset` (
  `id` varchar(20) NOT NULL,
  `childid` varchar(20) NOT NULL,
  INDEX `idx_boxset_id` (`id`),
  INDEX `idx_boxset_childid` (`childid`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_credits`
--

CREATE TABLE `pmp_credits` (
  `id` varchar(20) NOT NULL,
  `credit_id` int(10) NOT NULL,
  `sortorder` int(5) NOT NULL,
  `type` varchar(45) NOT NULL,
  `subtype` varchar(45) NOT NULL,
  `creditedas` varchar(100),
  INDEX `idx_credits_id` (`id`),
  INDEX `idx_credits_credit_id` (`credit_id`),
  INDEX `idx_credits_creditedas` (`creditedas`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_common_credits`
--

CREATE TABLE `pmp_common_credits` (
  `credit_id` int(10) NOT NULL,
  `firstname` varchar(75),
  `middlename` varchar(75),
  `lastname` varchar(75),
  `fullname` varchar(150),
  `birthyear` varchar(4),
  PRIMARY KEY  (`credit_id`),
  INDEX `idx_com_credits_fullname_birthyear` (`fullname`,`birthyear`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_countries_of_origin`
--

CREATE TABLE IF NOT EXISTS `pmp_countries_of_origin` (
  `id` varchar(20) NOT NULL,
  `country` varchar(35) DEFAULT NULL,
  KEY `idx_country_of_origin_id` (`id`),
  KEY `idx_country_of_origin` (`country`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_discs`
--

CREATE TABLE `pmp_discs` (
  `id` varchar(20) NOT NULL,
  `descsidea` varchar(65),
  `descsideb` varchar(65),
  `discidsidea` varchar(35),
  `discidsideb` varchar(35),
  `labelsidea` varchar(65),
  `labelsideb` varchar(65),
  `duallayersidea` tinyint(1) NOT NULL default '0',
  `duallayersideb` tinyint(1) NOT NULL default '0',
  `dualsided` tinyint(1) NOT NULL default '0',
  `location` varchar(250),
  `slot` varchar(15),
  INDEX `idx_discs_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_events`
--

CREATE TABLE `pmp_events` (
  `id` varchar(20) NOT NULL,
  `eventtype` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `note` varchar(100),
  `user_id` mediumint,
  INDEX `idx_events_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_features`
--

CREATE TABLE `pmp_features` (
  `id` varchar(20) default NULL,
  `sceneaccess` tinyint(1) NOT NULL default '0',
  `comment` tinyint(1) NOT NULL default '0',
  `trailer` tinyint(1) NOT NULL default '0',
  `bonustrailer` tinyint(1) NOT NULL default '0',
  `gallery` tinyint(1) NOT NULL default '0',
  `deleted` tinyint(1) NOT NULL default '0',
  `makingof` tinyint(1) NOT NULL default '0',
  `prodnotes` tinyint(1) NOT NULL default '0',
  `game` tinyint(1) NOT NULL default '0',
  `dvdrom` tinyint(1) NOT NULL default '0',
  `multiangle` tinyint(1) NOT NULL default '0',
  `musicvideos` tinyint(1) NOT NULL default '0',
  `interviews` tinyint(1) NOT NULL default '0',
  `storyboard` tinyint(1) NOT NULL default '0',
  `outtakes` tinyint(1) NOT NULL default '0',
  `closedcaptioned` tinyint(1) NOT NULL default '0',
  `thx` tinyint(1) NOT NULL default '0',
  `pip` tinyint(1) NOT NULL default '0',
  `bdlive` tinyint(1) NOT NULL default '0',
  `digitalcopy` tinyint(1) NOT NULL default '0',
  `other` varchar(255),
  INDEX `idx_features_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_format`
--

CREATE TABLE `pmp_format` (
  `id` varchar(20) NOT NULL,
  `ratio` varchar(5),
  `video` varchar(5),  
  `clrcolor` tinyint(1) NOT NULL default '0',
  `clrblackandwhite` tinyint(1) NOT NULL default '0',
  `clrcolorized` tinyint(1) NOT NULL default '0',
  `clrmixed` tinyint(1) NOT NULL default '0',
  `panandscan` tinyint(1) NOT NULL default '0',
  `fullframe` tinyint(1) NOT NULL default '0',
  `widescreen` tinyint(1) NOT NULL default '0',
  `anamorph` tinyint(1) NOT NULL default '0',
  `dualside` tinyint(1) NOT NULL default '0',
  `duallayer` tinyint(1) NOT NULL default '0',
  `dim2d` tinyint(1) NOT NULL default '0',
  `anaglyph` tinyint(1) NOT NULL default '0',
  `bluray3d` tinyint(1) NOT NULL default '0',
  INDEX `idx_format_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_genres`
--

CREATE TABLE `pmp_genres` (
  `id` varchar(20) NOT NULL,
  `genre` varchar(45) NOT NULL,
  INDEX `idx_genres_id` (`id`),
  INDEX `idx_genres_genre` (`genre`)
) DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_locks`
--

CREATE TABLE `pmp_locks` (
  `id` varchar(20) NOT NULL,
  `lockentire` tinyint(1) NOT NULL default '0',
  `lockcovers` tinyint(1) NOT NULL default '0',
  `locktitle` tinyint(1) NOT NULL default '0',
  `lockmedia` tinyint(1) NOT NULL default '0',
  `lockoverview` tinyint(1) NOT NULL default '0',
  `lockregions` tinyint(1) NOT NULL default '0',
  `lockgenres` tinyint(1) NOT NULL default '0',
  `locksrp` tinyint(1) NOT NULL default '0',
  `lockstudios` tinyint(1) NOT NULL default '0',
  `lockdiscinfo` tinyint(1) NOT NULL default '0',
  `lockcast` tinyint(1) NOT NULL default '0',
  `lockcrew` tinyint(1) NOT NULL default '0',
  `lockfeatures` tinyint(1) NOT NULL default '0',
  `lockaudio` tinyint(1) NOT NULL default '0',
  `locksubtitles` tinyint(1) NOT NULL default '0',
  `lockeastereggs` tinyint(1) NOT NULL default '0',
  `lockrunningtime` tinyint(1) NOT NULL default '0',
  `lockreleasedate` tinyint(1) NOT NULL default '0',
  `lockprodyear` tinyint(1) NOT NULL default '0',
  `lockcasetype` tinyint(1) NOT NULL default '0',
  `lockvideoformat` tinyint(1) NOT NULL default '0',
  `lockrating` tinyint(1) NOT NULL default '0',
  INDEX `idx_locks_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_film`
--

CREATE TABLE `pmp_film` (
  `id` varchar(20) NOT NULL,
  `locality` varchar(35) NOT NULL,
  `profiletimestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `media_dvd` tinyint(1) NOT NULL,
  `media_hddvd` tinyint(1) NOT NULL,
  `media_bluray` tinyint(1) NOT NULL,
  `media_custom` varchar(35) NOT NULL,
  `upc` varchar(30) NOT NULL,
  `collectionnumber` int(5),
  `collectiontype` varchar(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `disttrait` varchar(150),
  `originaltitle` varchar(150),
  `prodyear` varchar(4),
  `released` date default '0000-00-00',
  `runningtime` bigint(20) NOT NULL,
  `ratingsystem` varchar(45) NOT NULL,
  `rating` varchar(21) NOT NULL,
  `ratingage` tinyint(2) default NULL,
  `ratingvariant` tinyint(1) DEFAULT NULL,
  `ratingdetails` varchar(255) NOT NULL,
  `casetype` varchar(50) NOT NULL,
  `slipcover` tinyint(1) NOT NULL default '0',
  `srpid` char(3) NOT NULL,
  `srpname` varchar(35) NOT NULL,
  `srp` decimal(6,2) NOT NULL default '0.00',
  `overview` longtext,
  `easteregg` longtext,
  `sorttitle` varchar(150) NOT NULL,
  `lastedit` datetime NOT NULL default '0000-00-00 00:00:00',
  `wishpriority` varchar(20),
  `countas` int(4) NOT NULL default '0',
  `purchcurrencyid` char(3) NOT NULL,
  `purchcurrencyname` varchar(25) NOT NULL,
  `purchprice` decimal(6,2) NOT NULL default '0.00',
  `purchplace` varchar(75),
  `purchwebsite` varchar(125),
  `purchdate` date default '0000-00-00',
  `gift` boolean DEFAULT false,
  `giftfrom` mediumint,
  `reviewfilm` smallint(1) NOT NULL,
  `reviewvideo` smallint(1) NOT NULL,
  `reviewaudio` smallint(1) NOT NULL,
  `reviewextras` smallint(1) NOT NULL,
  `loaned` tinyint(1) NOT NULL default '0',
  `loaneddue` date,
  `loanedto` mediumint,
  `notes` text,
  `epg` tinyint(1) NOT NULL default '0',
  `review` decimal(4,2) NULL default NULL,
  `banner_front` varchar(10),
  `banner_back` varchar(10),
  PRIMARY KEY  (`id`),
  INDEX `idx_film_title` (`title`),
  INDEX `idx_film_sorttitle` (`sorttitle`),
  INDEX `idx_film_originaltitle` (`originaltitle`),
  INDEX `idx_film_collectiontype` (`collectiontype`),
  INDEX `idx_film_casetype` (`casetype`),
  INDEX `idx_film_locality` (`locality`),
  INDEX `idx_film_rating` (`rating`),
  INDEX `idx_media_dvd` (`media_dvd`),
  INDEX `idx_media_hddvd` (`media_hddvd`),
  INDEX `idx_media_bluray` (`media_bluray`),
  INDEX `idx_media_custom` (`media_custom`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_regions`
--

CREATE TABLE `pmp_regions` (
  `id` varchar(20) NOT NULL,
  `region` varchar(1) NOT NULL,
  INDEX `idx_regions_id` (`id`),
  INDEX `idx_regions_region` (`region`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_studios`
--

CREATE TABLE `pmp_studios` (
  `id` varchar(20) NOT NULL,
  `studio` varchar(85) NOT NULL,
  INDEX `idx_studios_id` (`id`),
  INDEX `idx_studios_studio` (`studio`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_media_companies`
--

CREATE TABLE `pmp_media_companies` (
  `id` varchar(20) NOT NULL,
  `company` varchar(85) NOT NULL,
  INDEX `idx_media_companies_id` (`id`),
  INDEX `idx_media_companies_company` (`company`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_subtitles`
--

CREATE TABLE `pmp_subtitles` (
  `id` varchar(20) NOT NULL,
  `subtitle` varchar(35) NOT NULL,
  INDEX `idx_subtitles_id` (`id`),
  INDEX `idx_subtitles_subtitle` (`subtitle`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_tags`
--

CREATE TABLE `pmp_tags` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50),
  `fullname` varchar(100),
  INDEX `idx_tags_id` (`id`),
  INDEX `idx_tags_fullname` (`fullname`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_statistics`
--

CREATE TABLE `pmp_statistics` (
  `type` varchar(35) NOT NULL,
  `name` varchar(150),
  `value` varchar(20),
  `data` varchar(20),
  INDEX `idx_statistics_type` (`type`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_guestbook`
--

CREATE TABLE `pmp_guestbook` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `name` varchar(100) NOT NULL,
  `email` varchar(100),
  `url` varchar(100),
  `text` longtext NOT NULL,
  `comment` longtext,
  `status` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_news`
--

CREATE TABLE `pmp_news` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `title` varchar(100) NOT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_awards`
--

CREATE TABLE `pmp_awards` (
  `title` varchar(100) NOT NULL,
  `prodyear` varchar(4),
  `award` varchar(100) NOT NULL,
  `awardyear` varchar(4) NOT NULL,
  `category` varchar(120) NOT NULL,
  `winner` tinyint(1) NOT NULL default '0',
  `nominee` varchar(300) default NULL,
  INDEX `idx_awards_title_prodyear` (`title`,`prodyear`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_pictures`
--

CREATE TABLE `pmp_pictures` (
  `id` bigint(20) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_rates`
--

CREATE TABLE `pmp_rates` (
  `id` varchar(3) NOT NULL,
  `rate` decimal(10,5) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_reviews`
--

CREATE TABLE `pmp_reviews` (
  `id` bigint(20) NOT NULL auto_increment,
  `film_id` varchar(100) NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `title` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100),
  `text` longtext NOT NULL,
  `vote` bigint(20) NOT NULL default '0',
  `status` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX `idx_reviews_film_id` (`film_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_update`
--

CREATE TABLE `pmp_update` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_counter`
--

CREATE TABLE `pmp_counter` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `sid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX`idx_counter_date` (`date`),
  INDEX`idx_counter_sid` (`sid`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_counter_profil`
--

CREATE TABLE `pmp_counter_profil` (
  `id` bigint(20) NOT NULL auto_increment,
  `film_id` varchar(100) NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `sid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX`idx_counter_profil_film_id` (`film_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_reviews_external`
--

CREATE TABLE `pmp_reviews_external` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(8) NOT NULL,
  `ext_id` varchar(150) NOT NULL,
  `review` decimal(4,2) NOT NULL,
  `votes` int(11) NOT NULL,
  `top250` varchar(4) DEFAULT NULL,
  `bottom100` varchar(4) DEFAULT NULL,
  `lastupdate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  INDEX`idx_reviews_external_type` (`type`),
  INDEX`idx_reviews_external_lastupdate` (`lastupdate`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_reviews_connect`
--

CREATE TABLE `pmp_reviews_connect` (
  `id` varchar(20) NOT NULL,
  `review_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  INDEX`idx_reviews_connect_id` (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_video`
--

CREATE TABLE `pmp_videos` (
  `id` varchar(20) NOT NULL,
  `type` varchar(8) NOT NULL,
  `ext_id` varchar(150) NOT NULL,
  `title` varchar(150) DEFAULT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_hash`
--

CREATE TABLE `pmp_hash` (
  `id` varchar(20) NOT NULL,
  `hash` varchar(65) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_collection`
--

CREATE TABLE IF NOT EXISTS `pmp_collection` (
  `collection` varchar(20) NOT NULL UNIQUE,
  `partofowned` boolean NOT NULL DEFAULT TRUE,
  INDEX `idx_collection` (`collection`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_mylinks`
--

CREATE TABLE IF NOT EXISTS `pmp_mylinks` (
  `id` varchar(20) NOT NULL,
  `url` varchar(250) NOT NULL,
  `description` varchar(50) NOT NULL,
  `category` tinyint(1) NOT NULL,
  `score` decimal(5,2),
  INDEX `idx_description` (`description`),
  INDEX `idx_category` (`category`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pmp_users`
--

CREATE TABLE IF NOT EXISTS `pmp_users` (
  `user_id` mediumint PRIMARY KEY AUTO_INCREMENT,
  `firstname` varchar(30),
  `lastname` varchar(30),
  `email` varchar(65),
  `phone` varchar(20),
  INDEX `idx_users_fullname` (`firstname`, `lastname`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

<?php 
// Generated: Wed, 09 Dec 2009 10:48:18 +0100



// Main settings
// =============

// Database server
// 
$pmp_sqlhost = 'localhost';

// Database user
// 
$pmp_sqluser = '';

// Database password
// 
$pmp_sqlpass = '';

// Database name
// 
$pmp_sqldatabase = '';

// Table prefix
// 
$pmp_table_prefix = 'pmp_';



// Basic settings
// ==============

// Administrator's name
// 
$pmp_admin_name = '';

// Administrator's Email
// 
$pmp_admin_mail = '';

// Page title
// 
$pmp_pagetitle = 'phpMyProfiler';

// Cache templates
// 
// Cache templates in cache directory (must be writeable). This will speed up your phpMyProfiler a lot, but you will need som additional webspace for the chached templates.
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_smarty_caching = 1;

// Cache lifetime
// 
// Lifetime of a cached template. After this time the template will rendered new. When parsing a new collection, the cache is flushed automatically, so using unlimited should be no problem.
// 
// Possible values:
//    3600 => 1 hour
//    7200 => 2 hours
//    10800 => 3 hours
//    43200 => 12 hours
//    86400 => 24 hours
//    -1 => unlimited
// 
$pmp_cache_lifetime = -1;

// Check for updates
// 
// Contact www.phpmyprofiler.de when entering the admin-menu and check if a new version is available.
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_checkforupdates = 1;



// Imprint
// =======

// Show imprint?
// 
// If you you choose no, you can skip this category.
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_imprint = 0;

// Full name
// 
$pmp_admin_full = '';

// Place of residence
// 
$pmp_admin_loc = '';

// Zip code
// 
$pmp_admin_zip = '';

// Adress
// 
$pmp_admin_adr = '';

// Country
// 
$pmp_admin_cnt = '';



// Language settings
// =================

// Default language
// 
// Possible values:
//    en => English
//    de => German
//    dk => Danish
//    no => Norwegian
//    nl => Dutch
// 
$pmp_lang_default = 'de';

// Date format
// 
// Possible values:
//    %m/%d/%y => MM/DD/YY
//    %d.%m.%Y => DD.MM.YYYY
//    %Y/%m/%d => YYYY-MM-DD
// 
$pmp_dateformat = '%d.%m.%Y';

// Preferred currency
// 
// Possible values:
//    EUR => EUR
//    AUD => AUD
//    BGN => BGN
//    BRL => BRL
//    CAD => CAD
//    CHF => CHF
//    CNY => CNY
//    CZK => CZK
//    DKK => DKK
//    EEK => EEK
//    GBP => GBP
//    HKD => HKD
//    HRK => HRK
//    HUF => HUF
//    IDR => IDR
//    INR => INR
//    JPY => JPY
//    KRW => KRW
//    LTL => LTL
//    LVL => LVL
//    MXN => MXN
//    MYR => MYR
//    NOK => NOK
//    NZD => NZD
//    PHP => PHP
//    PLN => PLN
//    RON => RON
//    RUB => RUB
//    SEK => SEK
//    SGD => SGD
//    THB => THB
//    TRY => TRY
//    USD => USD
//    ZAR => ZAR
// 
$pmp_usecurrency = 'EUR';

// Decimal point
// 
// Possible values:
//    . => point
//    , => comma
// 
$pmp_dec_point = ',';

// Thousands seperator
// 
// Possible values:
//    , => comma
//    . => point
// 
$pmp_thousands_sep = '.';

// Timezone
// 
// Possible values:
//    Africa/Abidjan => Africa/Abidjan
//    Africa/Accra => Africa/Accra
//    Africa/Addis_Ababa => Africa/Addis Ababa
//    Africa/Algiers => Africa/Algiers
//    Africa/Asmara => Africa/Asmara
//    Africa/Asmera => Africa/Asmera
//    Africa/Bamako => Africa/Bamako
//    Africa/Bangui => Africa/Bangui
//    Africa/Banjul => Africa/Banjul
//    Africa/Bissau => Africa/Bissau
//    Africa/Blantyre => Africa/Blantyre
//    Africa/Brazzaville => Africa/Brazzaville
//    Africa/Bujumbura => Africa/Bujumbura
//    Africa/Cairo => Africa/Cairo
//    Africa/Casablanca => Africa/Casablanca
//    Africa/Ceuta => Africa/Ceuta
//    Africa/Conakry => Africa/Conakry
//    Africa/Dakar => Africa/Dakar
//    Africa/Dar_es_Salaam => Africa/Dar es Salaam
//    Africa/Djibouti => Africa/Djibouti
//    Africa/Douala => Africa/Douala
//    Africa/El_Aaiun => Africa/El Aaiun
//    Africa/Freetown => Africa/Freetown
//    Africa/Gaborone => Africa/Gaborone
//    Africa/Harare => Africa/Harare
//    Africa/Johannesburg => Africa/Johannesburg
//    Africa/Kampala => Africa/Kampala
//    Africa/Khartoum => Africa/Khartoum
//    Africa/Kigali => Africa/Kigali
//    Africa/Kinshasa => Africa/Kinshasa
//    Africa/Lagos => Africa/Lagos
//    Africa/Libreville => Africa/Libreville
//    Africa/Lome => Africa/Lome
//    Africa/Luanda => Africa/Luanda
//    Africa/Lubumbashi => Africa/Lubumbashi
//    Africa/Lusaka => Africa/Lusaka
//    Africa/Malabo => Africa/Malabo
//    Africa/Maputo => Africa/Maputo
//    Africa/Maseru => Africa/Maseru
//    Africa/Mbabane => Africa/Mbabane
//    Africa/Mogadishu => Africa/Mogadishu
//    Africa/Monrovia => Africa/Monrovia
//    Africa/Nairobi => Africa/Nairobi
//    Africa/Ndjamena => Africa/Ndjamena
//    Africa/Niamey => Africa/Niamey
//    Africa/Nouakchott => Africa/Nouakchott
//    Africa/Ouagadougou => Africa/Ouagadougou
//    Africa/Porto-Novo => Africa/Porto-Novo
//    Africa/Sao_Tome => Africa/Sao Tome
//    Africa/Timbuktu => Africa/Timbuktu
//    Africa/Tripoli => Africa/Tripoli
//    Africa/Tunis => Africa/Tunis
//    Africa/Windhoek => Africa/Windhoek
//    America/Adak => America/Adak
//    America/Anchorage => America/Anchorage
//    America/Anguilla => America/Anguilla
//    America/Antigua => America/Antigua
//    America/Araguaina => America/Araguaina
//    America/Argentina => America/Argentina
//    America/Aruba => America/Aruba
//    America/Asuncion => America/Asuncion
//    America/Atikokan => America/Atikokan
//    America/Atka => America/Atka
//    America/Bahia => America/Bahia
//    America/Barbados => America/Barbados
//    America/Belem => America/Belem
//    America/Belize => America/Belize
//    America/Blanc-Sablon => America/Blanc-Sablon
//    America/Boa_Vista => America/Boa Vista
//    America/Bogota => America/Bogota
//    America/Boise => America/Boise
//    America/Buenos_Aires => America/Buenos Aires
//    America/Cambridge_Bay => America/Cambridge Bay
//    America/Campo_Grande => America/Campo Grande
//    America/Cancun => America/Cancun
//    America/Caracas => America/Caracas
//    America/Catamarca => America/Catamarca
//    America/Cayenne => America/Cayenne
//    America/Cayman => America/Cayman
//    America/Chicago => America/Chicago
//    America/Chihuahua => America/Chihuahua
//    America/Coral_Harbour => America/Coral Harbour
//    America/Cordoba => America/Cordoba
//    America/Costa_Rica => America/Costa Rica
//    America/Cuiaba => America/Cuiaba
//    America/Curacao => America/Curacao
//    America/Danmarkshavn => America/Danmarkshavn
//    America/Dawson => America/Dawson
//    America/Dawson_Creek => America/Dawson Creek
//    America/Denver => America/Denver
//    America/Detroit => America/Detroit
//    America/Dominica => America/Dominica
//    America/Edmonton => America/Edmonton
//    America/Eirunepe => America/Eirunepe
//    America/El_Salvador => America/El Salvador
//    America/Ensenada => America/Ensenada
//    America/Fort_Wayne => America/Fort Wayne
//    America/Fortaleza => America/Fortaleza
//    America/Glace_Bay => America/Glace Bay
//    America/Godthab => America/Godthab
//    America/Goose_Bay => America/Goose Bay
//    America/Grand_Turk => America/Grand Turk
//    America/Grenada => America/Grenada
//    America/Guadeloupe => America/Guadeloupe
//    America/Guatemala => America/Guatemala
//    America/Guayaquil => America/Guayaquil
//    America/Guyana => America/Guyana
//    America/Halifax => America/Halifax
//    America/Havana => America/Havana
//    America/Hermosillo => America/Hermosillo
//    America/Indiana => America/Indiana
//    America/Indianapolis => America/Indianapolis
//    America/Inuvik => America/Inuvik
//    America/Iqaluit => America/Iqaluit
//    America/Jamaica => America/Jamaica
//    America/Jujuy => America/Jujuy
//    America/Juneau => America/Juneau
//    America/Kentucky => America/Kentucky
//    America/Knox_IN => America/Knox IN
//    America/La_Paz => America/La Paz
//    America/Lima => America/Lima
//    America/Los_Angeles => America/Los Angeles
//    America/Louisville => America/Louisville
//    America/Maceio => America/Maceio
//    America/Managua => America/Managua
//    America/Manaus => America/Manaus
//    America/Marigot => America/Marigot
//    America/Martinique => America/Martinique
//    America/Mazatlan => America/Mazatlan
//    America/Mendoza => America/Mendoza
//    America/Menominee => America/Menominee
//    America/Merida => America/Merida
//    America/Mexico_City => America/Mexico City
//    America/Miquelon => America/Miquelon
//    America/Moncton => America/Moncton
//    America/Monterrey => America/Monterrey
//    America/Montevideo => America/Montevideo
//    America/Montreal => America/Montreal
//    America/Montserrat => America/Montserrat
//    America/Nassau => America/Nassau
//    America/New_York => America/New York
//    America/Nipigon => America/Nipigon
//    America/Nome => America/Nome
//    America/Noronha => America/Noronha
//    America/North_Dakota => America/North Dakota
//    America/Panama => America/Panama
//    America/Pangnirtung => America/Pangnirtung
//    America/Paramaribo => America/Paramaribo
//    America/Phoenix => America/Phoenix
//    America/Port-au-Prince => America/Port-au-Prince
//    America/Port_of_Spain => America/Port of Spain
//    America/Porto_Acre => America/Porto Acre
//    America/Porto_Velho => America/Porto Velho
//    America/Puerto_Rico => America/Puerto Rico
//    America/Rainy_River => America/Rainy River
//    America/Rankin_Inlet => America/Rankin Inlet
//    America/Recife => America/Recife
//    America/Regina => America/Regina
//    America/Resolute => America/Resolute
//    America/Rio_Branco => America/Rio Branco
//    America/Rosario => America/Rosario
//    America/Santarem => America/Santarem
//    America/Santiago => America/Santiago
//    America/Santo_Domingo => America/Santo Domingo
//    America/Sao_Paulo => America/Sao Paulo
//    America/Scoresbysund => America/Scoresbysund
//    America/Shiprock => America/Shiprock
//    America/St_Barthelemy => America/St Barthelemy
//    America/St_Johns => America/St Johns
//    America/St_Kitts => America/St Kitts
//    America/St_Lucia => America/St Lucia
//    America/St_Thomas => America/St Thomas
//    America/St_Vincent => America/St Vincent
//    America/Swift_Current => America/Swift Current
//    America/Tegucigalpa => America/Tegucigalpa
//    America/Thule => America/Thule
//    America/Thunder_Bay => America/Thunder Bay
//    America/Tijuana => America/Tijuana
//    America/Toronto => America/Toronto
//    America/Tortola => America/Tortola
//    America/Vancouver => America/Vancouver
//    America/Virgin => America/Virgin
//    America/Whitehorse => America/Whitehorse
//    America/Winnipeg => America/Winnipeg
//    America/Yakutat => America/Yakutat
//    America/Yellowknife => America/Yellowknife
//    Antarctica/Casey => Antarctica/Casey
//    Antarctica/Davis => Antarctica/Davis
//    Antarctica/DumontDUrville => Antarctica/DumontDUrville
//    Antarctica/Mawson => Antarctica/Mawson
//    Antarctica/McMurdo => Antarctica/McMurdo
//    Antarctica/Palmer => Antarctica/Palmer
//    Antarctica/Rothera => Antarctica/Rothera
//    Antarctica/South_Pole => Antarctica/South Pole
//    Antarctica/Syowa => Antarctica/Syowa
//    Antarctica/Vostok => Antarctica/Vostok
//    Arctic/Longyearbyen => Arctic/Longyearbyen
//    Asia/Aden => Asia/Aden
//    Asia/Almaty => Asia/Almaty
//    Asia/Amman => Asia/Amman
//    Asia/Anadyr => Asia/Anadyr
//    Asia/Aqtau => Asia/Aqtau
//    Asia/Aqtobe => Asia/Aqtobe
//    Asia/Ashgabat => Asia/Ashgabat
//    Asia/Ashkhabad => Asia/Ashkhabad
//    Asia/Baghdad => Asia/Baghdad
//    Asia/Bahrain => Asia/Bahrain
//    Asia/Baku => Asia/Baku
//    Asia/Bangkok => Asia/Bangkok
//    Asia/Beirut => Asia/Beirut
//    Asia/Bishkek => Asia/Bishkek
//    Asia/Brunei => Asia/Brunei
//    Asia/Calcutta => Asia/Calcutta
//    Asia/Choibalsan => Asia/Choibalsan
//    Asia/Chongqing => Asia/Chongqing
//    Asia/Chungking => Asia/Chungking
//    Asia/Colombo => Asia/Colombo
//    Asia/Dacca => Asia/Dacca
//    Asia/Damascus => Asia/Damascus
//    Asia/Dhaka => Asia/Dhaka
//    Asia/Dili => Asia/Dili
//    Asia/Dubai => Asia/Dubai
//    Asia/Dushanbe => Asia/Dushanbe
//    Asia/Gaza => Asia/Gaza
//    Asia/Harbin => Asia/Harbin
//    Asia/Ho_Chi_Minh => Asia/Ho Chi Minh
//    Asia/Hong_Kong => Asia/Hong Kong
//    Asia/Hovd => Asia/Hovd
//    Asia/Irkutsk => Asia/Irkutsk
//    Asia/Istanbul => Asia/Istanbul
//    Asia/Jakarta => Asia/Jakarta
//    Asia/Jayapura => Asia/Jayapura
//    Asia/Jerusalem => Asia/Jerusalem
//    Asia/Kabul => Asia/Kabul
//    Asia/Kamchatka => Asia/Kamchatka
//    Asia/Karachi => Asia/Karachi
//    Asia/Kashgar => Asia/Kashgar
//    Asia/Kathmandu => Asia/Kathmandu
//    Asia/Katmandu => Asia/Katmandu
//    Asia/Kolkata => Asia/Kolkata
//    Asia/Krasnoyarsk => Asia/Krasnoyarsk
//    Asia/Kuala_Lumpur => Asia/Kuala Lumpur
//    Asia/Kuching => Asia/Kuching
//    Asia/Kuwait => Asia/Kuwait
//    Asia/Macao => Asia/Macao
//    Asia/Macau => Asia/Macau
//    Asia/Magadan => Asia/Magadan
//    Asia/Makassar => Asia/Makassar
//    Asia/Manila => Asia/Manila
//    Asia/Muscat => Asia/Muscat
//    Asia/Nicosia => Asia/Nicosia
//    Asia/Novosibirsk => Asia/Novosibirsk
//    Asia/Omsk => Asia/Omsk
//    Asia/Oral => Asia/Oral
//    Asia/Phnom_Penh => Asia/Phnom Penh
//    Asia/Pontianak => Asia/Pontianak
//    Asia/Pyongyang => Asia/Pyongyang
//    Asia/Qatar => Asia/Qatar
//    Asia/Qyzylorda => Asia/Qyzylorda
//    Asia/Rangoon => Asia/Rangoon
//    Asia/Riyadh => Asia/Riyadh
//    Asia/Saigon => Asia/Saigon
//    Asia/Sakhalin => Asia/Sakhalin
//    Asia/Samarkand => Asia/Samarkand
//    Asia/Seoul => Asia/Seoul
//    Asia/Shanghai => Asia/Shanghai
//    Asia/Singapore => Asia/Singapore
//    Asia/Taipei => Asia/Taipei
//    Asia/Tashkent => Asia/Tashkent
//    Asia/Tbilisi => Asia/Tbilisi
//    Asia/Tehran => Asia/Tehran
//    Asia/Tel_Aviv => Asia/Tel Aviv
//    Asia/Thimbu => Asia/Thimbu
//    Asia/Thimphu => Asia/Thimphu
//    Asia/Tokyo => Asia/Tokyo
//    Asia/Ujung_Pandang => Asia/Ujung Pandang
//    Asia/Ulaanbaatar => Asia/Ulaanbaatar
//    Asia/Ulan_Bator => Asia/Ulan Bator
//    Asia/Urumqi => Asia/Urumqi
//    Asia/Vientiane => Asia/Vientiane
//    Asia/Vladivostok => Asia/Vladivostok
//    Asia/Yakutsk => Asia/Yakutsk
//    Asia/Yekaterinburg => Asia/Yekaterinburg
//    Asia/Yerevan => Asia/Yerevan
//    Atlantic/Azores => Atlantic/Azores
//    Atlantic/Bermuda => Atlantic/Bermuda
//    Atlantic/Canary => Atlantic/Canary
//    Atlantic/Cape_Verde => Atlantic/Cape Verde
//    Atlantic/Faeroe => Atlantic/Faeroe
//    Atlantic/Faroe => Atlantic/Faroe
//    Atlantic/Jan_Mayen => Atlantic/Jan Mayen
//    Atlantic/Madeira => Atlantic/Madeira
//    Atlantic/Reykjavik => Atlantic/Reykjavik
//    Atlantic/South_Georgia => Atlantic/South Georgia
//    Atlantic/St_Helena => Atlantic/St Helena
//    Atlantic/Stanley => Atlantic/Stanley
//    Australia/ACT => Australia/ACT
//    Australia/Adelaide => Australia/Adelaide
//    Australia/Brisbane => Australia/Brisbane
//    Australia/Broken_Hill => Australia/Broken Hill
//    Australia/Canberra => Australia/Canberra
//    Australia/Currie => Australia/Currie
//    Australia/Darwin => Australia/Darwin
//    Australia/Eucla => Australia/Eucla
//    Australia/Hobart => Australia/Hobart
//    Australia/LHI => Australia/LHI
//    Australia/Lindeman => Australia/Lindeman
//    Australia/Lord_Howe => Australia/Lord Howe
//    Australia/Melbourne => Australia/Melbourne
//    Australia/North => Australia/North
//    Australia/NSW => Australia/NSW
//    Australia/Perth => Australia/Perth
//    Australia/Queensland => Australia/Queensland
//    Australia/South => Australia/South
//    Australia/Sydney => Australia/Sydney
//    Australia/Tasmania => Australia/Tasmania
//    Australia/Victoria => Australia/Victoria
//    Australia/West => Australia/West
//    Australia/Yancowinna => Australia/Yancowinna
//    Europe/Amsterdam => Europe/Amsterdam
//    Europe/Andorra => Europe/Andorra
//    Europe/Athens => Europe/Athens
//    Europe/Belfast => Europe/Belfast
//    Europe/Belgrade => Europe/Belgrade
//    Europe/Berlin => Europe/Berlin
//    Europe/Bratislava => Europe/Bratislava
//    Europe/Brussels => Europe/Brussels
//    Europe/Bucharest => Europe/Bucharest
//    Europe/Budapest => Europe/Budapest
//    Europe/Chisinau => Europe/Chisinau
//    Europe/Copenhagen => Europe/Copenhagen
//    Europe/Dublin => Europe/Dublin
//    Europe/Gibraltar => Europe/Gibraltar
//    Europe/Guernsey => Europe/Guernsey
//    Europe/Helsinki => Europe/Helsinki
//    Europe/Isle_of_Man => Europe/Isle of Man
//    Europe/Istanbul => Europe/Istanbul
//    Europe/Jersey => Europe/Jersey
//    Europe/Kaliningrad => Europe/Kaliningrad
//    Europe/Kiev => Europe/Kiev
//    Europe/Lisbon => Europe/Lisbon
//    Europe/Ljubljana => Europe/Ljubljana
//    Europe/London => Europe/London
//    Europe/Luxembourg => Europe/Luxembourg
//    Europe/Madrid => Europe/Madrid
//    Europe/Malta => Europe/Malta
//    Europe/Mariehamn => Europe/Mariehamn
//    Europe/Minsk => Europe/Minsk
//    Europe/Monaco => Europe/Monaco
//    Europe/Moscow => Europe/Moscow
//    Europe/Nicosia => Europe/Nicosia
//    Europe/Oslo => Europe/Oslo
//    Europe/Paris => Europe/Paris
//    Europe/Podgorica => Europe/Podgorica
//    Europe/Prague => Europe/Prague
//    Europe/Riga => Europe/Riga
//    Europe/Rome => Europe/Rome
//    Europe/Samara => Europe/Samara
//    Europe/San_Marino => Europe/San Marino
//    Europe/Sarajevo => Europe/Sarajevo
//    Europe/Simferopol => Europe/Simferopol
//    Europe/Skopje => Europe/Skopje
//    Europe/Sofia => Europe/Sofia
//    Europe/Stockholm => Europe/Stockholm
//    Europe/Tallinn => Europe/Tallinn
//    Europe/Tirane => Europe/Tirane
//    Europe/Tiraspol => Europe/Tiraspol
//    Europe/Uzhgorod => Europe/Uzhgorod
//    Europe/Vaduz => Europe/Vaduz
//    Europe/Vatican => Europe/Vatican
//    Europe/Vienna => Europe/Vienna
//    Europe/Vilnius => Europe/Vilnius
//    Europe/Volgograd => Europe/Volgograd
//    Europe/Warsaw => Europe/Warsaw
//    Europe/Zagreb => Europe/Zagreb
//    Europe/Zaporozhye => Europe/Zaporozhye
//    Europe/Zurich => Europe/Zurich
//    Indian/Antananarivo => Indian/Antananarivo
//    Indian/Chagos => Indian/Chagos
//    Indian/Christmas => Indian/Christmas
//    Indian/Cocos => Indian/Cocos
//    Indian/Comoro => Indian/Comoro
//    Indian/Kerguelen => Indian/Kerguelen
//    Indian/Mahe => Indian/Mahe
//    Indian/Maldives => Indian/Maldives
//    Indian/Mauritius => Indian/Mauritius
//    Indian/Mayotte => Indian/Mayotte
//    Indian/Reunion => Indian/Reunion
//    Pacific/Apia => Pacific/Apia
//    Pacific/Auckland => Pacific/Auckland
//    Pacific/Chatham => Pacific/Chatham
//    Pacific/Easter => Pacific/Easter
//    Pacific/Efate => Pacific/Efate
//    Pacific/Enderbury => Pacific/Enderbury
//    Pacific/Fakaofo => Pacific/Fakaofo
//    Pacific/Fiji => Pacific/Fiji
//    Pacific/Funafuti => Pacific/Funafuti
//    Pacific/Galapagos => Pacific/Galapagos
//    Pacific/Gambier => Pacific/Gambier
//    Pacific/Guadalcanal => Pacific/Guadalcanal
//    Pacific/Guam => Pacific/Guam
//    Pacific/Honolulu => Pacific/Honolulu
//    Pacific/Johnston => Pacific/Johnston
//    Pacific/Kiritimati => Pacific/Kiritimati
//    Pacific/Kosrae => Pacific/Kosrae
//    Pacific/Kwajalein => Pacific/Kwajalein
//    Pacific/Majuro => Pacific/Majuro
//    Pacific/Marquesas => Pacific/Marquesas
//    Pacific/Midway => Pacific/Midway
//    Pacific/Nauru => Pacific/Nauru
//    Pacific/Niue => Pacific/Niue
//    Pacific/Norfolk => Pacific/Norfolk
//    Pacific/Noumea => Pacific/Noumea
//    Pacific/Pago_Pago => Pacific/Pago Pago
//    Pacific/Palau => Pacific/Palau
//    Pacific/Pitcairn => Pacific/Pitcairn
//    Pacific/Ponape => Pacific/Ponape
//    Pacific/Port_Moresby => Pacific/Port Moresby
//    Pacific/Rarotonga => Pacific/Rarotonga
//    Pacific/Saipan => Pacific/Saipan
//    Pacific/Samoa => Pacific/Samoa
//    Pacific/Tahiti => Pacific/Tahiti
//    Pacific/Tarawa => Pacific/Tarawa
//    Pacific/Tongatapu => Pacific/Tongatapu
//    Pacific/Truk => Pacific/Truk
//    Pacific/Wake => Pacific/Wake
//    Pacific/Wallis => Pacific/Wallis
//    Pacific/Yap => Pacific/Yap
// 
$pmp_timezone = 'Europe/Berlin';



// Parser settings
// ===============

// Parser mode
// 
// 'Build from scratch' will delete all profiles, 'Update with delete' will only delete profiles not in xml, 'Update without delete' will delete no profiles but update those in xml.
// 
// Possible values:
//    0 => Build from scratch
//    1 => Update with delete
//    2 => Update without delete
// 
$pmp_parser_mode = 0;

// Split collection after x DVDs
// 
// If your server is too slow to parse all dvds at once (timeout error occurs), you can split the file into smaller pieces. This setting is used only in 'Build from scratch'-Mode.
// 
$pmp_splitxmlafter = 100;

// Build banners for use in a signature
// 
// This will create banners for the last ten added and/or watched movies.
// 
// Mögliche Werte:
//    0 => No banner
//    1 => Last added banner only
//    2 => Last watched banner only
//    3 => Both banners
// 
$pmp_build_banners = 0;

// Build banners for
// 
// This will insert the name to the banner title. Notice that this will also filter for watched movies by this person.
// 
$pmp_banner_name = '';



// Graphic settings
// ================

// Use graphic funtions
// 
// Set to yes, if GD-Libs are installed
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_gdlib = 1;

// Cache thumbnails
// 
// Cached thumbnails in cache directory (must be writeable). This will speed up your phpMyProfiler but you will need some additional webspace for the thumbnails.
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_thumbnail_cache = 1;

// Use true type fonts in graphs
// 
// You need to use true type fonts for languages with special characters (eg. Norwegian Ø)
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_stat_use_ttf = 1;

// Show HD banner
//
// Will only work if GD-Libs are enabled
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_hdbanner = 1;



// Display settings
// ================

// Theme
// 
// Possible values:
//    default => default
// 
$pmp_theme = 'default';

// Theme CSS
// 
// Possible values:
//    default.css => default.css
//    red.css => red.css
//    black.css => black.css
// 
$pmp_theme_css = 'default.css';

// Number of DVDs at start page
// 
$pmp_dvd_start = 10;

// Number of DVDs in DVD list per page
// 
$pmp_dvd_menue = 100;

// Number of entries in guestbook per page
// 
$pmp_entries_side = 10;

// Number of photos in photo gallery per page
// 
$pmp_picture_page = 5;

// Number of news in news archive per page
// 
$pmp_news_page = 10;

// Number of covers in cover gallery per page
// 
$pmp_cover_page = 30;

// Number of covers in cover gallery per line
// 
$pmp_cover_per_row = 3;

// Number of pictures in person gallery per line
// 
$pmp_people_per_row = 4;

// Number of pictures in person gallery per page
// 
$pmp_people_per_page = 80;

// Show time information on event page
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_events_showtime = 1;

// Disable newsarchive
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_disable_newsarchive = 0;

// Disable guestbook
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_disable_guestbook = 0;

// Disable contact
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_disable_contact = 0;

// Disable phpMyProfiler website and forum links
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_disable_links = 0;



// Display settings for profiles
// =============================

// Show media type before title
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_show_mediatype = 1;

// Exclude tag
//
// Don't show media with this selected tag
//
// Possible values:
//     => empty
//
$pmp_exclude_tag = '';

// Use HTML-Code in notices
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_html_notes = 1;

// Type of review
//
// Possible values:
//    0 => Default (Movie, DVD)
//    1 => Simple (Movie)
//    2 => Detailed (Movie, Video, Audio, Extras)
//    3 => Deactivated
//
$pmp_review_type = 0;

// Activate external reviews
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_extern_reviews = 1;

// Show review summary graph
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_show_brief_review = 1;

// Show external links on profile page
//
// Possible values:
//    0 => Auto
//    1 => My Links
//    2 => External Links
//    3 => All
//    4 => None
//
$pmp_show_links = 0;

// Disable reviews
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_disable_reviews = 0;

// Use Count As value from DVDProfiler for statistics
//
// Possible values:
//    0 => No
//    1 => Yes
//
$pmp_use_countas = 0;



// Other settings
// ==============

// Activate guestbooks entries automatically
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_guestbook_activatenew = 1;

// Use security code in guestbook
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_guestbook_showcode = 1;

// Activate reviews automatically
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_review_activatenew = 1;

// Sort order of latest DVDs
// 
// Possible values:
//    collectionnumber => Number
//    purchdate => Date of purchase
// 
$pmp_start_sort_order = 'purchdate';

// Show price informations in statistics
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_statistic_showprice = 0;

// Relative path to cast directory
// 
// Change this value only if you know what your are doing.
// 
$pmp_dir_cast = 'cast/';

// Enable Google Analytics
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_google = 0;

// Google Analytics Tracking Code
// 
$pmp_tracking_code = '';

// Turn on gzip output buffer
// 
// Possible values:
//    0 => No
//    1 => Yes
// 
$pmp_compression = 0;



// DVD-List
// ========

// Default sort order
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_sortby = 1;

// Default sort order direction
// 
// Possible values:
//    asc => Ascending
//    desc => Descending
// 
$pmp_menue_sortdir = 'asc';

// Default sort order of child profiles
// 
// Possible values:
//    collectionnumber => Number
//    prodyear => Year
//    sorttitle => Title
// 
$pmp_menue_childs = 'prodyear';

// Show sequential number
// 
// Possible values:
//    1 => Yes
//    0 => No
// 
$pmp_menue_column_0 = 1;

// Column 1
// 
// Hide column 1 also hide the "+" before Boxsets and the films are not clickable.
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_1 = 1;

// Column 2
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_2 = 2;

// Column 3
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_3 = 3;

// Column 4
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_4 = 0;

// Column 5
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_5 = 0;

// Column 6
// 
// Possible values:
//    0 => empty
//    1 => Movie Title
//    2 => Year
//    3 => Country
//    4 => Nr.
//    5 => Date of purchase
//    6 => Length
//    7 => Price
//    8 => Place of purchase
//    9 => Edition
//    10 => Origin
// 
$pmp_menue_column_6 = 0;

?>

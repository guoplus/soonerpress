<?php
/**
 * Multilingual module configuration
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */


global $sp_config;

$sp_config['multilingual'] = array(
	'allow_options_menu'                 => true,
	'allow_options_query_mode'           => true,
	'allow_options_detect_browser'       => true,
	'allow_options_download_wp_messages' => true,
	'allow_options_post_type'            => true,
	'allow_options_taxonomy'             => true,
	'options_main'                       => array(
		// Post type to bind multilanguage, ignore this to bind to all post-types
		'post_type' => array( 'post', 'page', 'slide', 'event' ),
		// taxonomy to bind multilanguage, ignore this to bind to all taxonomies
		'taxonomy'  => array( 'category', 'post_tag' ),
	),
	'languages' => array(
		'af'     => array(
			'name' => 'Afrikaans - Afrikaans',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'an'     => array(
			'name' => 'Aragonese - Aragonés',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ar'     => array(
			'name' => 'Arabic – عربي',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/ar.gif',
		),
		'as'     => array(
			'name' => 'Assamese - অসমীয়া',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'az'     => array(
			'name' => 'Azerbaijani - Azərbaycan dili',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'az_TR'  => array(
			'name' => 'Azerbaijani (Turkey) - Azərbaycan Türkcəsi',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'azb'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'bel'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'bg_BG'  => array(
			'name' => 'Bulgarian - Български',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'bn_BD'  => array(
			'name' => 'Bangla - Bengali',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'bo'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'bs_BA'  => array(
			'name' => 'Bosnian - Bosanski',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ca'     => array(
			'name' => 'Catalan - Català',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ckb'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'co'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'cpp'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'cs_CZ'  => array(
			'name' => 'Czech - Čeština',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'cy'     => array(
			'name' => 'Welsh - Cymraeg',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'da_DK'  => array(
			'name' => 'Danish - Dansk',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'de_DE'  => array(
			'name' => 'German - Deutsch',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/de.gif',
			'date_format' => 'j. F Y', 'time_format' => 'g:i A',
		),
	//		'dv'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'el'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'en_CA'  => array(
			'name' => 'Canadian English',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/ca.gif',
		),
		'en_GB'  => array(
			'name' => 'British English',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'eo'     => array(
			'name' => 'Esperanto',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'es_CL'  => array(
			'name' => 'Chilean - Chile',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'es_ES'  => array(
			'name' => 'Spanish - Español - España',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/es.gif',
		),
		'es_PE'  => array(
			'name' => 'Spanish - Español - Perú',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'en_US'  => array(
			'name' => 'English - United States',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/us.gif',
			'date_format' => 'F j, Y', 'time_format' => 'g:i a',
		),
	//		'es_VE'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'et'     => array(
			'name' => 'Estonian - Eesti',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'eu'     => array(
			'name' => 'Basque - Euskara',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fa_AF'  => array(
			'name' => 'Persian (Afghanistan) - (فارسی (افغانستان',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fa_IR'  => array(
			'name' => 'Persian - وردپرس پارسی',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fi'     => array(
			'name' => 'Finnish - Suomi',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/fi.gif',
		),
		'fo'     => array(
			'name' => 'Faroese - føroyskt',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'fr_BE'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'fr_FR'  => array(
			'name' => 'French - Français',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/fr.gif',
		),
		'fy'     => array(
			'name' => 'Frisian - Frysk',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ga'     => array(
			'name' => 'Gaeilge - Irish',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'gd'     => array(
			'name' => 'Scottish Gaelic - Gàidhlig',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'gl_ES'  => array(
			'name' => 'Galician - Galego',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'gsw'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'gu'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'haw_US' => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'haz'    => array(
			'name' => 'Hazaragi – هزاره‌گی',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'he_IL'  => array(
			'name' => 'Hebrew - עברית',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hi_IN'  => array(
			'name' => 'Hindi - हिन्दी',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hr'     => array(
			'name' => 'Croatian - Hrvatski',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hu_HU'  => array(
			'name' => 'Hungarian - Magyar',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/hu.gif',
		),
	//		'hy'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'id_ID'  => array(
			'name' => 'Indonesian - Bahasa Indonesia',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'is_IS'  => array(
			'name' => 'Icelandic - íslenska',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'it_IT'  => array(
			'name' => 'Italian - Italiano',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/it.gif',
		),
		'ja'     => array(
			'name' => 'Japanese (日本語)',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/jp.gif',
		),
		'jv_ID'  => array(
			'name' => 'Javanese - Basa Jawa',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ka_GE'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'kea'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'kk'     => array(
			'name' => 'Kazakh - Қазақша',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'kn'     => array(
			'name' => 'Kannada - ಕನ್ನಡ',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ko_KR'  => array(
			'name' => 'Korean - 한국어',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ku'     => array(
			'name' => 'Kurdish(Sorany) وۆردپرێس بەکوردی',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ky_KY'  => array(
			'name' => 'Kyrgyz - Кыргызча',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'la'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'li'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'lo'     => array(
			'name' => 'Lao - ພາສາລາວ',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'lv'     => array(
			'name' => 'Latvian (Latviešu)',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'me_ME'  => array(
			'name' => 'Montenegrin - Crnogorski jezik',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'mg_MG'  => array(
			'name' => 'Malagasy - Malagasy',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'mk_MK'  => array(
			'name' => 'Macedonian - Македонски',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ml_IN'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'mn'     => array(
			'name' => 'Mongolian - (Монгол хэл)',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'mr'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'mri'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ms_MY'  => array(
			'name' => 'Malay – Bahasa Melayu',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/my.gif',
		),
		'my_MM'  => array(
			'name' => 'Burmese - ဗမာစာ',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'nb_NO'  => array(
			'name' => 'Norwegian - Bokmål',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ne_NP'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'nl'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'nl_BE'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'nl_NL'  => array(
			'name' => 'Dutch - Nederlands',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/nl.gif',
		),
		'nn_NO'  => array(
			'name' => 'Norwegian - Nynorsk',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'os'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'pa_IN'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'pl_PL'  => array(
			'name' => 'Polish - Polski',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/pl.gif',
		),
	//		'pot'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'pt_BR'  => array(
			'name' => 'Portuguese - Brazilian Portuguese',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'pt_PT'  => array(
			'name' => 'Portuguese - European Portuguese',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/pt.gif',
		),
		'ro_RO'  => array(
			'name' => 'Romanian - Română',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ru_RU'  => array(
			'name' => 'Russian — Русский',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ru_UA'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'sa_IN'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'sd_PK'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'si_LK'  => array(
			'name' => 'Sinhala - සිංහල',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sk_SK'  => array(
			'name' => 'Slovak – Slovenčina',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sl_SI'  => array(
			'name' => 'Slovenian - Slovenščina',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'so_SO'  => array(
			'name' => 'Somali - Afsoomaali',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sq'     => array(
			'name' => 'Albanian - Shqip',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sr_RS'  => array(
			'name' => 'Serbian - Српски',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'srd'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'su_ID'  => array(
			'name' => 'Sundanese - Basa Sunda',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sv_SE'  => array(
			'name' => 'Swedish - Svenska',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'sw'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'ta_IN'  => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ta_LK'  => array(
			'name' => 'Sri Lanka- இலங்கைத் தமிழ்',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'te'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'tg'     => array(
			'name' => 'Tajik',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'th'     => array(
			'name' => 'Thai - ไทย',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'tl'     => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'tr_TR'  => array(
			'name' => 'Turkish - Türkçe',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'tuk'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'tzm'    => array(
	//			'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ug_CN'  => array(
			'name' => 'Uighur - ئۇيغۇرچە',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'uk'     => array(
			'name' => 'Ukrainian - Українська',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ur'     => array(
			'name' => 'Urdu - اردو',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'uz_UZ'  => array(
			'name' => 'Uzbek - O‘zbekcha',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'vi'     => array(
			'name' => 'Vietnamese - Tiếng Việt',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'zh_CN'  => array(
			'name' => 'Chinese - 中文',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/cn.gif',
			'date_format' => 'Y年n月j日', 'time_format' => 'g:i A',
		),
		'zh_HK'  => array(
			'name' => 'Hong Kong (香港)',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/hk.gif',
		),
		'zh_TW'  => array(
			'name' => 'Taiwan (台灣)',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/tw.gif',
		),
	),
);


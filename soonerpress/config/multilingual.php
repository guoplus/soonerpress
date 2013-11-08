<?php
/**
 * Multilingual module configuration
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['multilingual'] = array(
	'allow_options_menu'                 => true,
	'allow_options_query_mode'           => true,
	'allow_options_detect_browser'       => true,
	'allow_options_download_wp_messages' => true,
	'allow_options_post_type'            => true,
	'allow_options_taxonomy'             => true,
	'options'                            => array(
		// Post type to bind multilanguage, ignore this to bind to all post-types
		'post_type' => array( 'blog', 'page', 'slide', 'event', 'product', ),
		// taxonomy to bind multilanguage, ignore this to bind to all taxonomies
		'taxonomy'  => array( 'blog_category', 'blog_tag', ),
	),
	'languages' => array(
		'af'     => array(
			'title' => 'Afrikaans - Afrikaans', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'an'     => array(
			'title' => 'Aragonese - Aragonés', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ar'     => array(
			'title' => 'Arabic – عربي', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/ar.gif',
		),
		'as'     => array(
			'title' => 'Assamese - অসমীয়া', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'az'     => array(
			'title' => 'Azerbaijani - Azərbaycan dili', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'az_TR'  => array(
			'title' => 'Azerbaijani (Turkey) - Azərbaycan Türkcəsi', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'azb'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'bel'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'bg_BG'  => array(
			'title' => 'Bulgarian - Български', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'bn_BD'  => array(
			'title' => 'Bangla - Bengali', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'bo'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'bs_BA'  => array(
			'title' => 'Bosnian - Bosanski', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ca'     => array(
			'title' => 'Catalan - Català', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ckb'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'co'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'cpp'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'cs_CZ'  => array(
			'title' => 'Czech - Čeština', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'cy'     => array(
			'title' => 'Welsh - Cymraeg', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'da_DK'  => array(
			'title' => 'Danish - Dansk', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'de_DE'  => array(
			'title' => 'German - Deutsch', 'name' => 'Deutsch',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/de.gif',
			'date_format' => 'j. F Y', 'time_format' => 'g:i A',
		),
	//		'dv'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'el'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'en_CA'  => array(
			'title' => 'Canadian English', 'name' => 'English',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/ca.gif',
		),
		'en_GB'  => array(
			'title' => 'British English', 'name' => 'English',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'eo'     => array(
			'title' => 'Esperanto', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'es_CL'  => array(
			'title' => 'Chilean - Chile', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'es_ES'  => array(
			'title' => 'Spanish - Español - España', 'name' => 'Spanish',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/es.gif',
		),
		'es_PE'  => array(
			'title' => 'Spanish - Español - Perú', 'name' => 'Spanish',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'en_US'  => array(
			'title' => 'English - United States', 'name' => 'English',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/us.gif',
			'date_format' => 'F j, Y', 'time_format' => 'g:i a',
		),
	//		'es_VE'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'et'     => array(
			'title' => 'Estonian - Eesti', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'eu'     => array(
			'title' => 'Basque - Euskara', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fa_AF'  => array(
			'title' => 'Persian (Afghanistan) - (فارسی (افغانستان', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fa_IR'  => array(
			'title' => 'Persian - وردپرس پارسی', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'fi'     => array(
			'title' => 'Finnish - Suomi', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/fi.gif',
		),
		'fo'     => array(
			'title' => 'Faroese - føroyskt', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'fr_BE'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'fr_FR'  => array(
			'title' => 'French - Français', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/fr.gif',
		),
		'fy'     => array(
			'title' => 'Frisian - Frysk', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ga'     => array(
			'title' => 'Gaeilge - Irish', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'gd'     => array(
			'title' => 'Scottish Gaelic - Gàidhlig', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'gl_ES'  => array(
			'title' => 'Galician - Galego', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'gsw'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'gu'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'haw_US' => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'haz'    => array(
			'title' => 'Hazaragi – هزاره‌گی', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'he_IL'  => array(
			'title' => 'Hebrew - עברית', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hi_IN'  => array(
			'title' => 'Hindi - हिन्दी', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hr'     => array(
			'title' => 'Croatian - Hrvatski', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'hu_HU'  => array(
			'title' => 'Hungarian - Magyar', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/hu.gif',
		),
	//		'hy'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'id_ID'  => array(
			'title' => 'Indonesian - Bahasa Indonesia', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'is_IS'  => array(
			'title' => 'Icelandic - íslenska', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'it_IT'  => array(
			'title' => 'Italian - Italiano', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/it.gif',
		),
		'ja'     => array(
			'title' => 'Japanese (日本語)', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/jp.gif',
		),
		'jv_ID'  => array(
			'title' => 'Javanese - Basa Jawa', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ka_GE'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'kea'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'kk'     => array(
			'title' => 'Kazakh - Қазақша', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'kn'     => array(
			'title' => 'Kannada - ಕನ್ನಡ', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ko_KR'  => array(
			'title' => 'Korean - 한국어', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ku'     => array(
			'title' => 'Kurdish(Sorany) وۆردپرێس بەکوردی', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ky_KY'  => array(
			'title' => 'Kyrgyz - Кыргызча', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'la'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'li'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'lo'     => array(
			'title' => 'Lao - ພາສາລາວ', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'lv'     => array(
			'title' => 'Latvian (Latviešu)', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'me_ME'  => array(
			'title' => 'Montenegrin - Crnogorski jezik', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'mg_MG'  => array(
			'title' => 'Malagasy - Malagasy', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'mk_MK'  => array(
			'title' => 'Macedonian - Македонски', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ml_IN'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'mn'     => array(
			'title' => 'Mongolian - (Монгол хэл)', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'mr'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'mri'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ms_MY'  => array(
			'title' => 'Malay – Bahasa Melayu', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/my.gif',
		),
		'my_MM'  => array(
			'title' => 'Burmese - ဗမာစာ', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'nb_NO'  => array(
			'title' => 'Norwegian - Bokmål', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ne_NP'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'nl'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'nl_BE'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'nl_NL'  => array(
			'title' => 'Dutch - Nederlands', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/nl.gif',
		),
		'nn_NO'  => array(
			'title' => 'Norwegian - Nynorsk', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'os'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'pa_IN'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'pl_PL'  => array(
			'title' => 'Polish - Polski', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/pl.gif',
		),
	//		'pot'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'pt_BR'  => array(
			'title' => 'Portuguese - Brazilian Portuguese', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'pt_PT'  => array(
			'title' => 'Portuguese - European Portuguese', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/pt.gif',
		),
		'ro_RO'  => array(
			'title' => 'Romanian - Română', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ru_RU'  => array(
			'title' => 'Russian — Русский', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'ru_UA'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'sa_IN'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'sd_PK'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'si_LK'  => array(
			'title' => 'Sinhala - සිංහල', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sk_SK'  => array(
			'title' => 'Slovak – Slovenčina', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sl_SI'  => array(
			'title' => 'Slovenian - Slovenščina', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'so_SO'  => array(
			'title' => 'Somali - Afsoomaali', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sq'     => array(
			'title' => 'Albanian - Shqip', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sr_RS'  => array(
			'title' => 'Serbian - Српски', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'srd'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'su_ID'  => array(
			'title' => 'Sundanese - Basa Sunda', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'sv_SE'  => array(
			'title' => 'Swedish - Svenska', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'sw'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'ta_IN'  => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ta_LK'  => array(
			'title' => 'Sri Lanka- இலங்கைத் தமிழ்', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'te'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'tg'     => array(
			'title' => 'Tajik', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'th'     => array(
			'title' => 'Thai - ไทย', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'tl'     => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'tr_TR'  => array(
			'title' => 'Turkish - Türkçe', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
	//		'tuk'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
	//		'tzm'    => array(
	//			'title' => '', 'name' => '',
	//			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
	//		),
		'ug_CN'  => array(
			'title' => 'Uighur - ئۇيغۇرچە', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'uk'     => array(
			'title' => 'Ukrainian - Українська', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'ur'     => array(
			'title' => 'Urdu - اردو', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'uz_UZ'  => array(
			'title' => 'Uzbek - O‘zbekcha', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'vi'     => array(
			'title' => 'Vietnamese - Tiếng Việt', 'name' => '',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/unknown.gif',
		),
		'zh_CN'  => array(
			'title' => 'Chinese - 中文', 'name' => '中文',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/cn.gif',
			'date_format' => 'Y年n月j日', 'time_format' => 'g:i A',
		),
		'zh_HK'  => array(
			'title' => 'Hong Kong (香港)', 'name' => '繁体中文',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/hk.gif',
		),
		'zh_TW'  => array(
			'title' => 'Taiwan (台灣)', 'name' => '繁体中文',
			'flag' => trailingslashit( SP_INC_URI ) . 'multilingual/images/flags/tw.gif',
		),
	),
);


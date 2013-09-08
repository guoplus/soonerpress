<?php


global $sp_config;

$sp_config['languages'] = array(
	// sorted enabled-languages
	'enabled' => array( 'en', 'zh', 'de' ),
	// using default language if browser language was unknown
	'default' => 'en',
	// language main stored in database `post` table, just for disabling multi-language
	'main_stored' => 'en',
	// using language automatically detected from browser
	'detect_browser_language' => true,
	// URL query style: parameter, rewrite
	'query_mode' => 'rewrite',
	// Post type to bind multilanguage, ignore this to bind to all post-types
	'post_type' => array( 'post', 'page', 'type_slide', 'type_event' ),
	// taxonomy to bind multilanguage, ignore this to bind to all taxonomies
	'taxonomy' => array( 'category', 'post_tag' ),
	// names of languages
	'names' => array(
		'ar' => 'العربية',
		'de' => 'Deutsch',
		'en' => 'English',
		'es' => 'Español',
		'fi' => 'suomi',
		'fr' => 'Français',
		'gl' => 'galego',
		'hu' => 'Magyar',
		'it' => 'Italiano',
		'ja' => '日本語',
		'nl' => 'Nederlands',
		'pl' => 'Polski',
		'pt' => 'Português',
		'ro' => 'Română',
		'sv' => 'Svenska',
		'vi' => 'Tiếng Việt',
		'zh' => '中文',
	),
	// flag icons for languages
	'flags' => array(
		'ar' => 'ar.gif',
		'de' => 'de.gif',
		'en' => 'us.gif',
		'es' => 'es.gif',
		'fi' => 'fi.gif',
		'fr' => 'fr.gif',
		'gl' => 'gl.gif',
		'hu' => 'hu.gif',
		'it' => 'it.gif',
		'ja' => 'jp.gif',
		'nl' => 'nl.gif',
		'pl' => 'pl.gif',
		'pt' => 'pt.gif',
		'ro' => 'ro.gif',
		'sv' => 'sv.gif',
		'vi' => 'vi.gif',
		'zh' => 'cn.gif',
	),
);


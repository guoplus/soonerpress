<?php
/**
 * Breadcrumbs module configuration
 *
 * @package SoonerPress
 * @subpackage Breadcrumbs
 */


global $sp_config;

$sp_config['breadcrumbs'] = array(
	'home_text' => __( 'Home', 'sp' ),
	'separator' => ' &raquo; ',
	'singular'  => array( // post_type_name => taxonomy_name OR 'path' (only for page)
		'post' => 'category', // can be 'category', 'post_tag', or other registered taxonomy
		'page' => 'path',
		'news' => 'news_category',
		'event' => 'event_category', // test: event_location or event_category
	),
);


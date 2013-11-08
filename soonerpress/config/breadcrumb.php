<?php
/**
 * Breadcrumb module configuration
 *
 * @package SoonerPress
 * @subpackage Breadcrumb
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['breadcrumb'] = array(
	'home_text'    => __( 'Home', 'sp' ),
	'separator'    => ' &raquo; ',
	'show_in_home' => false,
	'before'       => '<div class="breadcrumb">',
	'after'        => '</div>',
	'singular'     => array( // post_type_name => taxonomy_name OR 'path' (only for page)
		'post'    => 'category', // can be 'category', 'post_tag', or other registered taxonomy for post
		'page'    => 'path',
		'news'    => 'news_category',
		'event'   => 'event_category', // test: event_location or event_category
		'product' => 'independent',
	),
);


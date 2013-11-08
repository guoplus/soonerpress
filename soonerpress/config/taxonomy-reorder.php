<?php
/**
 * Taxonomy Re-order module configuration
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Re-order
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['taxonomy-reorder'] = array(
	'blog_category' => array(
		'menu_mode' => 'embedded', // 'embedded' or 'independent'
	),
	'blog_tag' => array(
		'menu_mode' => 'independent',
	),
	'event_location' => array(
		'menu_mode' => 'embedded',
	),
);


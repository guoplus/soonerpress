<?php
/**
 * Taxonomy Re-order module configuration
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Re-order
 */


global $sp_config;

$sp_config['taxonomy-order'] = array(
	'category' => array(
		'menu_mode' => 'independent', // 'embedded' or 'independent'
	),
	'post_tag' => array(
		'menu_mode' => 'independent',
	),
	'event_location' => array(
		'menu_mode' => 'independent',
	),
);


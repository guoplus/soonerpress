<?php
/**
 * Post Re-order module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Re-order
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['post-reorder'] = array(
	'blog' => array(
		'menu_mode' => 'independent', // 'embedded' or 'independent'
	),
	'event' => array(
		'menu_mode' => 'independent',
	),
	'slide' => array(
		'menu_mode' => 'embedded',
	),
	'attachment' => array(
		'menu_mode' => 'independent',
	),
	'page' => array(
		'menu_mode' => 'independent',
	),
);


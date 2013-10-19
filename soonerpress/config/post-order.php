<?php
/**
 * Post Re-order module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Re-order
 */


global $sp_config;

$sp_config['post-order'] = array(
	'post' => array(
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


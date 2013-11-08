<?php
/**
 * User Custom Fields module configuration
 *
 * @package SoonerPress
 * @subpackage User_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

if( is_admin() ) {

	global $sp_config;

	$sp_config['user-custom-fields']['sections'][] = array(
		'id' => 'section-social',
		'title' => __( 'Social Network', 'sp' ),
		'fields' => array(
			array(
				'id' => 'social_tw',
				'title' => __( 'Twitter URL', 'sp' ),
				'desc' => __( 'Enter full Twitter link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
				'placeholder' => 'https://twitter.com/',
				'display_column' => 'link',
			),
			array(
				'id' => 'social_fb',
				'title' => __( 'Facebook URL', 'sp' ),
				'desc' => __( 'Enter full Facebook link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
				'placeholder' => 'https://facebook.com/',
				'display_column' => 'link',
			),
			array(
				'id' => 'social_gp',
				'title' => __( 'Google+ URL', 'sp' ),
				'desc' => __( 'Enter full Google+ link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
				'placeholder' => 'https://plus.google.com/',
				'display_column' => 'link',
			),
		)
	);

	$sp_config['user-custom-fields']['sections'][] = array(
		'id' => 'section-test',
		'title' => __( 'Fields Test', 'sp' ),
		'fields' => array(
			array(
				'id' => 'age',
				'title' => __( 'Age', 'sp' ),
				'type' => 'text',
				'ml' => false,
				'display_column' => 'text',
			),
		)
	);

}


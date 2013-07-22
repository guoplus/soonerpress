<?php


/** Init Options Panel */
if( is_admin() ) {

	global $sp_config;

	$sp_config['options']['tabs'][] = array(
		'title' => __( 'General', 'sp' ), // tab name
		'icon' => sp_icon_font( 'home' ), // tab icon
		'fields' => array(
			array(
				'title' => __( 'Global', 'sp' ),
				'type' => 'title', // tab content title
			),
			array(
				'title' => __( 'This is the global settings.', 'sp' ),
				'type' => 'info', // description info text below tab title
			),
			array(
				'id' => 'site_name', // id stored in database
				'title' => __( 'Site Name', 'sp' ),
				'type' => 'text',
				'desc' => 'Enter your website name here.',
				'std' => 'Blog', // default value
			),
			array(
				'id' => 'site_description',
				'title' => __( 'Site Description', 'sp' ),
				'type' => 'textarea',
				'desc' => 'Enter your website description here.',
			),
			array(
				'id' => 'site_biography',
				'title' => __( 'Site Biography', 'sp' ),
				'type' => 'wysiwyg',
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'Header & Footer', 'sp' ),
		'icon' => sp_icon_font( 'columns' ),
		'fields' => array(
			array(
				'title' => __( 'Header', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'This is the header settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'site_logo_url',
				'title' => __( 'Logo', 'sp' ),
				'type' => 'image',
				'desc' => 'Upload a main logo image, size: 300 × 60 (pixels).',
				'std' => SP_IMAGES . '/logo.png',
			),
			array(
				'title' => __( 'Footer', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'This is the footer settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'text_copy',
				'title' => __( 'Copyright Text', 'sp' ),
				'type' => 'wysiwyg',
				'desc' => 'Enter the footer copyright text here, HTML supported.',
				'std' => 'Copyright &copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'sitename' ),
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'Multiple Field', 'sp' ),
		'fields' => array(
			array(
				'id' => 'text_single_multiple',
				'title' => __( 'Single text', 'sp' ),
				'type' => 'text',
				'multiple' => true,
				'desc' => 'A single text repeatable.',
			),
			array(
				'id' => 'text_single_multiple_with_def',
				'title' => __( 'Single text with default value', 'sp' ),
				'type' => 'text',
				'multiple' => true,
				'desc' => 'A single text repeatable.',
				'std' => 'test value',
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'SEO', 'sp' ),
		'icon' => sp_icon_font( 'columns' ),
		'fields' => array(
			array(
				'id' => 'global_title',
				'title' => __( 'Global Title', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'global_description',
				'title' => __( 'Global Description', 'sp' ),
				'type' => 'textarea',
			),
			array(
				'id' => 'global_keywords',
				'title' => __( 'Global Keywords', 'sp' ),
				'type' => 'textarea',
			),
		),
	);

}


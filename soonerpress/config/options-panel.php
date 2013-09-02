<?php


if( is_admin() ) {

	global $sp_config;

	$sp_config['options']['show_header'] = true;
	$sp_config['options']['show_footer'] = true;
	$sp_config['options']['before_form'] = <<< EOTEXT
<h3>Welcome to options panel.</h3>
<p>This is a description test. Using options panel configuration parameter.</p>
<p>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</p>
EOTEXT;
	$sp_config['options']['after_form'] = <<< EOTEXT
<p>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."</p>
<p>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</p>
EOTEXT;

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
				'desc' => __( 'Enter your website name here.', 'sp' ),
				'std' => 'Blog', // default value
			),
			array(
				'id' => 'site_description',
				'title' => __( 'Site Description', 'sp' ),
				'type' => 'textarea',
				'desc' => __( 'Enter your website description here.', 'sp' ),
			),
			array(
				'id' => 'site_biography',
				'title' => __( 'Site Biography', 'sp' ),
				'type' => 'wysiwyg',
			),
			array(
				'id' => 'site_date_built',
				'title' => __( 'Site Built Date', 'sp' ),
				'ml' => false,
				'type' => 'datepicker',
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'List Select', 'sp' ),
		'icon' => sp_icon_font( 'list' ),
		'fields' => array(
			array(
				'id' => 'contactus_pageid',
				'title' => __( 'Page "Contact Us"', 'sp' ),
				'type' => 'pages',
				'desc' => __( 'Select a page to go.', 'sp' ),
			),
			array(
				'id' => 'spokesperson_name',
				'title' => __( 'Spokesperson', 'sp' ),
				'type' => 'select_multi',
				'desc' => __( 'Notice: hold "Ctrl" button and click to select multi choices.', 'sp' ),
				'choices' => array(
					'jason' => __( 'Jason', 'sp' ),
					'bob' => __( 'Bob', 'sp' ),
					'joe' => __( 'Joe', 'sp' ),
					'jenny' => __( 'Jenny', 'sp' ),
					'tom' => __( 'Tom', 'sp' ),
					'jane' => __( 'Jane', 'sp' ),
					'freeman' => __( 'Freeman', 'sp' ),
				),
				'std' => array( 'bob', 'tom', ),
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'File Upload', 'sp' ),
		'icon' => sp_icon_font( 'file' ),
		'fields' => array(
			array(
				'id' => 'readme_file',
				'title' => __( 'File: Readme Document', 'sp' ),
				'desc' => __( 'Please select a .txt file here.', 'sp' ),
				'type' => 'file',
			),
			array(
				'id' => 'extra_file',
				'title' => __( 'Files: Extra Document', 'sp' ),
				'type' => 'file',
				'desc' => __( 'File list.', 'sp' ),
				'multiple' => true,
			),
			array(
				'id' => 'logo',
				'title' => __( 'Image: Logo', 'sp' ),
				'type' => 'image',
				'desc' => __( 'No image size limit.', 'sp' ),
			),
			array(
				'id' => 'photos',
				'title' => __( 'Images: Photo', 'sp' ),
				'type' => 'image',
				'desc' => __( 'Images list.', 'sp' ),
				'multiple' => true,
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
				'id' => 'logo_align',
				'title' => __( 'Logo Alignment', 'sp' ),
				'type' => 'select',
				'choices' => array(
					'left' => __( 'Left', 'sp' ),
					'right' => __( 'Right', 'sp' ),
				),
				'std' => 'right',
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
			array(
				'id' => 'footer_align',
				'title' => __( 'Footer Alignment', 'sp' ),
				'type' => 'radio',
				'choices' => array(
					'left' => __( 'Left', 'sp' ),
					'center' => __( 'Center', 'sp' ),
					'right' => __( 'Right', 'sp' ),
				),
				'std' => 'center',
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'Multiple Field', 'sp' ),
		'icon' => sp_icon_font( 'list-ol' ),
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
		'title' => __( 'Extra Fields', 'sp' ),
		'icon' => sp_icon_font( 'lightbulb' ),
		'fields' => array(
			array(
				'id' => 'my_date',
				'title' => __( 'Date Picker', 'sp' ),
				'type' => 'datepicker',
			),
			array(
				'id' => 'my_color',
				'title' => __( 'Color Selector with title tip', 'sp' ),
				'type' => 'colorselector',
				'choices' => array(
					'#ff0000' => __( 'Red', 'sp' ),
					'#00ff00' => __( 'Green', 'sp' ),
					'#0000ff' => __( 'Blue', 'sp' ),
				),
			),
			array(
				'id' => 'my_color_2',
				'title' => __( 'Color Selector', 'sp' ),
				'type' => 'colorselector',
				'choices' => array(
					'#ff0000', '#00ff00', '#0000ff',
				),
			),
			array(
				'id' => 'my_color_3',
				'title' => __( 'Color Picker', 'sp' ),
				'type' => 'colorpicker',
			),
		),
	);
	$sp_config['options']['tabs'][] = array(
		'title' => __( 'SEO', 'sp' ),
		'icon' => sp_icon_font( 'search' ),
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


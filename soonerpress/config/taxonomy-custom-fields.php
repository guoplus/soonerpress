<?php
/**
 * Taxonomy Custom Fields module configuration
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

if( is_admin() ) {

	global $sp_config;

	$sp_config['taxonomy-custom-fields']['sections'][] = array(
		'taxonomy' => array( 'blog_category' ),
		'fields' => array(
			array(
				'id' => 'thumbnail',
				'title' => __( 'Category Thumbnail', 'sp' ),
				'desc' => __( 'Thumbnail image.', 'sp' ),
				'type' => 'image',
			),
			array(
				'id' => 'features',
				'title' => __( 'Category Features', 'sp' ),
				'desc' => __( 'Features of the category.', 'sp' ),
				'type' => 'text',
				'multiple' => true,
			),
			array(
				'id' => 'event_sponsors',
				'title' => __( 'Sponsors List', 'sp' ),
				'desc' => __( 'Add each sponsor here.', 'sp' ),
				// 'ml' => false,
				'type' => 'group',
				'row_title' => __( 'A Sponsor', 'sp' ),
				'row_name_refer_to' => 'sponsor_name',
				'fields' => array(
					array(
						'id' => 'sponsor_name',
						'title' => __( 'Sponsor Name', 'sp' ),
						'desc' => __( 'Sponsor name Here.', 'sp' ),
						'type' => 'text',
					),
					array(
						'id' => 'sponsor_links',
						'title' => __( 'Sponsor Links', 'sp' ),
						'desc' => __( 'Enter each sponsor link here.', 'sp' ),
						'type' => 'group',
						'row_title' => __( 'A Link', 'sp' ),
						'row_name_refer_to' => 'link_title',
						'fields' => array(
							array(
								'id' => 'link_title',
								'title' => __( 'Link Title', 'sp' ),
								'desc' => __( 'Enter title of link here.', 'sp' ),
								'type' => 'text',
							),
							array(
								'id' => 'link_url',
								'title' => __( 'Sponsor Links', 'sp' ),
								'desc' => __( 'Enter URL of link here.', 'sp' ),
								'placeholder' => 'http://',
								'multiple' => true,
								'type' => 'text',
							),
						),
					),
				),
			),
		)
	);

	$sp_config['taxonomy-custom-fields']['sections'][] = array(
		'taxonomy' => array( 'blog_tag' ),
		'ml' => false,
		'fields' => array(
			array(
				'id' => 'tag_color',
				'title' => __( 'Category Title', 'sp' ),
				'desc' => __( 'Enter the category title.', 'sp' ),
				'type' => 'colorpicker',
			),
			array(
				'id' => 'document_readme',
				'title' => __( 'Document: Readme', 'sp' ),
				'desc' => __( 'Upload a text document here.', 'sp' ),
				'type' => 'file',
			),
			array(
				'id' => 'tag_type',
				'title' => __( 'Tag Type', 'sp' ),
				'desc' => __( 'Select a type of tag.', 'sp' ),
				'type' => 'select',
				'choices' => array(
					'apple' => __( 'Apple', 'sp' ),
					'banana' => __( 'Banana', 'sp' ),
					'orange' => __( 'Orange', 'sp' ),
				),
				'std' => 'banana',
			),
		)
	);

}


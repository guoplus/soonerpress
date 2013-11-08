<?php
/**
 * Post Custom Fields module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

if( is_admin() ) {

	global $sp_config;

	// slide
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-slide-1',
		'cond' => array(
			'post_type' => array( 'slide' ),
		),
		'title' => __( 'Slide Properties', 'sp' ),
		'fields' => array(
			array(
				'id' => 'slide_title',
				'title' => __( 'Slide Title', 'sp' ),
				'desc' => __( 'Display on the right of the slide.', 'sp' ),
				'display_column' => 'text',
				'type' => 'text',
			),
			array(
				'id' => 'slide_image',
				'title' => __( 'Slide Image', 'sp' ),
				'desc' => __( 'Image size: 960 × 240 (pixels).', 'sp' ),
				'display_column' => 'image',
				'type' => 'image',
			),
			array(
				'id' => 'slide_description',
				'title' => __( 'Slide Content', 'sp' ),
				'desc' => __( 'Display on the right of the slide.', 'sp' ),
				'type' => 'wysiwyg',
			),
		)
	);

	// event
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-event-1',
		'cond' => array(
			'post_type' => array( 'event' ),
		),
		'title' => __( 'Event Properties', 'sp' ),
		'fields' => array(
			array(
				'id' => 'event_image',
				'title' => __( 'Event Banner Image', 'sp' ),
				'desc' => __( 'Image size: 960 × 240 (pixels).', 'sp' ),
				'type' => 'image',
				'display_column' => 'image',
			),
			array(
				'id' => 'event_thumb',
				'title' => __( 'Event Thumbnail Image', 'sp' ),
				'desc' => __( 'Image size: 128 × 128 (pixels).', 'sp' ),
				'type' => 'image',
				'display_column' => 'image',
			),
			array(
				'id' => 'is_featured',
				'title' => __( 'Is Featured?', 'sp' ),
				'type' => 'on_off',
				'ml' => false,
			),
			array(
				'id' => 'event_date',
				'title' => __( 'Event Show Date', 'sp' ),
				'desc' => __( 'A date for show.', 'sp' ),
				'ml' => false,
				'type' => 'datepicker',
				'display_column' => 'text',
			),
			array(
				'id' => 'event_age_limit',
				'title' => __( 'Event Minimum Age Limit', 'sp' ),
				'desc' => __( 'The minimum age of the event', 'sp' ),
				'ml' => false,
				'type' => 'select',
				'choices' => array(
					'16' => '16+', '18' => '18+', '21' => '21+', 
				),
				'std' => '18',
				'display_column' => 'text',
		),
			array(
				'id' => 'event_links',
				'title' => __( 'Event Links', 'sp' ),
				'desc' => __( 'Social links for the event.', 'sp' ),
				'ml' => false,
				'multiple' => true,
				'type' => 'text',
			),
		)
	);
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-event-2',
		'cond' => array(
			'post_type' => array( 'event' ),
		),
		'title' => __( 'Event Sponsors', 'sp' ),
		'fields' => array(
			array(
				'id' => 'event_sponsors',
				'title' => __( 'Sponsors List', 'sp' ),
				'desc' => __( 'Add each sponsor here.', 'sp' ),
				// 'ml' => false,
				'type' => 'group', // 'multiple' => true <<< can be ignored
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
						'id' => 'sponsor_logo_image',
						'title' => __( 'Sponsor Logo Image', 'sp' ),
						'desc' => __( 'Image size: 128 × 128 (pixels).', 'sp' ),
						'type' => 'image',
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
								'title' => __( 'Link URL', 'sp' ),
								'desc' => __( 'Enter URL of link here.', 'sp' ),
								'placeholder' => 'http://',
								'type' => 'text',
							),
						),
					),
				),
			),
		),
	);

	// branch
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-branch-1',
		'cond' => array(
			'post_type' => array( 'branch' ),
		),
		'title' => __( 'Branch Properties', 'sp' ),
		'fields' => array(
			array(
				'id' => 'branch_address',
				'title' => __( 'Branch Address', 'sp' ),
				'desc' => __( 'Enter a full address to go.', 'sp' ),
				'display_column' => 'text',
				'type' => 'google_maps',
			),
		)
	);

	// portfolio
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-portfolio-1',
		'cond' => array(
			'post_type' => array( 'portfolio' ),
		),
		'title' => __( 'Portfolio Settings', 'sp' ),
		'fields' => array(
			array(
				'id' => 'portfolio_format',
				'title' => __( 'Portfolio Format', 'sp' ),
				'type' => 'radio',
				'choices' => array(
					'photo' => __( 'Photo' ),
					'video' => __( 'Video' ),
				),
				'std' => 'photo',
				'ml' => false,
			),
		),
	);
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-portfolio-photo',
		'cond' => array(
			'post_type' => array( 'portfolio' ),
		),
		'show_section_when' => array(
			'portfolio_format' => 'photo',
		),
		'title' => __( 'Photo Portfolio Settings', 'sp' ),
		'fields' => array(
			array(
				'id' => 'portfolio_photo_url',
				'title' => __( 'Photo Main Image', 'sp' ),
				'type' => 'image',
				'ml' => false,
			),
		),
	);
	$sp_config['post-custom-fields']['sections'][] = array(
		'id' => 'section-portfolio-video',
		'cond' => array(
			'post_type' => array( 'portfolio' ),
		),
		'show_section_when' => array(
			'portfolio_format' => array( 'video' ),
		),
		'title' => __( 'Video Portfolio Settings', 'sp' ),
		'fields' => array(
			array(
				'id' => 'portfolio_video_url',
				'title' => __( 'Video File', 'sp' ),
				'type' => 'file',
				'ml' => false,
			),
		),
	);


}


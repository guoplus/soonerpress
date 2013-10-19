<?php
/**
 * Post Custom Meta module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Custom_Meta
 */


if( is_admin() ) {

	global $sp_config;

	// slide
	$sp_config['post-custom-meta']['boxes'][] = array(
		'id' => 'box-slide-1',
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
				'id' => 'slide_description',
				'title' => __( 'Slide Content', 'sp' ),
				'desc' => __( 'Display on the right of the slide.', 'sp' ),
				'type' => 'wysiwyg',
			),
			array(
				'id' => 'slide_image',
				'title' => __( 'Slide Image', 'sp' ),
				'desc' => __( 'Image size: 960 × 240 (pixels).', 'sp' ),
				'display_column' => 'image',
				'type' => 'image',
			),
			array(
				'id' => 'slide_level',
				'title' => __( 'Slide Level', 'sp' ),
				'desc' => __( 'Level of the slide.', 'sp' ),
				'ml' => false,
				'type' => 'text',
				'std' => '15',
			),
		)
	);

	// event
	$sp_config['post-custom-meta']['boxes'][] = array(
		'id' => 'box-event-1',
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
			),
			array(
				'id' => 'event_thumb',
				'title' => __( 'Event Thumbnail Image', 'sp' ),
				'desc' => __( 'Image size: 128 × 128 (pixels).', 'sp' ),
				'type' => 'image',
			),
			array(
				'id' => 'event_date',
				'title' => __( 'Event Show Date', 'sp' ),
				'desc' => __( 'A date for show.', 'sp' ),
				'ml' => false,
				'type' => 'datepicker',
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
			),
			array(
				'id' => 'event_info',
				'title' => __( 'Event Additional Information', 'sp' ),
				'desc' => __( 'Detail information for the event.', 'sp' ),
				'type' => 'wysiwyg',
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
	$sp_config['post-custom-meta']['boxes'][] = array(
		'id' => 'box-event-2',
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
				'row_title' => __( 'Sponsor', 'sp' ),
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
						'id' => 'sponsor_description',
						'title' => __( 'Sponsor Description', 'sp' ),
						'desc' => __( 'Sponsor description Here.', 'sp' ),
						'type' => 'text',
					),
					array(
						'id' => 'sponsor_links',
						'title' => __( 'Sponsor Links', 'sp' ),
						'desc' => __( 'Enter each sponsor link here.', 'sp' ),
						'placeholder' => 'http://',
						'multiple' => true,
						'type' => 'text',
					),
				),
			),
		),
	);

}


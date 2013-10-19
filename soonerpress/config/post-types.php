<?php
/**
 * Post Types module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Types
 */


/** Register Post Types */
function sp_register_post_types() {

	// This is a sample configuration, edit or delete it, then start developing :-)

	register_post_type( 'slide', array(
		'labels' => array(
			'name' => _x( 'Slides', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Slide', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Main Slider', 'sp' ),
			'all_items' => __( 'All Slides', 'sp' ),
			'add_new' => _X( 'Add New', 'slide', 'sp' ),
			'add_new_item' => __( 'Add New Slide', 'sp' ),
			'edit_item' => __( 'Edit Slide', 'sp' ),
			'new_item' => __( 'New Slide', 'sp' ),
			'view_item' => __( 'View Slide', 'sp' ),
			'search_item' => __( 'Search Slides', 'sp' ),
			'not_found' => __( 'No slides found.', 'sp' ),
			'not_found_in_trash' => __( 'No slides found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Slide', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-slides' ),
		'supports' => array( 'title' )
	) );

	register_post_type( 'event', array(
		'labels' => array(
			'name' => _x( 'Events', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Event', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Events', 'sp' ),
			'all_items' => __( 'All Events', 'sp' ),
			'add_new' => _X( 'Add New', 'event', 'sp' ),
			'add_new_item' => __( 'Add New Event', 'sp' ),
			'edit_item' => __( 'Edit Event', 'sp' ),
			'new_item' => __( 'New Event', 'sp' ),
			'view_item' => __( 'View Event', 'sp' ),
			'search_item' => __( 'Search Events', 'sp' ),
			'not_found' => __( 'No events found.', 'sp' ),
			'not_found_in_trash' => __( 'No events found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Event', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-events' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

	register_post_type( 'news', array(
		'labels' => array(
			'name' => _x( 'News', 'post type general name', 'sp' ),
			'singular_name' => _x( 'News', 'post type singular name', 'sp' ),
			'menu_name' => __( 'News', 'sp' ),
			'all_items' => __( 'All News', 'sp' ),
			'add_new' => _X( 'Add New', 'news', 'sp' ),
			'add_new_item' => __( 'Add New News', 'sp' ),
			'edit_item' => __( 'Edit News', 'sp' ),
			'new_item' => __( 'New News', 'sp' ),
			'view_item' => __( 'View News', 'sp' ),
			'search_item' => __( 'Search News', 'sp' ),
			'not_found' => __( 'No news found.', 'sp' ),
			'not_found_in_trash' => __( 'No news found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent News', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-news' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

}
add_action( 'init', 'sp_register_post_types' );


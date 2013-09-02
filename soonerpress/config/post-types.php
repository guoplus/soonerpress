<?php


/** Register Post Types */
function sp_register_post_types() {

	// This is a sample configuration, edit or delete it, then start developing :-)

	register_post_type( 'type_slide', array(
		'labels' => array(
			'name' => _x( 'Slides', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Slide', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Main Slider', 'sp' ),
			'all_items' => __( 'All Slides', 'sp' ),
			'add_new' => _X( 'Add New', 'type_slide', 'sp' ),
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

	register_post_type( 'type_event', array(
		'labels' => array(
			'name' => _x( 'Events', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Event', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Events', 'sp' ),
			'all_items' => __( 'All Events', 'sp' ),
			'add_new' => _X( 'Add New', 'type_event', 'sp' ),
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

	register_post_type( 'type_artist', array(
		'labels' => array(
			'name' => _x( 'Artists', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Artist', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Artists', 'sp' ),
			'all_items' => __( 'All Artists', 'sp' ),
			'add_new' => _X( 'Add New', 'type_artist', 'sp' ),
			'add_new_item' => __( 'Add New Artist', 'sp' ),
			'edit_item' => __( 'Edit Artist', 'sp' ),
			'new_item' => __( 'New Artist', 'sp' ),
			'view_item' => __( 'View Artist', 'sp' ),
			'search_item' => __( 'Search Artists', 'sp' ),
			'not_found' => __( 'No artists found.', 'sp' ),
			'not_found_in_trash' => __( 'No artists found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Artist', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-artists' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

}
add_action( 'init', 'sp_register_post_types' );


<?php


/** Register Post Types */
function sp_register_post_types() {

	register_post_type( 'type_slide', array(
		'labels' => array(
			'name' => _x( 'Slides', 'post type general name' ),
			'singular_name' => _x( 'Slide', 'post type singular name' ),
			'menu_name' => __( 'Main Slider' ),
			'all_items' => __( 'All Slides' ),
			'add_new' => _X( 'Add New', 'type_slide' ),
			'add_new_item' => __( 'Add New Slide' ),
			'edit_item' => __( 'Edit Slide' ),
			'new_item' => __( 'New Slide' ),
			'view_item' => __( 'View Slide' ),
			'search_item' => __( 'Search Slides' ),
			'not_found' => __( 'No slides found.' ),
			'not_found_in_trash' => __( 'No slides found in Trash.' ),
			'parent_item_colon' => __( 'Parent Slide' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-slides' ),
		'supports' => array( 'title' )
	) );

	register_post_type( 'type_artist', array(
		'labels' => array(
			'name' => _x( 'Artists', 'post type general name' ),
			'singular_name' => _x( 'Artist', 'post type singular name' ),
			'menu_name' => __( 'Artists' ),
			'all_items' => __( 'All Artists' ),
			'add_new' => _X( 'Add New', 'type_artist' ),
			'add_new_item' => __( 'Add New Artist' ),
			'edit_item' => __( 'Edit Artist' ),
			'new_item' => __( 'New Artist' ),
			'view_item' => __( 'View Artist' ),
			'search_item' => __( 'Search Artists' ),
			'not_found' => __( 'No artists found.' ),
			'not_found_in_trash' => __( 'No artists found in Trash.' ),
			'parent_item_colon' => __( 'Parent Artist' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-artists' ),
		'supports' => array( 'title' )
	) );

}
add_action( 'init', 'sp_register_post_types' );


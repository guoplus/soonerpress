<?php
/**
 * Post Types module configuration
 *
 * @package SoonerPress
 * @subpackage Post_Types
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

/** Register Post Types */
function _sp_register_post_types() {

	register_post_type( 'blog', array(
		'labels' => array(
			'name' => _x( 'Blog Posts', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Post', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Blog Posts', 'sp' ),
			'all_items' => __( 'All Posts', 'sp' ),
			'add_new' => _X( 'Add New', 'blog', 'sp' ),
			'add_new_item' => __( 'Add New Post', 'sp' ),
			'edit_item' => __( 'Edit Post', 'sp' ),
			'new_item' => __( 'New Post', 'sp' ),
			'view_item' => __( 'View Post', 'sp' ),
			'search_item' => __( 'Search Posts', 'sp' ),
			'not_found' => __( 'No posts found.', 'sp' ),
			'not_found_in_trash' => __( 'No posts found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Post', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-blog' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

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
		'rewrite' => array( 'slug' => 'archive-slide' ),
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
		'rewrite' => array( 'slug' => 'archive-event' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

	register_post_type( 'portfolio', array(
		'labels' => array(
			'name' => _x( 'Portfolios', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Portfolio', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Portfolios', 'sp' ),
			'all_items' => __( 'All Portfolios', 'sp' ),
			'add_new' => _X( 'Add New', 'portfolio', 'sp' ),
			'add_new_item' => __( 'Add New Portfolio', 'sp' ),
			'edit_item' => __( 'Edit Portfolio', 'sp' ),
			'new_item' => __( 'New Portfolio', 'sp' ),
			'view_item' => __( 'View Portfolio', 'sp' ),
			'search_item' => __( 'Search Portfolios', 'sp' ),
			'not_found' => __( 'No portfolios found.', 'sp' ),
			'not_found_in_trash' => __( 'No portfolios found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Portfolio', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-portfolio' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

	register_post_type( 'pricing', array(
		'labels' => array(
			'name' => _x( 'Pricing', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Pricing', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Pricing', 'sp' ),
			'all_items' => __( 'All Pricing', 'sp' ),
			'add_new' => _X( 'Add New', 'pricing', 'sp' ),
			'add_new_item' => __( 'Add New Pricing', 'sp' ),
			'edit_item' => __( 'Edit Pricing', 'sp' ),
			'new_item' => __( 'New Pricing', 'sp' ),
			'view_item' => __( 'View Pricing', 'sp' ),
			'search_item' => __( 'Search Pricing', 'sp' ),
			'not_found' => __( 'No pricing found.', 'sp' ),
			'not_found_in_trash' => __( 'No pricing found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Portfolio', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-pricing' ),
		'supports' => array( 'title', 'editor', 'excerpt' )
	) );

	register_post_type( 'branch', array(
		'labels' => array(
			'name' => _x( 'Branches', 'post type general name', 'sp' ),
			'singular_name' => _x( 'Branch', 'post type singular name', 'sp' ),
			'menu_name' => __( 'Branches', 'sp' ),
			'all_items' => __( 'All Branches', 'sp' ),
			'add_new' => _X( 'Add New', 'branch', 'sp' ),
			'add_new_item' => __( 'Add New Branch', 'sp' ),
			'edit_item' => __( 'Edit Branch', 'sp' ),
			'new_item' => __( 'New Branch', 'sp' ),
			'view_item' => __( 'View Branch', 'sp' ),
			'search_item' => __( 'Search Branches', 'sp' ),
			'not_found' => __( 'No branches found.', 'sp' ),
			'not_found_in_trash' => __( 'No branches found in Trash.', 'sp' ),
			'parent_item_colon' => __( 'Parent Branch', 'sp' ),
		),
		'menu_position' => 5,
		'public' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'archive-branch' ),
		'supports' => array( 'title', 'editor' )
	) );

}
add_action( 'init', '_sp_register_post_types' );


<?php
/**
 * Taxonomies module configuration
 *
 * @package SoonerPress
 * @subpackage Taxonomies
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

/** Register Taxonomies */
function _sp_register_taxonomies() {

	register_taxonomy(
		'blog_category',
		'blog',
		array(
			'labels' => array(
				'name' => _x( 'Categories', 'taxonomy general name', 'sp' ),
				'singular_name' => _x( 'Category', 'taxonomy singular name', 'sp' ),
				'menu_name' => __( 'Blog Categories', 'sp' ),
				'all_items' => __( 'All Categories', 'sp' ),
				'edit_item' => __( 'Edit Category', 'sp' ),
				'view_item' => __( 'View Category', 'sp' ),
				'update_item' => __( 'Update Category', 'sp' ),
				'add_new_item' => __( 'Add New Category', 'sp' ),
				'new_item_name' => __( 'New Category Name', 'sp' ),
				'parent_item' => __( 'Parent Category', 'sp' ),
				'parent_item_colon' => __( 'Parent Category:', 'sp' ),
				'search_items' => __( 'Search Categories', 'sp' ),
				'popular_items' => __( 'Popular Categories', 'sp' ),
			),
			'hierarchical' => true,
			'query_var' => 'blog_category',
			'rewrite' => array( 'slug' => 'archive-blog-category' ),
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => false,
		)
	);

	register_taxonomy(
		'blog_tag',
		'blog',
		array(
			'labels' => array(
				'name' => _x( 'Tags', 'taxonomy general name', 'sp' ),
				'singular_name' => _x( 'Tag', 'taxonomy singular name', 'sp' ),
				'menu_name' => __( 'Blog Tags', 'sp' ),
				'all_items' => __( 'All Tags', 'sp' ),
				'edit_item' => __( 'Edit Tag', 'sp' ),
				'view_item' => __( 'View Tag', 'sp' ),
				'update_item' => __( 'Update Tag', 'sp' ),
				'add_new_item' => __( 'Add New Tag', 'sp' ),
				'new_item_name' => __( 'New Tag Name', 'sp' ),
				'parent_item' => __( 'Parent Tag', 'sp' ),
				'parent_item_colon' => __( 'Parent Tag:', 'sp' ),
				'search_items' => __( 'Search Tags', 'sp' ),
				'popular_items' => __( 'Popular Tags', 'sp' ),
			),
			'hierarchical' => false,
			'query_var' => 'blog_tag',
			'rewrite' => array( 'slug' => 'archive-blog-tag' ),
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => true,
		)
	);

	register_taxonomy(
		'event_feature',
		'event',
		array(
			'labels' => array(
				'name' => _x( 'Features', 'taxonomy general name', 'sp' ),
				'singular_name' => _x( 'Feature', 'taxonomy singular name', 'sp' ),
				'menu_name' => __( 'Features', 'sp' ),
				'all_items' => __( 'All Features', 'sp' ),
				'edit_item' => __( 'Edit Feature', 'sp' ),
				'view_item' => __( 'View Feature', 'sp' ),
				'update_item' => __( 'Update Feature', 'sp' ),
				'add_new_item' => __( 'Add New Feature', 'sp' ),
				'new_item_name' => __( 'New Feature Name', 'sp' ),
				'parent_item' => __( 'Parent Feature', 'sp' ),
				'parent_item_colon' => __( 'Parent Feature:', 'sp' ),
				'search_items' => __( 'Search Features', 'sp' ),
				'popular_items' => __( 'Popular Features', 'sp' ),
			),
			'hierarchical' => false,
			'rewrite' => array( 'slug' => 'archive-event-feature' ),
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'public' => true,
			'show_ui' => true,
			'show_tagcloud' => false,
		)
	);

	register_taxonomy(
		'event_location',
		'event',
		array(
			'labels' => array(
				'name' => _x( 'Locations', 'taxonomy general name', 'sp' ),
				'singular_name' => _x( 'Location', 'taxonomy singular name', 'sp' ),
				'menu_name' => __( 'Locations', 'sp' ),
				'all_items' => __( 'All Locations', 'sp' ),
				'edit_item' => __( 'Edit Location', 'sp' ),
				'view_item' => __( 'View Location', 'sp' ),
				'update_item' => __( 'Update Location', 'sp' ),
				'add_new_item' => __( 'Add New Location', 'sp' ),
				'new_item_name' => __( 'New Location Name', 'sp' ),
				'parent_item' => __( 'Parent Location', 'sp' ),
				'parent_item_colon' => __( 'Parent Location:', 'sp' ),
				'search_items' => __( 'Search Locations', 'sp' ),
				// 'popular_items' => __( 'Popular Locations', 'sp' ),
			),
			'hierarchical' => false,
			'rewrite' => array( 'slug' => 'archive-event-location' ),
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'public' => true,
			'show_ui' => true,
			'show_tagcloud' => false,
		)
	);

	register_taxonomy(
		'branch_property',
		'branch',
		array(
			'labels' => array(
				'name' => _x( 'Properties', 'taxonomy general name', 'sp' ),
				'singular_name' => _x( 'Property', 'taxonomy singular name', 'sp' ),
				'menu_name' => __( 'Properties', 'sp' ),
				'all_items' => __( 'All Properties', 'sp' ),
				'edit_item' => __( 'Edit Property', 'sp' ),
				'view_item' => __( 'View Property', 'sp' ),
				'update_item' => __( 'Update Property', 'sp' ),
				'add_new_item' => __( 'Add New Property', 'sp' ),
				'new_item_name' => __( 'New Property Name', 'sp' ),
				'parent_item' => __( 'Parent Property', 'sp' ),
				'parent_item_colon' => __( 'Parent Property:', 'sp' ),
				'search_items' => __( 'Search Properties', 'sp' ),
				// 'popular_items' => __( 'Popular Properties', 'sp' ),
			),
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'archive-event-location' ),
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'public' => true,
			'show_ui' => true,
			'show_tagcloud' => false,
		)
	);

}
add_action( 'init', '_sp_register_taxonomies' );


/** Unregister Taxonomies */
function _sp_unregister_taxonomies() {
	global $wp_taxonomies;
	foreach( array( /*'category', 'post_tag',*/ ) as $taxonomy )
		if( taxonomy_exists( $taxonomy ) )
			unset( $wp_taxonomies[$taxonomy] );
}
add_action( 'init', '_sp_unregister_taxonomies' );


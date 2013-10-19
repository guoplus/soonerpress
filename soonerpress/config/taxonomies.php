<?php
/**
 * Taxonomies module configuration
 *
 * @package SoonerPress
 * @subpackage Taxonomies
 */


/** Register Taxonomies */
function sp_register_taxonomies() {

	// This is a sample configuration, edit or delete it, then start developing :-)

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
add_action( 'init', 'sp_register_taxonomies' );


/** Unregister Taxonomies */
function _sp_unregister_taxonomies() {
	global $wp_taxonomies;
	foreach( array( /*'category', 'post_tag',*/ ) as $taxonomy )
		if( taxonomy_exists( $taxonomy ) )
			unset( $wp_taxonomies[$taxonomy] );
}
add_action( 'init', '_sp_unregister_taxonomies' );


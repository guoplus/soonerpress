<?php


/** Register Taxonomies */
function sp_register_taxonomies() {

	// This is a sample configuration, edit or delete it, then start developing :-)

	$taxonomy_labels = array(
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
		'popular_items' => __( 'Popular Locations', 'sp' ),
	);

	register_taxonomy(
		'tax_event_location',
		array( 'type_event' ),
		array(
			'labels' => $taxonomy_labels,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'archive-event-location' ),
			'public' => true,
			'show_ui' => true,
			'show_tagcloud' => false,
		)
	);

}
add_action( 'init', 'sp_register_taxonomies' );


global $sp_config;

/** Unregister Taxonomies */
$sp_config['taxonomies']['unregister'] = array(
	// 'category',
	// 'post_tag',
);


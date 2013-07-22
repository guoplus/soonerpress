<?php


/** Register Taxonomies */
function sp_register_taxonomies() {

	$taxonomy_labels = array(
		'name' => _x( 'Genres', 'taxonomy general name' ),
		'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
		'search_items' => __( 'Search Genres' ),
		'popular_items' => __( 'Popular Tags' ),
		'all_items' => __( 'All Genres' ),
		'parent_item' => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item' => __( 'Edit Genre' ),
		'view_item' => __( 'View Genre' ),
		'update_item' => __( 'Update Genre' ),
		'add_new_item' => __( 'Add New Genre' ),
		'new_item_name' => __( 'New Genre Name' ),
	);

	register_taxonomy(
		'tax_artist_genre',
		array( 'type_artist' ),
		array(
			'labels' => $taxonomy_labels,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'archive-post-genre' ),
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


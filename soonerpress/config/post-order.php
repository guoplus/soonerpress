<?php


/** init configuration for post order */
function _sp_post_order_config_init() {
	$options = array(
		'autosort' => 2,
		'adminsort' => 1,
		'capability' => 'edit_posts',
		// 'code_version' => '2.5.7.6',
		'ignore_sticky_posts' => 0,
		'apto_tables_created' => 1,
		'feedsort' => 1,
		'always_show_thumbnails' => 0,
		'ignore_supress_filters' => 0,
		'bbpress_replies_reverse_order' => 0,
		'allow_post_types' => array(
			'type_slide',
		)
	);
	update_option( 'cpto_options', $options );
}
add_action( 'after_setup_theme', '_sp_post_order_config_init' ); 


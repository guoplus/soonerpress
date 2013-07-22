<?php


/** Unregister taxonomies */
function sp_unregister_taxonomies() {
	global $sp_config, $wp_taxonomies;
	if( $sp_config['taxonomies']['unregister'] )
		foreach( $sp_config['taxonomies']['unregister'] as $taxonomy )
			if( taxonomy_exists( $taxonomy ) )
				unset( $wp_taxonomies[$taxonomy] );
}
add_action( 'init', 'sp_unregister_taxonomies' );


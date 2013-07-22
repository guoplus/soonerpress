<?php


/** Init Taxonomy Custom Metadata */
function sp_init_taxonomy_custom_meta() {

	add_tm( 'taxonomy', array(
		array( 'id' => 'slug_tm0', 'type' => 'text', 'title' => 'Max. Count', 'desc' => 'Enter the maximum count.' ),
		array( 'id' => 'slug_tm1', 'type' => 'text', 'title' => 'Min. Count', 'desc' => 'Enter the minimum count.' ),
	) );

}
add_action( 'sp_init_taxonomy_custom_meta', 'sp_init_taxonomy_custom_meta' );


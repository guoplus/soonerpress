<?php


/** Init User Custom Metadata */
function sp_init_user_custom_meta() {

	add_um( array(
		array( 'id' => 'slug_um0', 'type' => 'text', 'title' => 'Twitter', 'desc' => 'Enter your Twitter ID.' ),
		array( 'id' => 'slug_um1', 'type' => 'text', 'title' => 'Instagram', 'desc' => 'Enter your Instagram ID.' ),
		array( 'id' => 'slug_um2', 'type' => 'select', 'title' => 'Gender', 'desc' => 'Select your gender.', 'options' => array( 'male' => 'Male', 'female' => 'Female' ) ),
	) );

}
add_action( 'sp_init_user_custom_meta', 'sp_init_user_custom_meta' );


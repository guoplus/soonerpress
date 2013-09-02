<?php


if( is_admin() ) {

	global $sp_config;

	$sp_config['user_custom_meta']['fields'] = array(
		array( 'id' => 'slug_um2', 'type' => 'select', 'title' => 'Gender', 'desc' => 'Select your gender.', 'options' => array( 'male' => 'Male', 'female' => 'Female' ) ),
		array( 'id' => 'slug_um0', 'type' => 'text', 'title' => 'Twitter', 'desc' => 'Enter your Twitter ID.' ),
		array( 'id' => 'slug_um1', 'type' => 'text', 'title' => 'Instagram', 'desc' => 'Enter your Instagram ID.' ),
	);

}


<?php


/** add to admin menu */
function _sp_ml_add_page() {
	global $sp_config;
	add_menu_page( __( 'Multilingual', 'sp' ), __( 'Multilingual', 'sp' ), 'manage_options', 'multilingual', '_sp_ml_do_html', false, 120 );
}
add_action( 'admin_menu', '_sp_ml_add_page' );


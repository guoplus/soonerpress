<?php


/** Register Navigation Menus */
function sp_register_nav_menus() {
	global $sp_config;
	foreach ( $sp_config['menus'] as $menu_id => $menu_name ) {
		register_nav_menu( $menu_id, $menu_name );
	}
}
add_action( 'init', 'sp_register_nav_menus' );


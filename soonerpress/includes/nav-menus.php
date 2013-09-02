<?php


/** register navigation menus */
function _sp_register_nav_menus() {
	global $sp_config;
	if( isset( $sp_config['menus'] ) && sizeof( $sp_config['menus'] ) ) {
		register_nav_menus( apply_filters( 'sp_menus_config', $sp_config['menus'] ) );
	}
}
add_action( 'init', '_sp_register_nav_menus' );

/** process menu HTML output */
function sp_nav_menu( $theme_location, $menu_class, $menu_id, $depth, $args_extra = array(), $lang = '' ) {
	if( empty( $lang ) && sp_enabled_module( 'multi-language' ) )
		$lang = sp_ml_lang();
	$args = $args_extra;
	$args['theme_location'] = ( empty( $lang ) ? $theme_location : $theme_location . '-' . $lang );
	$args['menu_class']     = $menu_class;
	$args['menu_id']        = $menu_id;
	$args['depth']          = $depth;
	$args = wp_parse_args( $args, array(
		'container' => false,
	) );
	wp_nav_menu( $args );
}


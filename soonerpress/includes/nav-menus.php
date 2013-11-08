<?php
/**
 * Navigation Menus module API
 *
 * @package SoonerPress
 * @subpackage Navigation_Menus
 */

if ( ! defined( 'IN_SP' ) ) exit;


/** process menu HTML output */
function sp_nav_menu( $theme_location, $menu_class, $menu_id, $depth = 0, $args_extra = array(), $locale = '' ) {
	if( sp_module_enabled( 'multilingual' ) && empty( $locale ) )
		$locale = sp_lang();
	$args = $args_extra;global $_sp_enabled_modules;
	$args['theme_location'] = ( empty( $locale ) ? $theme_location : $theme_location . '-' . $locale );
	$args['menu_class']     = $menu_class;
	$args['menu_id']        = $menu_id;
	$args['depth']          = $depth;
	$args = wp_parse_args( $args, array(
		'container_class' => $args['theme_location'] . '-container',
		'container_id'    => $args['theme_location'] . '-container',
	) );
	return wp_nav_menu( $args );
}


class SP_Nav_Menus extends SP_Module {

	function __construct() {
		$this->init( 'nav-menus' );
		add_action( 'init', array( $this, 'register_nav_menus' ) );
	}

	function register_nav_menus() {
		if( sizeof( $this->c ) )
			register_nav_menus( apply_filters( 'sp_register_nav_menus', $this->c ) );
	}

}

new SP_Nav_Menus();


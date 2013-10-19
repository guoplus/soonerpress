<?php
/**
 * Framework Setup First
 *
 * @package SoonerPress
 * @subpackage Framework_Environment
 */


function sp_after_setup_theme() {

	load_theme_textdomain( 'sp', SP_LANG );

}
add_action( 'after_setup_theme', 'sp_after_setup_theme' );


function sp_wp_title_filter( $title, $sep ) {
	global $page, $paged;
	if ( is_feed() )
		return $title;
	if ( $paged >= 2 || $page >= 2 )
		$title .= sprintf( __( 'Page %s', 'sp' ), max( $paged, $page ) ) . ' ' . $sep . ' ';
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= ' ' . $sep . ' ' . $site_description;
	return $title;
}
add_filter( 'wp_title', 'sp_wp_title_filter', 10, 2 );


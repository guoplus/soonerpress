<?php
/**
 * Theme Setup module configuration
 *
 * @package SoonerPress
 * @subpackage Theme_Setup
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

/** configure theme properties */
function _sp_theme_setup() {

	add_theme_support( 'post-thumbnails', array( 'blog', 'product' ) );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );

	add_image_size( 'slide', 960, 300, true );

	add_editor_style();

}
add_action( 'after_setup_theme', '_sp_theme_setup' );


/** Enqueue scripts & styles for Front-end */
function _sp_enqueue_assets_frontpage() {

	wp_enqueue_style( 'web.frontpage', get_stylesheet_uri(), array(), false, 'all' );
	wp_enqueue_style( 'web.fonts', SP_FONTS . '/stylesheet.css', array(), false, 'all' );

	wp_enqueue_script( 'jquery' );
	// sp_enqueue_jquery_own();
	wp_enqueue_script( 'jquery.migrate' );
	wp_enqueue_script( 'jquery.placeholder' );
	wp_enqueue_script( 'google.maps' );
	wp_enqueue_script( 'gmaps' );
	wp_enqueue_style( 'jquery.flexslider' );
	wp_enqueue_script( 'jquery.flexslider' );
	wp_enqueue_script( 'web.library', SP_JS . '/web.library.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'web.frontpage', SP_JS . '/web.frontpage.js', array( 'jquery' ), false, true );

	if ( is_singular() && comments_open() )
		wp_enqueue_script( 'comment-reply' );

	// data (parameters) transfer to front-end JS
	wp_localize_script( 'web.library', 'sp', array(
	) );

}
add_action( 'wp_enqueue_scripts', '_sp_enqueue_assets_frontpage' );


/** Enqueue scripts & styles for Back-end */
function _sp_enqueue_assets_dashboard() {

	wp_enqueue_style( 'web.dashboard', SP_CSS . '/web.dashboard.css', array(), false, 'all' );
	wp_enqueue_script( 'web.library', SP_JS . '/web.library.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'web.dashboard', SP_JS . '/web.dashboard.js', array( 'jquery' ), false, true );

	wp_localize_script( 'web.library', 'sp', array(
	) );

}
add_action( 'admin_enqueue_scripts', '_sp_enqueue_assets_dashboard' );


/** remove version parameter in HTML head script and stylesheet src */
function _sp_remove_asset_loader_src_version( $src ) {
	return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', '_sp_remove_asset_loader_src_version', 15 );
add_filter( 'style_loader_src', '_sp_remove_asset_loader_src_version', 15 );


/** force media editor to display "Insert into post" button for a non-editor post type */
function of_media_items_args( $args ) {
	$args['send'] = true;
	return $args;
}
add_filter( 'get_media_item_args', 'of_media_items_args' );


<?php


/** configure theme properties */
function _sp_theme_setup() {

	add_theme_support( 'post-thumbnails', array( 'news', 'product' ) );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	add_image_size( 'slider', 960, 300, true );

	add_editor_style();

	add_theme_support( 'automatic-feed-links' );

}
add_action( 'after_setup_theme', '_sp_theme_setup' );


/** Enqueue scripts & styles for Front-end */
function _sp_enqueue_assets_frontpage() {

	wp_enqueue_style( 'web.frontpage',           get_stylesheet_uri(), array(), false, 'all' );
	wp_enqueue_style( 'web.fonts',               SP_FONTS . '/stylesheet.css', array(), false, 'all' );

	wp_enqueue_script( 'jquery' );
	// sp_enqueue_jquery_own();
	wp_enqueue_script( 'jquery.migrate' );
	wp_enqueue_script( 'jquery.placeholder' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'web.library',            SP_JS . '/web.library.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'web.frontpage',          SP_JS . '/web.frontpage.js', array( 'jquery' ), false, true );

	if ( is_singular() && comments_open() )
		wp_enqueue_script( 'comment-reply' );

	// parameters transfer to front-end JS
	$params = array(
		'baseurl' => trailingslashit( home_url() ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'tplurl'  => trailingslashit( SP_URI ),
		'request_uri' => $_SERVER['REQUEST_URI'],
		'request_uri_host' => ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'],
	);
	wp_localize_script( 'web.library', 'sp', $params );

}
add_action( 'wp_enqueue_scripts', '_sp_enqueue_assets_frontpage' );


/** Enqueue scripts & styles for Back-end */
function _sp_enqueue_assets_dashboard() {

	wp_enqueue_style( 'web.dashboard',            SP_CSS . '/web.dashboard.css', array(), false, 'all' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_script( 'web.library',            SP_JS . '/web.library.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'web.dashboard',           SP_JS . '/web.dashboard.js', array( 'jquery' ), false, true );

	$params = array(
		'baseurl' => trailingslashit( home_url() ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'tplurl'  => trailingslashit( SP_URI ),
	);
	wp_localize_script( 'web.library', 'sp', $params );

}
add_action( 'admin_enqueue_scripts', '_sp_enqueue_assets_dashboard' );


/** remove version parameter in HTML head script and stylesheet src */
function _sp_remove_asset_loader_src_version( $src ) {
	return substr( $src, 0, strpos( $src, '?ver' ) );
}
add_filter( 'script_loader_src', '_sp_remove_asset_loader_src_version', 15 );
add_filter( 'style_loader_src', '_sp_remove_asset_loader_src_version', 15 );


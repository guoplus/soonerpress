<?php


if( defined( 'SP_DEBUG_MODE' ) && SP_DEBUG_MODE ) :
	error_reporting( E_ALL | E_STRICT );
endif;

// API

function sp_option( $key, $echo = false ) {
	global $sp_config;
	$result = get_option( SP_OPTIONS_PREFIX . $key );
	if( $echo )
		echo $result;
	else
		return $result;
}

function sp_title( $sep = '&laquo;', $display = false, $seplocation = 'right' ) {
	return wp_title( $sep, $display, $seplocation );
}

function sp_enqueue_bootstrap_js() {
	wp_enqueue_script( 'bootstrap', SP_ASSETS . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.3.1', false );
}

function sp_enqueue_bootstrap_css() {
	wp_enqueue_style( 'bootstrap', SP_ASSETS . '/bootstrap/css/bootstrap.min.css', array(), '2.3.1', 'screen' );
	wp_enqueue_style( 'bootstrap-responsive', SP_ASSETS . '/bootstrap/css/bootstrap-responsive.min.css', array(), '2.3.1', 'screen' );
}

function sp_enqueue_fontawesome() {
	wp_enqueue_style( 'fontawesome', trailingslashit( SP_ASSETS ) . 'fontawesome/css/font-awesome.min.css', array(), '3.0.2', 'all' );
	wp_enqueue_style( 'fontawesome-ie7', trailingslashit( SP_ASSETS ) . 'fontawesome/css/font-awesome-ie7.min.css', array(), '3.0.2', 'all' );
	global $wp_styles;
	$wp_styles->add_data( 'fontawesome-ie7', 'conditional', 'IE 7' );
}

function sp_enqueue_jquery_own() {
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', SP_ASSETS . '/js/jquery.min.js', array(), '1.9.1', false );
}

function sp_icon_src( $name ) {
	return sprintf( '<img class="sp-icon-img" src="%s" align="absmiddle" />', SP_IMAGES . '/' . $name . '.png' );
}

function sp_icon_font( $name ) {
	return sprintf( '<i class="icon-%s"></i>', $name );
}


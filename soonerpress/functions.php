<?php


// if you delete this the sky will fall on your head
require_once( trailingslashit( get_template_directory() ) . 'includes/soonerpress.php' );


/* This is a sample configuration, edit or delete it, then start developing :-) */

function my_layout_body_class_home( $classes ) {
	if ( sp_option( 'layout_home' ) && ( is_home() || is_front_page() ) )
		$classes[] = sp_option( 'layout_home' );
	return $classes;
}
add_filter( 'body_class', 'my_layout_body_class_home' );

function my_layout_body_class_singular( $classes ) {
	if ( sp_option( 'layout_page' ) && is_singular() )
		$classes[] = sp_option( 'layout_page' );
	return $classes;
}
add_filter( 'body_class', 'my_layout_body_class_singular' );

function my_layout_body_class_archive( $classes ) {
	if ( sp_option( 'layout_archive' ) && ( is_archive() || is_search() ) )
		$classes[] = sp_option( 'layout_archive' );
	return $classes;
}
add_filter( 'body_class', 'my_layout_body_class_archive' );

function my_apply_site_favicon() {
	$favicon_attachment_id = sp_option( 'site_favicon', sp_lang() );
	$favicon_url = wp_get_attachment_url( $favicon_attachment_id );
	if ( ! empty( $favicon_url ) )
		printf( '<link rel="icon" href="%1$s" type="image/x-icon" /><link rel="shortcut icon" href="%1$s" type="image/x-icon" />',
			esc_attr( $favicon_url )
		);
}
add_action( 'wp_head', 'my_apply_site_favicon' );

// WooCommerce

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
function my_woocommerce_output_related_products() {
	woocommerce_related_products( 6, 6 );
}
add_action( 'woocommerce_after_single_product_summary', 'my_woocommerce_output_related_products', 20 );

if ( sp_module_enabled( 'breadcrumb' ) ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	function sp_woocommerce_breadcrumb() {
		echo '<nav id="breadcrumb">';
		sp_breadcrumb();
		echo '</nav>';
	}
	add_action( 'woocommerce_before_main_content', 'sp_woocommerce_breadcrumb', 20 );
}




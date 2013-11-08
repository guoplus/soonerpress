<?php
/**
 * Multilingual module API for WooCommerce
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */

if ( ! defined( 'IN_SP' ) ) exit;


function _sp_ml_wc_init_meta_boxes() {
	remove_meta_box( 'postexcerpt', 'product', 'normal' );
	add_meta_box( 'postexcerpt', __( 'Product Short Description', 'woocommerce' ), '_sp_woocommerce_product_short_description_meta_box', 'product', 'normal' );
}
add_action( 'add_meta_boxes', '_sp_ml_wc_init_meta_boxes', 20 );

function _sp_woocommerce_product_short_description_meta_box( $post ) {
	wp_editor( $post->post_excerpt, 'excerpt', array(
		'quicktags'     => array( 'buttons' => 'em,strong,link' ),
		'textarea_name' => 'excerpt',
		'quicktags'     => true,
		'tinymce'       => true,
		'editor_css'    => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>'
	) );
	$post_type = get_post_type( $post );
	if ( ! sp_is_post_type_ml( $post_type ) )
		return false;
	foreach( sp_get_enabled_languages_locales() as $l ) {
		$post_excerpt = sp_ml_ext_post_field( $post->ID, 'post_excerpt', $l );
		echo '<div class="sp-pe-one-field-post_excerpt-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
		wp_editor( $post_excerpt, 'post_excerpt'.SP_META_LANG_PREFIX.$l, array(
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'textarea_name' => 'post_excerpt'.SP_META_LANG_PREFIX.$l,
			'quicktags'     => true,
			'tinymce'       => true,
			'editor_css'    => '<style>#wp-post_excerpt'.SP_META_LANG_PREFIX.$l.'-editor-container .wp-editor-area{height:175px; width:100%;}</style>'
		) );
		echo '</div>';
	}
}

/** pre-define function woocommerce_product_archive_description */
function woocommerce_product_archive_description() {
	if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 ) {
		$shop_page   = get_post( woocommerce_get_page_id( 'shop' ) );
		$description = sp_ml_ext_post_field( $shop_page->ID, 'post_content' );
		if ( $description ) {
			echo '<div class="page-description">' . $description . '</div>';
		}
	}
}

/** pre-define function woocommerce_taxonomy_archive_description */
function woocommerce_taxonomy_archive_description() {
	if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
		$description = term_description();
		if ( $description ) {
			echo '<div class="term-description">' . $description . '</div>';
		}
	}
}


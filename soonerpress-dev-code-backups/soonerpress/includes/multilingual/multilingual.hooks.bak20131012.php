<?php


// general

function _sp_ml_ext_post_title( $title, $post_id ) {
	$post_type = get_post_type( $post_id );
	// ignore unnecessary post types
	if( in_array( $post_type, array( 'nav_menu_item' ) ) )
		return $title;
	else
		return sp_ml_ext_post_field( $post_id, 'post_title' );
}
function _sp_ml_ext_post_content( $content ) {
	global $post; return sp_ml_ext_post_field( $post->ID, 'post_content' );
}
function _sp_ml_ext_post_excerpt( $excerpt ) {
	global $post; return sp_ml_ext_post_field( $post->ID, 'post_excerpt' );
}

add_filter( 'the_title', '_sp_ml_ext_post_title', 0, 2 );
add_filter( 'the_content', '_sp_ml_ext_post_content', 0, 1 );
add_filter( 'the_excerpt', '_sp_ml_ext_post_excerpt', 0, 1 );
add_filter( 'the_excerpt_rss', '_sp_ml_ext_post_excerpt', 0, 1 );

// nav menus

function _sp_ml_menus_config_filter( $menus ) {
	global $sp_config;
	$menus_new = array();
	foreach ( $sp_config['multilingual']['enabled'] as $l )
		foreach ( $menus as $menu_id => $menu_name )
			$menus_new[$menu_id.'-'.$l] = $menu_name.' ['.$sp_config['multilingual']['names'][$l].']';
	return $menus_new;
}
add_filter( 'sp_menus_config', '_sp_ml_menus_config_filter' );

// options panel

function _sp_ml_op_option_name_filter( $option_name, $lang = '' ) {
	global $sp_config;
	if( ! empty( $lang ) && $sp_config['multilingual']['main_stored'] != $lang )
		return $option_name . SP_META_LANG_PREFIX . $lang;
	return $option_name;
}
add_filter( 'sp_option_name', '_sp_ml_op_option_name_filter', 10, 2 );

function _sp_ml_op_header_footer() {
	echo _sp_ml_html_selector_admin();
}
add_action( 'sp_op_header', '_sp_ml_op_header_footer' );
add_action( 'sp_op_footer', '_sp_ml_op_header_footer' );

function _sp_ml_cm_one_name_filter( $html, $enabled_ml ) {
	if( $enabled_ml )
		return $html . _sp_ml_html_selector_admin();
	else
		return $html;
}
add_filter( 'sp_op_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_op_register_setting( $option_group, $option_name, $option ) {
	global $sp_config;
	if( ! isset( $option['ml'] ) || ( isset( $option['ml'] ) && $option['ml'] ) )
		foreach( $sp_config['multilingual']['enabled'] as $l ) {
			if( $l == $sp_config['multilingual']['main_stored'] ) continue;
			register_setting( $option_group, $option_name . SP_META_LANG_PREFIX . $l );
		}
}
add_action( 'sp_op_register_setting', '_sp_ml_op_register_setting', 10, 3 );

// post custom meta

function _sp_ml_meta_key_filter( $meta_key, $post_id, $lang ) {
	global $sp_config;
	if( ! empty( $lang ) && $sp_config['multilingual']['main_stored'] != $lang )
		return $meta_key . SP_META_LANG_PREFIX . $lang;
	return $meta_key;
}
add_filter( 'sp_pm_meta_key', '_sp_ml_meta_key_filter', 10, 3 );

add_filter( 'sp_pm_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_pm_update_postmeta( $meta_key, $field, $post_id, $is_ml ) {
	global $sp_config;
	if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
		foreach( $sp_config['multilingual']['enabled'] as $l ) {
			if( $l == $sp_config['multilingual']['main_stored'] ) continue;
			$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
				$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
			update_post_meta( $post_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
		}
}
add_action( 'sp_pm_update_postmeta', '_sp_ml_pm_update_postmeta', 10, 4 );

// taxonomy custom meta

add_filter( 'sp_tm_meta_key', '_sp_ml_meta_key_filter', 10, 3 );

add_filter( 'sp_tm_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_tm_update_termmeta( $meta_key, $field, $term_id, $is_ml ) {
	global $sp_config;
	if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
		foreach( $sp_config['multilingual']['enabled'] as $l ) {
			if( $l == $sp_config['multilingual']['main_stored'] ) continue;
			$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
				$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
			sp_update_term_meta( $term_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
		}
}
add_action( 'sp_tm_update_termmeta', '_sp_ml_tm_update_termmeta', 10, 4 );


<?php
/**
 * Core module API for term meta
 *
 * @package SoonerPress
 * @subpackage Core
 */

if ( ! defined( 'IN_SP' ) ) exit;


function sp_get_term_meta( $term_id, $meta_key ) {
	$meta = get_option( SP_OPTION_TERM_META_PREFIX . $term_id );
	return ( isset( $meta[$meta_key] ) ? $meta[$meta_key] : false );
}

function sp_update_term_meta( $term_id, $meta_key, $meta_value ) {
	$meta = get_option( SP_OPTION_TERM_META_PREFIX . $term_id );
	if( false == $meta ) {
		$meta = array( $meta_key => wp_unslash( $meta_value ) );
		return add_option( SP_OPTION_TERM_META_PREFIX . $term_id, $meta );
	}
	$meta[$meta_key] = wp_unslash( $meta_value );
	return update_option( SP_OPTION_TERM_META_PREFIX . $term_id, $meta );
}

function sp_delete_term_meta( $term_id, $meta_key ) {
	$meta = get_option( SP_OPTION_TERM_META_PREFIX . $term_id );
	unset( $meta[$meta_key] );
	return update_option( SP_OPTION_TERM_META_PREFIX . $term_id, $meta );
}

function _sp_core_tm_term_delete( $term, $tt_id, $taxonomy, $deleted_term ) {
	return delete_option( SP_OPTION_TERM_META_PREFIX . $term );
}
add_action( 'delete_term', '_sp_core_tm_term_delete', 10, 4 );


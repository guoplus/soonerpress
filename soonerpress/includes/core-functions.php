<?php
/**
 * Core module API for useful functions
 *
 * @package SoonerPress
 * @subpackage Core
 */


/**
 * get attachment ID specified by image URL
 * @param  string $src image URL
 * @return integer attachment ID
 */
function get_attachment_id_by_image_src( $src ) {
	$src = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', null, $src );
	global $wpdb;
	$attachment_id = $wpdb->get_var( "SELECT `ID` FROM {$wpdb->posts} WHERE `guid` = '$src'" );
	return $attachment_id;
}

/**
 * get post ID specified by slug name
 * 
 * @param  string $slug post slug name
 * @param  string $post_type the post type
 * @return integer|false post ID or false if no results retrieved
 */
function get_post_id_by_slug( $slug, $post_type = 'post' ) {
	$query_tmp = new WP_Query( array(
		'name' => $slug,
		'post_type' => $post_type,
	) );
	if ( 1 == $query_tmp->post_count )
		return $query_tmp->post->ID;
	return false;
}


function sp_merge_args( $args = array(), $defaults = array() ) {
	if ( is_array( $defaults ) ) {
		foreach ( $defaults as $k => $v ) {
			if ( ! isset( $args[$k] ) || ( isset( $args[$k] ) && empty( $args[$k] ) ) ) {
				$args[$k] = $v;
			}
		}
	}
	return $args;
}


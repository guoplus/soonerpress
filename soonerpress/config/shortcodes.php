<?php
/**
 * Shortcodes module configuration
 *
 * @package SoonerPress
 * @subpackage Shortcodes
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

/** Shortcode: Sample Shortcode */
function sp_shortcode_sample( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'param' => null,
	), $atts ) );

	$output = '';
	return $output;

}

/** Add Shortcodes */
function sp_add_shortcodes() {

	add_shortcode( 'sample-shortcode', 'sp_shortcode_sample' );

}
add_action( 'init', 'sp_add_shortcodes' );


<?php
/**
 * Core module API for developing functions
 *
 * @package SoonerPress
 * @subpackage Core
 */


/** dump an array or object as formatted HTML output */
if ( ! function_exists( 'dump' ) ) :
function dump( $expression, $echo = true ) {
	if ( ini_get('html_errors') ) {
		$output = '<pre>' . "\n";
		$output .= htmlspecialchars( print_r( $expression, true ) );
		$output .= "\n" . '</pre>' . "\n";
	} else {
		$output = print_r($expression, true);
	}
	if ( $echo )
		echo $output;
	else
		return $output;
}
endif;


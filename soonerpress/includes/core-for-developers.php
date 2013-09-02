<?php


/** dump an array or object as formatted HTML output */
function sp_dump( $expression, $echo = true ) {
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

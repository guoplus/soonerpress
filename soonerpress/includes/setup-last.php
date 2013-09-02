<?php


// title not defined (SEO module)
if( ! has_filter( 'wp_head', 'sp_title_output' ) ) {

	function sp_title_output() {
		printf( '<title>%s</title>', sp_title() );
	}
	add_action( 'wp_head', 'sp_title_output' );

}


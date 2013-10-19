<?php
/**
 * Framework Setup Last
 *
 * @package SoonerPress
 * @subpackage Framework_Environment
 */

// title not defined (SEO module)
if( ! sp_module_enabled( 'seo' ) ) {

	function sp_title_output() {
		printf( '<title>%s</title>', sp_title() );
	}
	add_action( 'wp_head', 'sp_title_output' );

}


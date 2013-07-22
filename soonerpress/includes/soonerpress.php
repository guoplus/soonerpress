<?php


/** Framework version */
define( 'SP_VER', '1.0.0' );

/** Framework directory */
define( 'SP_DIR', get_template_directory() );
/** Framework directory URI */
define( 'SP_URI', get_template_directory_uri() );

/** Framework configuration directory */
define( 'SP_CONFIG', trailingslashit( SP_DIR ) . 'config' );
/** Framework functions directory */
define( 'SP_INCLUDES', trailingslashit( SP_DIR ) . 'includes' );
define( 'SP_INCLUDES_URI', trailingslashit( SP_URI ) . 'includes' );
/** Framework CSS & JS files directory */
define( 'SP_ASSETS', trailingslashit( SP_URI ) . 'assets' );
/** Framework images files directory */
define( 'SP_IMAGES', trailingslashit( SP_URI ) . 'images' );
/** Framework languages .PO files directory */
define( 'SP_LANGUAGES', trailingslashit( SP_DIR ) . 'languages' );

/** Framework variable name prefix */
define( 'SP_OPTIONS_PREFIX', 'sp_' );

define( 'SP_DEBUG_MODE', false );

/** define global configuration variable */
$GLOBALS['sp_config'] = array();


/** modules */
$sp_modules = array( 'assets', 'nav-menus', 'dashboard', 'widgets', 'sidebars', 'pagination', 'shortcodes',
	'options-panel', 'excerpt', 'breadcrumbs', 'login', 'post-types', 'post-order', 'post-custom-meta',
	'taxonomies', 'taxonomy-order', 'taxonomy-custom-meta', 'user-custom-meta', 'seo' );

/** init required functions */
require( SP_INCLUDES . '/core.php' );

/** setup functions before modules */
require( SP_INCLUDES . '/setup-first.php' );

/** init configured modules */
foreach ( $sp_modules as $m ) {
	if ( file_exists( SP_CONFIG . '/' . $m . '.php' ) ) {
		require( SP_CONFIG . '/' . $m . '.php' );
		if ( file_exists( SP_INCLUDES . '/' . $m . '.php' ) )
			require( SP_INCLUDES . '/' . $m . '.php' );
	}
}

/** setup functions after modules */
require( SP_INCLUDES . '/setup-last.php' );


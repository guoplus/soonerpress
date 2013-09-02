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
/** Framework assets files directory */
define( 'SP_ASSETS', trailingslashit( SP_URI ) . 'assets' );
define( 'SP_CSS', trailingslashit( SP_ASSETS ) . 'css' );
define( 'SP_JS', trailingslashit( SP_ASSETS ) . 'js' );
define( 'SP_FONTS', trailingslashit( SP_ASSETS ) . 'fonts' );
/** Framework images files directory */
define( 'SP_IMAGES', trailingslashit( SP_URI ) . 'images' );
/** Framework 3rd-party plugins files directory */
define( 'SP_PLUGINS', trailingslashit( SP_URI ) . 'plugins' );
/** Framework languages .PO files directory */
define( 'SP_LANGUAGES', trailingslashit( SP_DIR ) . 'languages' );

/** Framework variable name prefix */
define( 'SP_OPTIONS_PREFIX', 'sp_' );

define( 'SP_DEBUG_MODE', true );

/** define global configuration variable */
$GLOBALS['sp_config'] = array();

/** modules */
$_sp_modules = array( 'theme-setup', 'nav-menus', 'dashboard', 'widgets', 'sidebars', 'pagination', 'shortcodes',
	'options-panel', 'excerpt', 'breadcrumbs', 'post-types', 'multi-language', 'post-order', 'post-custom-meta',
	'taxonomies', 'taxonomy-order', 'taxonomy-custom-meta', 'user-custom-meta', 'seo' );

/** modules enabled array */
$GLOBALS['_enabled_modules'] = array();

/** init required functions */
require_once( SP_INCLUDES . '/core.php' );

/** setup functions before modules */
require_once( SP_INCLUDES . '/setup-first.php' );

/** init configured modules */
foreach ( $_sp_modules as $m ) {
	if ( file_exists( SP_CONFIG . '/' . $m . '.php' ) ) {
		$_enabled_modules[] = $m;
		require_once( SP_CONFIG . '/' . $m . '.php' );
		if ( file_exists( SP_INCLUDES . '/' . $m . '.php' ) )
			require_once( SP_INCLUDES . '/' . $m . '.php' );
	}
}

/** setup functions after modules */
require_once( SP_INCLUDES . '/setup-last.php' );


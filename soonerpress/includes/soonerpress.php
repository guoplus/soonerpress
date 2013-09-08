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
define( 'SP_INC', trailingslashit( SP_DIR ) . 'includes' );
define( 'SP_INC_URI', trailingslashit( SP_URI ) . 'includes' );
/** Framework assets files directory */
define( 'SP_ASSETS', trailingslashit( SP_URI ) . 'assets' );
define( 'SP_CSS', trailingslashit( SP_ASSETS ) . 'css' );
define( 'SP_JS', trailingslashit( SP_ASSETS ) . 'js' );
define( 'SP_FONTS', trailingslashit( SP_ASSETS ) . 'fonts' );
/** Framework images files directory */
define( 'SP_IMG', trailingslashit( SP_URI ) . 'images' );
/** Framework 3rd-party plugins files directory */
define( 'SP_LIB', trailingslashit( SP_URI ) . 'library' );
/** Framework languages .PO files directory */
define( 'SP_LANG', trailingslashit( SP_DIR ) . 'languages' );

/** Framework option name and meta key prefix */
define( 'SP_CUSTOM_META_PREFIX', '_' );
define( 'SP_CUSTOM_META_PRI_PREFIX', '__' );
define( 'SP_OPTION_PREFIX', 'sp_' );
define( 'SP_OPTION_TERM_META_PREFIX', '_termmeta_' );
define( 'SP_META_LANG_PREFIX', '__' );

/** Is enabled de-bug mode */
define( 'SP_DEBUG_MODE', true );

/** define global configuration variable */
$GLOBALS['sp_config'] = array();

/** modules */
$_sp_modules = array( 'theme-setup', 'post-types', 'taxonomies', 'nav-menus', 'dashboard', 'widgets', 'sidebars', 'shortcodes', 'multi-language', 'excerpt', 'pagination', 'breadcrumbs', 'options-panel', 'post-order', 'post-custom-meta', 'taxonomy-order', 'taxonomy-custom-meta', 'user-custom-meta', 'seo' );

/** modules enabled array */
$GLOBALS['_sp_enabled_modules'] = array();

/** init required functions */
require_once( SP_INC . '/core.php' );

/** setup functions before modules */
require_once( SP_INC . '/setup-first.php' );

/** init configured modules */
foreach ( $_sp_modules as $m ) {
	if ( file_exists( SP_CONFIG . '/' . $m . '.php' ) ) {
		$_sp_enabled_modules[] = $m;
		require_once( SP_CONFIG . '/' . $m . '.php' );
		if ( file_exists( SP_INC . '/' . $m . '.php' ) )
			require_once( SP_INC . '/' . $m . '.php' );
	}
}

/** setup functions after modules */
require_once( SP_INC . '/setup-last.php' );


<?php
/**
 * Framework Environment
 *
 * @package SoonerPress
 * @subpackage Framework_Environment
 */


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
define( 'SP_OPTION_PREFIX', 'sp_' );
define( 'SP_CUSTOM_FIELDS_PREFIX', '_' );
define( 'SP_CUSTOM_FIELDS_PRI_PREFIX', '__' );
define( 'SP_META_LANG_PREFIX', '__' );
define( 'SP_OPTION_TERM_META_PREFIX', '_termmeta_' );
define( 'SP_OPTION_POST_ORDER_DATA_PREFIX', '_post_order_' );
define( 'SP_OPTION_TERM_ORDER_DATA_PREFIX', '_term_order_' );

/** Is enabled de-bug mode */
define( 'SP_DEBUG_MODE', false );

/** for denying access directly */
define( 'IN_SP', null );

/** init required functions */
require_once( SP_INC . '/core.php' );

/** setup functions before modules */
require_once( SP_INC . '/setup-first.php' );

/** init configured modules */
global $_sp_modules, $_sp_enabled_modules;
foreach ( $_sp_modules as $m ) {
	if ( file_exists( SP_CONFIG . '/' . $m . '.php' ) ) {
		$_sp_enabled_modules[] = $m;
		require_once( SP_CONFIG . '/' . $m . '.php' );
		if ( file_exists( SP_INC . '/' . $m . '.php' ) ) {
			require_once( SP_INC . '/' . $m . '.php' );
		}
	}
}

/** setup functions after modules */
require_once( SP_INC . '/setup-last.php' );


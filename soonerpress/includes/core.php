<?php


if( defined( 'SP_DEBUG_MODE' ) && SP_DEBUG_MODE ) :
	error_reporting( E_ALL | E_STRICT );
endif;


/** HTML head title output, using wp_title parsed args */
function sp_title( $sep = '&laquo;', $display = false, $seplocation = 'right' ) {
	return wp_title( $sep, $display, $seplocation );
}

/** register default scripts and stylesheets */
function _sp_default_scripts() {
	wp_register_script( 'bootstrap', SP_LIB . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.3.1', false );
	wp_register_script( 'jquery-ui-timepicker-addon', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js', array( 'jquery' ), '1.4', true );
	wp_register_script( 'jquery-ui-slideraccess', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-slideraccess.min.js', array( 'jquery' ), '0.3', true );
	wp_register_script( 'jquery.json', SP_JS . '/jquery.json.min.js', array( 'jquery' ), '2.4', true );
	wp_register_script( 'jquery.cookie', SP_JS . '/jquery.cookie.min.js', array( 'jquery' ), '1.3.1', true );
	wp_register_script( 'jquery.placeholder', SP_JS . '/jquery.placeholder.min.js', array( 'jquery' ), '2.0.7', true );
	wp_register_script( 'html5shiv', 'http://html5shiv.googlecode.com/svn/trunk/html5.js', array(), false, true );
	global $wp_scripts;
	$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );

}
function _sp_default_styles() {
	wp_register_style( 'sp.jqueryui-datepicker', SP_LIB . '/jqueryui/themes/smoothness/jquery-ui-datepicker.min.css', array(), false, 'all' );
	wp_register_style( 'jquery-ui-timepicker-addon', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css', array(), '1.4', 'all' );
	wp_register_style( 'bootstrap', SP_LIB . '/bootstrap/css/bootstrap.min.css', array(), '2.3.1', 'screen' );
	wp_register_style( 'bootstrap-responsive', SP_LIB . '/bootstrap/css/bootstrap-responsive.min.css', array(), '2.3.1', 'screen' );
	wp_register_style( 'fontawesome', SP_LIB . '/fontawesome/css/font-awesome.min.css', array(), '3.0.2', 'all' );
	wp_register_style( 'fontawesome-ie7', SP_LIB . '/fontawesome/css/font-awesome-ie7.min.css', array(), '3.0.2', 'all' );
	global $wp_styles;
	$wp_styles->add_data( 'fontawesome-ie7', 'conditional', 'IE 7' );
}
add_action( 'init', '_sp_default_scripts' );
add_action( 'init', '_sp_default_styles' );

function sp_enqueue_jquery_own() {
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', SP_JS . '/jquery.min.js', array(), '1.10.2', false );
}

function sp_icon_src( $name ) {
	return sprintf( '<img class="sp-icon-img" src="%s" alt="%s" align="absmiddle" />',
		esc_attr( SP_IMG . '/icons/' . $name . '.png' ),
		esc_attr( $name . ' icon' ) );
}

function sp_icon_font( $name ) {
	return sprintf( '<i class="icon-%s"></i>', $name );
}

/** check if a module is enabled */
function sp_enabled_module( $module ) {
	global $_sp_enabled_modules;
	return in_array( $module, $_sp_enabled_modules );
}

// additional core functions
$sp_modules_additional = array( 'for-developers', 'adjacent-post-link', 'custom-meta', 'term-meta' );
foreach ( $sp_modules_additional as $m ) {
	if ( file_exists( SP_INC . '/core-' . $m . '.php' ) ) {
		require_once( SP_INC . '/core-' . $m . '.php' );
	}
}

function _sp_core_enqueue_assets_dashboard() {

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'fontawesome-ie7' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_media();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_style( 'sp.jqueryui-datepicker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'jquery-ui-timepicker-addon' );
	wp_enqueue_script( 'jquery-ui-timepicker-addon' );
	wp_enqueue_style( 'sp.core.dashboard', SP_INC_URI . '/core/sp.core.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.core.dashboard', SP_INC_URI . '/core/sp.core.dashboard.js', array( 'jquery' ), false, true );

	wp_localize_script( 'sp.core.dashboard', 'sp_core_text', array(
		'add_new' => __( 'Add new', 'sp' ),
		'delete' => __( 'Delete', 'sp' ),
		'toggle' => __( 'Toggle', 'sp' ),
		'toggle_all' => __( 'Toggle All', 'sp' ),
		'collapse_all' => __( 'Collapse All', 'sp' ),
		'expand_all' => __( 'Expand All', 'sp' ),
		'click_to_toggle' => __( 'Click to toggle', 'sp' ),
	) );

}
add_action( 'admin_enqueue_scripts', '_sp_core_enqueue_assets_dashboard' );


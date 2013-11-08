<?php
/**
 * Core module API
 *
 * @package SoonerPress
 * @subpackage Core
 */

if ( ! defined( 'IN_SP' ) ) exit;


if( defined( 'SP_DEBUG_MODE' ) && SP_DEBUG_MODE ) :
	error_reporting( E_ALL | E_STRICT );
endif;

/** define global configuration variable */
$GLOBALS['sp_config'] = array();

/** modules */
$GLOBALS['_sp_modules'] = array( 'post-types', 'taxonomies', 'multilingual', 'nav-menus', 'sidebars', 'widgets', 'theme-setup', 'dashboard', 'shortcodes', 'excerpt', 'pagination', 'breadcrumb', 'options-panel', 'post-reorder', 'post-custom-fields', 'taxonomy-reorder', 'taxonomy-custom-fields', 'user-custom-fields', 'seo' );

/** modules enabled array */
$GLOBALS['_sp_enabled_modules'] = array();

/** messages for interactive output */
$GLOBALS['sp_msg'] = array(
	'frontpage' => array(),
	'dashboard' => array()
);

/**
 * check if a module is enabled
 * 
 * @param  string $module
 * @return bool
 */
function sp_module_enabled( $module ) {
	global $_sp_enabled_modules;
	return in_array( $module, $_sp_enabled_modules );
}

/** register default scripts */
function _sp_default_scripts() {
	wp_register_script( 'bootstrap', SP_LIB . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.3.2', false );
	wp_register_script( 'jquery-ui-timepicker-addon', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js', array( 'jquery' ), '1.4', true );
	wp_register_script( 'jquery-ui-slideraccess', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-slideraccess.min.js', array( 'jquery' ), '0.3', true );
	wp_register_script( 'jquery-ui-nested-sortable-addon', SP_LIB . '/jqueryui/jquery-ui-nested-sortable-addon/jquery-ui-nested-sortable-addon.min.js', array( 'jquery', 'jquery-ui-sortable' ), '1.3.5', true );
	wp_register_script( 'jquery.cookie', SP_LIB . '/jquery.cookie.min.js', array( 'jquery' ), '1.4.0', true );
	wp_register_script( 'jquery.placeholder', SP_LIB . '/jquery.placeholder.min.js', array( 'jquery' ), '2.0.7', true );
	wp_register_script( 'jquery.flexslider', SP_LIB . '/jquery.flexslider/jquery.flexslider.min.js', array( 'jquery' ), '2.2.0', true );
	wp_register_script( 'google.maps', '//maps.google.com/maps/api/js?sensor=true', array(), false, true );
	wp_register_script( 'gmaps', SP_LIB . '/gmaps.js', array( 'google.maps' ), '0.4.7', true );
	wp_register_script( 'html5shiv', '//html5shiv.googlecode.com/svn/trunk/html5.js', array(), false, true );
	global $wp_scripts;
	$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );
}
/** register default stylesheets */
function _sp_default_styles() {
	wp_register_style( 'sp.jqueryui-datepicker', SP_LIB . '/jqueryui/themes/smoothness/jquery-ui-datepicker.min.css', array(), false, 'all' );
	wp_register_style( 'jquery-ui-timepicker-addon', SP_LIB . '/jqueryui/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css', array(), '1.4', 'all' );
	wp_register_style( 'bootstrap', SP_LIB . '/bootstrap/css/bootstrap.min.css', array(), '2.3.2', 'screen' );
	wp_register_style( 'bootstrap-responsive', SP_LIB . '/bootstrap/css/bootstrap-responsive.min.css', array(), '2.3.2', 'screen' );
	wp_register_style( 'fontawesome', SP_LIB . '/fontawesome/css/font-awesome.min.css', array(), '3.2.1', 'all' );
	wp_register_style( 'fontawesome-ie7', SP_LIB . '/fontawesome/css/font-awesome-ie7.min.css', array(), '3.2.1', 'all' );
	global $wp_styles;
	$wp_styles->add_data( 'fontawesome-ie7', 'conditional', 'IE 7' );
	wp_register_style( 'jquery.flexslider', SP_LIB . '/jquery.flexslider/flexslider.css', array(), '2.2.0', true );
}
add_action( 'init', '_sp_default_scripts' );
add_action( 'init', '_sp_default_styles' );

function sp_enqueue_jquery_own() {
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', SP_JS . '/jquery.min.js', array(), false, false );
}

function sp_icon_src( $name ) {
	return sprintf( '<img class="sp-icon-img" src="%s" alt="%s" align="absmiddle" />',
		esc_attr( SP_IMG . '/icons/' . $name . '.png' ),
		esc_attr( $name . ' icon' ) );
}

function sp_icon_font( $name ) {
	return sprintf( '<i class="icon-%s"></i>', $name );
}

/**
 * HTML head title output, using wp_title parsed args
 * 
 * @param  string  $sep         separator
 * @param  boolean $display     is for display
 * @param  string  $seplocation location for separator
 * @return string               the title content if $display == false
 */
function sp_title( $sep = '&laquo;', $display = false, $seplocation = 'right' ) {
	return wp_title( $sep, $display, $seplocation );
}

function sp_msg_add( $msg, $type = 'updated', $location = 'dashboard' ) {
	global $sp_msg;
	if ( isset( $sp_msg[$location] ) )
		return $sp_msg[$location][$type][] = $msg;
}

function sp_msg( $location = 'dashboard' ) {
	global $sp_msg;
	if ( isset( $sp_msg[$location] ) && sizeof( $sp_msg[$location] ) )
		foreach ( array( 'updated', 'error' ) as $type )
			if ( isset( $sp_msg[$location][$type] ) && sizeof( $sp_msg[$location][$type] ) ) {
				foreach ( $sp_msg[$location][$type] as $entry ) {
					echo '<div class="sp-msg ' . $type . ' fade"><p>';
					printf( '<span>%s</span>', $entry );
					echo '</p></div>';
				}
			}
}

/**
 * get current page URL
 * 
 * @return string page URL
 */
function sp_current_url() {
	$protocol = ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
	$port = ( isset( $_SERVER['SERVER_PORT'] ) && ( ( 'http' == $protocol && $_SERVER['SERVER_PORT'] != '80' ) || ( 'https' == $protocol && $_SERVER['SERVER_PORT'] != '443' ) ) ) ?
		':' . $_SERVER['SERVER_PORT'] : null;
	return $protocol . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

/**
 * output all URL query vars for a HTML form
 */
function sp_output_url_query_vars_form() {
	foreach ( $_GET as $key => $val )
		printf( '<input type="hidden" name="%s" value="%s" />', esc_attr( $key ), esc_attr( $val ) );
}

/**
 * Framework module class
 */
class SP_Module {

	/**
	 * module configuration
	 * 
	 * @var array
	 */
	var $c = array();

	/**
	 * module default configuration
	 * 
	 * @var array
	 */
	var $dc = array();

	/**
	 * module name
	 * 
	 * @var string
	 */
	var $slug;

	/**
	 * HTML output buffer
	 * 
	 * @var string
	 */
	var $o;

	/**
	 * init the module
	 * 
	 * @param  string $slug
	 * @return bool
	 */
	function init( $slug ) {
		$this->slug = $slug;
		global $sp_config;
		if ( isset( $sp_config[$this->slug] ) )
			$this->c = wp_parse_args( $sp_config[$this->slug], $this->dc );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets_frontpage' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets_dashboard' ) );
	}

	/**
	 * get current module directory uri
	 * 
	 * @return string|false directory uri or false if slug is empty
	 */
	function get_module_uri() {
		if ( ! empty( $this->slug ) )
			return trailingslashit( SP_INC_URI ) . $this->slug;
		return false;
	}

	/**
	 * get current module directory path
	 * 
	 * @return string|false directory path or false if slug is empty
	 */
	function get_module_dir() {
		if ( ! empty( $this->slug ) )
			return trailingslashit( SP_INC ) . $this->slug;
		return false;
	}

	/**
	 * get the HTML output buffer contents
	 * 
	 * @return string output buffer contents
	 */
	public function get_output() {
		return $this->o;
	}

	/**
	 * enqueue scripts and stylesheets for frontpage
	 *
	 * @abstract
	 * 
	 * @return null
	 */
	function enqueue_assets_frontpage() {}

	/**
	 * enqueue scripts and stylesheets for dashboard
	 *
	 * @abstract
	 * 
	 * @return null
	 */
	function enqueue_assets_dashboard() {}

}

function _sp_core_enqueue_assets_dashboard() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.core.dashboard', SP_INC_URI . '/core/sp.core.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.core.dashboard', SP_INC_URI . '/core/sp.core.dashboard.js', array( 'jquery' ), false, true );

	wp_localize_script( 'sp.core.dashboard', 'sp_core', array(
		'baseurl' => trailingslashit( home_url() ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'tplurl'  => trailingslashit( SP_URI ),
		'request_uri' => $_SERVER['REQUEST_URI'],
		'request_uri_host' => ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'],
	) );

}
add_action( 'admin_enqueue_scripts', '_sp_core_enqueue_assets_dashboard' );


// sub-modules
foreach ( array( 'functions', 'for-developers', 'adjacent-post-link', 'custom-fields', 'term-meta' ) as $m ) {
	if ( file_exists( SP_INC . '/core-' . $m . '.php' ) ) {
		require_once( SP_INC . '/core-' . $m . '.php' );
	}
}


<?php
/**
 * Dashboard module API
 *
 * @package SoonerPress
 * @subpackage Dashboard
 */

if ( ! defined( 'IN_SP' ) ) exit;


class SP_Dashboard extends SP_Module {

	function __construct() {
		$this->dc = array(
			'remove-admin-menu-pages'      => array(),
			'remove-dashboard-widgets'     => false,
			'admin_footer_copyright'       => null,
			'admin_footer_version'         => null,
			'wp-login-header-url'          => trailingslashit( home_url() ),
			'wp-login-header-title'        => get_bloginfo( 'name' ),
			'wp-login-header-image'        => null,
			'wp-login-redirect'            => null,
			'remove-unnecessary-html-head' => true,
			'disable-core-updates'         => false,
			'disable-theme-updates'        => false,
			'disable-plugin-updates'       => false,
		);
		$this->init( 'dashboard' );
		// enquese assets for WordPress login page
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_assets_wp_login' ), 10 );
		// remove admin menu pages
		if ( sizeof( $this->c['remove-admin-menu-pages'] ) )
			add_action( 'admin_menu', array( $this, 'remove_admin_menu_pages' ) );
		// remove widgets in dashboard index page
		if ( false !== $this->c['remove-dashboard-widgets'] ) {
			add_action( 'wp_dashboard_setup', array( $this, 'remove_widgets' ) );
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		}
		// modify admin footer text on the left side
		if ( ! empty( $this->c['admin_footer_copyright'] ) )
			add_filter( 'admin_footer_text', array( $this, 'admin_footer_copyright' ) );
		// modify admin footer text on the right side
		if ( ! empty( $this->c['admin_footer_version'] ) )
			add_filter( 'update_footer', array( $this, 'admin_footer_version' ), 20 );
		// redirect after logged in successfully
		if ( ! empty( $this->c['wp-login-redirect'] ) )
			add_filter( 'login_redirect', array( $this, 'login_redirect' ), 10, 3 );
		// modify header link in WordPress login page
		if ( ! empty( $this->c['wp-login-header-url'] ) )
			add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
		// modify header link title in WordPress login page
		if ( ! empty( $this->c['wp-login-header-title'] ) )
			add_filter( 'login_headertitle', array( $this, 'login_headertitle' ) );
		// modify header image in WordPress login page
		if ( ! empty( $this->c['wp-login-header-image'] ) )
			add_action( 'login_enqueue_scripts', array( $this, 'login_headerimage' ) );
		// remove excess head meta on frontpage
		if ( false !== $this->c['remove-unnecessary-html-head'] )
			add_action( 'init', array( $this, 'remove_unnecessary_html_head' ) );
		// disable WordPress updates for core
		if ( false !== $this->c['disable-core-updates'] ) {
			// ver 2.3 to 2.7:
			add_action( 'init', create_function( '$a', 'remove_action( \'init\', \'wp_version_check\' );' ), 2 );
			add_filter( 'pre_option_update_core', create_function( '$a', 'return null;' ) );
			// ver 2.8 to 3.0:
			remove_action( 'wp_version_check', 'wp_version_check' );
			remove_action( 'admin_init', '_maybe_update_core' );
			add_filter( 'pre_transient_update_core', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_version_check' );
			// ver 3.0:
			add_filter( 'pre_site_transient_update_core', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_version_check' );
		}
		// disable WordPress updates for themes
		if ( false !== $this->c['disable-theme-updates'] ) {
			// ver 2.8 to 3.0:
			remove_action( 'load-themes.php', 'wp_update_themes' );
			remove_action( 'load-update.php', 'wp_update_themes' );
			remove_action( 'admin_init', '_maybe_update_themes' );
			remove_action( 'wp_update_themes', 'wp_update_themes' );
			add_filter( 'pre_transient_update_themes', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_update_themes' );
			// ver 3.0:
			remove_action( 'load-update-core.php', 'wp_update_themes' );
			add_filter( 'pre_site_transient_update_themes', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_update_themes' );
		}
		// disable WordPress updates for plugins
		if ( false !== $this->c['disable-plugin-updates'] ) {
			// ver 2.8 to 3.0:
			remove_action( 'load-plugins.php', 'wp_update_plugins' );
			remove_action( 'load-update.php', 'wp_update_plugins' );
			remove_action( 'admin_init', '_maybe_update_plugins' );
			remove_action( 'wp_update_plugins', 'wp_update_plugins' );
			add_filter( 'pre_transient_update_plugins', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_update_plugins' );
			// ver 3.0:
			remove_action( 'load-update-core.php', 'wp_update_plugins' );
			add_filter( 'pre_site_transient_update_plugins', create_function( '$a', 'return null;' ) );
			wp_clear_scheduled_hook( 'wp_update_plugins' );
		}
	}

	function enqueue_assets_wp_login() {
		wp_enqueue_style( 'web.wp-login', SP_CSS . '/web.wp-login.css', array(), false, 'all' );
	}

	function remove_admin_menu_pages() {
		foreach ( $this->c['remove-admin-menu-pages'] as $p )
			remove_menu_page( $p );
	}

	function remove_widgets() {
		remove_meta_box( 'dashboard_quick_press',     'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts',   'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary',         'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary',       'dashboard', 'side' );
		remove_meta_box( 'dashboard_right_now',       'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links',  'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins',         'dashboard', 'normal' );
	}

	function admin_footer_copyright() {
		return $this->c['admin_footer_copyright'];
	}

	function admin_footer_version() {
		return $this->c['admin_footer_version'];
	}

	function login_redirect() {
		return $this->c['wp-login-redirect'];
	}

	function login_headerurl() {
		return $this->c['wp-login-header-url'];
	}

	function login_headertitle() {
		return $this->c['wp-login-header-title'];
	}

	function login_headerimage() {
		echo '<style type="text/css" media="all">/* <![CDATA[ */';
		printf( '.login h1 a { width: %s; height: %s; background-image: url(\'%s\'); background-size: %spx %spx; }',
			$this->c['wp-login-header-image-width'],
			$this->c['wp-login-header-image-height'],
			$this->c['wp-login-header-image'],
			$this->c['wp-login-header-image-width'],
			$this->c['wp-login-header-image-height']
		);
		echo '/* ]]> */</style>';
	}

	function remove_unnecessary_html_head() {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_generator' );
		if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
			remove_action( 'wp_head', 'woocommerce_products_rss_feed' );
			global $woocommerce;
			remove_action( 'wp_head', array( $woocommerce, 'generator' ) );
		}
	}

}

new SP_Dashboard();


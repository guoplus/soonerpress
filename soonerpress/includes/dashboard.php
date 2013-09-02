<?php


global $sp_config;

if ( isset( $sp_config['dashboard']['remove-admin-menu'] ) && $sp_config['dashboard']['remove-admin-menu'] ) {
	function _sp_dashboard_remove_admin_menus() {
		global $sp_config, $menu;
		end( $menu );
		while ( prev( $menu ) ) {
			$value = explode( ' ', $menu[key( $menu )][0] );
			if ( in_array( null != $value[0] ? $value[0] : '', $sp_config['dashboard']['remove-admin-menu'] ) )
				unset( $menu[key( $menu )] );
		}
	}
	add_action( 'admin_menu', '_sp_dashboard_remove_admin_menus' );
}

if ( isset( $sp_config['dashboard']['remove-dashboard-widgets'] ) && $sp_config['dashboard']['remove-dashboard-widgets'] ) {
	function _sp_dashboard_remove_widgets() {
		global $wp_meta_boxes;
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	}
	add_action( 'wp_dashboard_setup', '_sp_dashboard_remove_widgets' );
}

if ( isset( $sp_config['dashboard']['admin_footer_copyright'] ) && $sp_config['dashboard']['admin_footer_copyright'] ) {
	function _sp_dashboard_admin_footer_copyright() {
		global $sp_config;
		return $sp_config['dashboard']['admin_footer_copyright'];
	}
	add_filter( 'admin_footer_text', '_sp_dashboard_admin_footer_copyright' );
}

if ( isset( $sp_config['dashboard']['admin_footer_version'] ) && $sp_config['dashboard']['admin_footer_version'] ) {
	function _sp_dashboard_admin_footer_version() {
		global $sp_config;
		return $sp_config['dashboard']['admin_footer_version'];
	}
	add_filter( 'update_footer', '_sp_dashboard_admin_footer_version', 20 );
}

if ( isset( $sp_config['dashboard']['remove-html-head'] ) && $sp_config['dashboard']['remove-html-head'] ) {
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
}

if ( isset( $sp_config['dashboard']['disable-core-updates'] ) && $sp_config['dashboard']['disable-core-updates'] ) {
	// ver 2.3 to 2.7:
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
	// ver 2.8 to 3.0:
	remove_action( 'wp_version_check', 'wp_version_check' );
	remove_action( 'admin_init', '_maybe_update_core' );
	add_filter( 'pre_transient_update_core', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_version_check' );
	// ver 3.0:
	add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_version_check' );
}

if ( isset( $sp_config['dashboard']['disable-theme-updates'] ) && $sp_config['dashboard']['disable-theme-updates'] ) {
	// ver 2.8 to 3.0:
	remove_action( 'load-themes.php', 'wp_update_themes' );
	remove_action( 'load-update.php', 'wp_update_themes' );
	remove_action( 'admin_init', '_maybe_update_themes' );
	remove_action( 'wp_update_themes', 'wp_update_themes' );
	add_filter( 'pre_transient_update_themes', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_update_themes' );
	// ver 3.0:
	remove_action( 'load-update-core.php', 'wp_update_themes' );
	add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_update_themes' );
}

if ( isset( $sp_config['dashboard']['disable-plugin-updates'] ) && $sp_config['dashboard']['disable-plugin-updates'] ) {
	// ver 2.8 to 3.0:
	remove_action( 'load-plugins.php', 'wp_update_plugins' );
	remove_action( 'load-update.php', 'wp_update_plugins' );
	remove_action( 'admin_init', '_maybe_update_plugins' );
	remove_action( 'wp_update_plugins', 'wp_update_plugins' );
	add_filter( 'pre_transient_update_plugins', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_update_plugins' );
	// ver 3.0:
	remove_action( 'load-update-core.php', 'wp_update_plugins' );
	add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
	wp_clear_scheduled_hook( 'wp_update_plugins' );
}

function _sp_dashboard_enqueue_assets_wp_login() {
	wp_enqueue_style( 'web.wp-login', SP_CSS . '/web.wp-login.css', array(), false, 'all' );
}
add_action( 'login_enqueue_scripts', '_sp_dashboard_enqueue_assets_wp_login', 10 );

if ( isset( $sp_config['dashboard']['wp-login-header-url'] ) && ! empty( $sp_config['dashboard']['wp-login-header-url'] ) ) {
	function _sp_dashboard_login_headerurl() {
		global $sp_config;
		return $sp_config['dashboard']['wp-login-header-url'];
	}
	add_filter( 'login_headerurl', '_sp_dashboard_login_headerurl' );
}

if ( isset( $sp_config['dashboard']['wp-login-header-title'] ) && ! empty( $sp_config['dashboard']['wp-login-header-title'] ) ) {
	function _sp_dashboard_login_headertitle() {
		global $sp_config;
		return $sp_config['dashboard']['wp-login-header-title'];
	}
	add_filter( 'login_headertitle', '_sp_dashboard_login_headertitle' );
}

if ( isset( $sp_config['dashboard']['wp-login-header-image'] ) && sizeof( $sp_config['dashboard']['wp-login-header-image'] ) ) {
	function _sp_dashboard_login_headerimage() {
		global $sp_config;
		$image_src = $sp_config['dashboard']['wp-login-header-image']['src'];
		$image_width = $sp_config['dashboard']['wp-login-header-image']['width'];
		$image_height = $sp_config['dashboard']['wp-login-header-image']['height'];
		echo '<style type="text/css" media="all">/* <![CDATA[ */';
		printf( '.login h1 a { width: %s; height: %s; background-image: url(\'%s\'); background-size: %spx %spx; }',
			$image_width, $image_height, $image_src, $image_width, $image_height
		);
		echo '/* ]]> */</style>';
	}
	add_action( 'login_enqueue_scripts', '_sp_dashboard_login_headerimage' );
}

if ( isset( $sp_config['dashboard']['wp-login-redirect'] ) && ! empty( $sp_config['dashboard']['wp-login-redirect'] ) ) {
	function _sp_dashboard_login_redirect() {
		global $sp_config;
		return $sp_config['dashboard']['wp-login-redirect'];
	}
	add_filter( 'login_redirect', '_sp_dashboard_login_redirect', 10, 3 );
}


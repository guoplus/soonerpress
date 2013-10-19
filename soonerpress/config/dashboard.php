<?php
/**
 * Dashboard module configuration
 *
 * @package SoonerPress
 * @subpackage Dashboard
 */


global $sp_config;

$sp_config['dashboard'] = array(
	// Remove non-used admin menu
	'remove-admin-menu'            => array(  ), // __('Posts'), __('Links'), __('Comments'), __('Tools')
	// Remove dashboard widgets
	'remove-dashboard-widgets'     => true,
	// custom admin footer copyright text
	'admin_footer_copyright'       => 'Copyright &copy; ' . date('Y'),
	// custom admin footer version text
	'admin_footer_version'         => __( 'Powered by WordPress.', 'sp' ),
	// Remove redundant HTML head
	'remove-html-head'             => true,
	// Disable core updates
	'disable-core-updates'         => false,
	// Disable theme updates
	'disable-theme-updates'        => false,
	// Disable plugin updates
	'disable-plugin-updates'       => false,
	// Login form logo link URL
	'wp-login-header-url'          => trailingslashit( home_url() ),
	// Login form logo link title
	'wp-login-header-title'        => get_bloginfo( 'name' ),
	// Login form logo image
	'wp-login-header-image'        => SP_IMG . '/wp-login-header.png',
	'wp-login-header-image-width'  => '274',
	'wp-login-header-image-height' => '63',
	// Redirect to specified URL after login
	'wp-login-redirect'            => admin_url( 'admin.php?page=options_panel' ),
);


<?php
/**
 * Dashboard module configuration
 *
 * @package SoonerPress
 * @subpackage Dashboard
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['dashboard'] = array(
	// Remove non-used admin menu pages
	'remove-admin-menu-pages'      => array(),
	// Remove dashboard widgets
	'remove-dashboard-widgets'     => true,
	// custom admin footer copyright text
	'admin_footer_copyright'       => __( 'Copyright', 'sp' ) . ' &copy; ' . date('Y'),
	// custom admin footer version text
	'admin_footer_version'         => __( 'Powered by <a href="http://wordpress.org" target="_blank">WordPress</a>.', 'sp' ),
	// Remove unnecessary HTML head
	'remove-unnecessary-html-head' => true,
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


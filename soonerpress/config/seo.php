<?php
/**
 * SEO module configuration
 *
 * @package SoonerPress
 * @subpackage SEO
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['seo'] = array(
	'post' => array( 'title', 'description' ),
	'page' => array( 'title', 'description', 'keywords' )
);


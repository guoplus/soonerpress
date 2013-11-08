<?php
/**
 * Pagination module configuration
 *
 * @package SoonerPress
 * @subpackage Pagination
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

global $sp_config;

$sp_config['pagination'] = array(
	'range'                 => 5,
	'first'                 => ' &laquo; ',
	'last'                  => ' &raquo; ',
	'previous'              => ' &lsaquo; ',
	'next'                  => ' &rsaquo; ',
	'previous_extend'       => '...',
	'next_extend'           => '...',
	'before'                => '<div class="pagination">',
	'after'                 => '</div>',
	'show_in_only_one_page' => true,
);


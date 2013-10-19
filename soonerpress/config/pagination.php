<?php
/**
 * Pagination module configuration
 *
 * @package SoonerPress
 * @subpackage Pagination
 */


global $sp_config;

$sp_config['pagination'] = array(
	'range'           => 5,
	'first'           => ' &laquo; ',
	'last'            => ' &raquo; ',
	'previous'        => ' &lsaquo; ',
	'next'            => ' &rsaquo; ',
	'previous_extend' => '...',
	'next_extend'     => '...',
	'before'          => '<div class="pagination">',
	'after'           => '</div>',
);


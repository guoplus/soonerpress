<?php
/**
 * Multilingual module API
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */


/** get current language */
function sp_ml_lang() {
	global $sp_config;
	$lang = isset( $_GET['lang'] ) ? substr( $_GET['lang'], 0, 4 ) : '';
	if( ! in_array( $lang, $sp_config['multilingual']['enabled'] ) )
		$lang = $sp_config['multilingual']['default'];
	return $lang;
}

/** languages selector HTML output */
function sp_ml_html_selector( $args = array(), $echo = false ) {
	$output = '';
	$s = wp_parse_args( $args, array(
		'container_class' => 'sp-ml-lang-tabs',
		'button_class' => 'sp-ml-lang-tab',
		'type' => 'select',
		'separator' => ' | ',
	) );
	$output .= '<span class="'.esc_attr( $s['container_class'] ).' sp-ml-lang-tabs-'.esc_attr( $s['type'] ).'">';
	global $sp_config;
	switch( $s['type'] ) {
		case 'select':
			$output .= '<select>';
			foreach( $sp_config['multilingual']['enabled'] as $k => $l ) {
				$output .= sprintf( '<option value="%s">%s</option>',
					esc_attr( $l ),
					esc_html( $sp_config['multilingual']['names'][$l] )
				);
			}
			$output .= '</select>';
			break;
		case 'text':
			foreach( $sp_config['multilingual']['enabled'] as $k => $l ) {
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s">%s</a>',
					esc_attr( $sp_config['multilingual']['names'][$l] ),
					esc_attr( $l ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $l ),
					esc_html( $sp_config['multilingual']['names'][$l] )
				);
				if( $k <= count( $sp_config['multilingual']['enabled'] ) - 2 )
					$output .= $s['separator'];
			}
			break;
		case 'img':
			foreach( $sp_config['multilingual']['enabled'] as $k => $l ) {
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" align="absmiddle" /></a>',
					esc_attr( $sp_config['multilingual']['names'][$l] ),
					esc_attr( $l ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $l ),
					esc_attr( SP_INC_URI . '/multilingual/images/flags/' . $sp_config['multilingual']['flags'][$l] ),
					esc_attr( $l )
				);
			}
			break;
	}
	$output .= '</span>';
	if( $echo )
		echo $output;
	else
		return $output;
}

/** languages selector tabs HTML output (for dashboard) */
function _sp_ml_html_selector_admin() {
	return sp_ml_html_selector( array( 'type' => 'img' ), false );
}

// ==================== enqueue scripts and stylesheets ====================

function sp_ml_enqueue_assets_frontpage() {

	global $sp_config;

	wp_enqueue_script( 'sp.multilingual.frontpage', SP_INC_URI . '/multilingual/sp.multilingual.frontpage.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['multilingual']['enabled'],
	);
	wp_localize_script( 'sp.multilingual.frontpage', 'sp_multi_language', $params );

}
add_action( 'wp_enqueue_scripts', 'sp_ml_enqueue_assets_frontpage' );

function sp_ml_enqueue_assets_dashboard() {

	global $sp_config;

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'fontawesome-ie7' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.multilingual.dashboard', SP_INC_URI . '/multilingual/sp.multilingual.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.multilingual.dashboard', SP_INC_URI . '/multilingual/sp.multilingual.dashboard.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['multilingual']['enabled'],
		'main_stored' => $sp_config['multilingual']['main_stored'],
	);
	wp_localize_script( 'sp.multilingual.dashboard', 'sp_multi_language', $params );

}
add_action( 'admin_enqueue_scripts', 'sp_ml_enqueue_assets_dashboard' );


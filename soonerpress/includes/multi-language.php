<?php


/** filter the specified language string from the original data */
function sp_ml_ext( $original, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	if( is_serialized( $original ) ) {
		$original = sp_unserialize( $original );
	} elseif( ! is_array( $original ) ) {
		$original_new = json_decode( $original, true );
		if( is_array( $original_new ) )
			$original = $original_new;
	}
	if( is_array( $original ) ) {
		if( isset( $original['ml'] ) && isset( $original[$lang] ) )
			return $original[$lang];
		else
			return '';
	} else {
		return $original;
	}
}

/** get current language */
function sp_ml_lang() {
	global $sp_config;
	$lang = isset( $_GET['lang'] ) ? substr( $_GET['lang'], 0, 2 ) : '';
	if( ! in_array( $lang, $sp_config['languages']['enabled'] ) )
		$lang = $sp_config['languages']['default'];
	return $lang;
}

/** languages selector HTML output */
function sp_ml_html_selector( $args = array(), $echo = false ) {
	$output = '';
	$s = wp_parse_args( $args, array(
		'container_class' => 'sp-ml-selector',
		'type' => 'select',
		'separator' => ' | ',
	) );
	$output .= '<span class="' . esc_attr( $s['container_class'] ) . '">';
	global $sp_config;
	switch( $s['type'] ) {
		case 'select':
			$output .= '<select>';
			foreach( $sp_config['languages']['enabled'] as $k => $l ) {
				$output .= sprintf( '<option value="%s">%s</option>',
					esc_attr( $l ),
					esc_html( $sp_config['languages']['names'][$l] )
				);
			}
			$output .= '</select>';
			break;
		case 'text':
			foreach( $sp_config['languages']['enabled'] as $k => $l ) {
				$output .= sprintf( '<a href="#" title="%s">%s</a>',
					esc_attr( $sp_config['languages']['names'][$l] ),
					esc_html( $sp_config['languages']['names'][$l] ),
					esc_attr( $l )
				);
				if( $k == count( $sp_config['languages']['enabled'] ) - 1 )
					$output .= $s['separator'];
			}
			break;
		case 'img':
			foreach( $sp_config['languages']['enabled'] as $k => $l ) {
				$output .= sprintf( '<a href="#" title="%s"><img src="%s" alt="%s" /></a>',
					esc_attr( $sp_config['languages']['names'][$l] ),
					esc_attr( SP_INCLUDES_URI . '/multi-language/images/flags/' . $sp_config['languages']['flags'][$l] ),
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
function _sp_ml_html_languages_tabs( $args = array(), $echo = false ) {
	$output = '';
	$s = wp_parse_args( $args, array(
		'container_class' => 'sp-ml-lang-tabs',
		'button_class' => 'sp-ml-lang-tab',
	) );
	$output .= '<span class="' . esc_attr( $s['container_class'] ) . '">';
	global $sp_config;
	foreach( $sp_config['languages']['enabled'] as $k => $l ) {
		$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s"><img align="absmiddle" src="%s" alt="%s" /></a>',
			esc_attr( $sp_config['languages']['names'][$l] ),
			esc_attr( $l ),
			esc_attr( $s['button_class'] . '-' . $l ),
			esc_attr( SP_INCLUDES_URI . '/multi-language/images/flags/' . $sp_config['languages']['flags'][$l] ),
			esc_attr( $l )
		);
	}
	$output .= '</span>';
	if( $echo )
		echo $output;
	else
		return $output;
}

function _sp_multi_language_the_editor() {
	global $sp_config, $post;
	$post_type = get_post_type( $post );
	foreach( $sp_config['languages']['enabled'] as $l ) {
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$post_title   = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_title',   $l ) : '' );
		$post_content = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_content', $l ) : '' );
		$post_excerpt = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_excerpt', $l ) : '' );
		// post title field
		if ( post_type_supports( $post_type, 'title' ) ) {
			echo '<div class="sp-pe-one-field-l-post-title sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<input type="text" name="post_title_'.$l.'" id="post_title_'.$l.'" size="30" value="'.esc_attr( $post_title ).'" autocomplete="off" />';
			echo '</div>';
		}
		// post content field
		if ( post_type_supports( $post_type, 'editor' ) ) {
			echo '<div class="sp-pe-one-field-l-post-content sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			wp_editor( $post_content, 'post_content_'.$l, array(
				'textarea_name' => 'post_content_'.$l,
				'dfw' => true,
				'tabfocus_elements' => 'insert-media-button,save-post',
				'editor_height' => 360,
			) );
			echo '</div>';
		}
		// post excerpt field
		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			echo '<div class="sp-pe-one-field-l-post-excerpt sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<textarea rows="1" cols="40" name="post_excerpt_'.$l.'" id="post_excerpt_'.$l.'">' . esc_textarea( $post_excerpt ) . '</textarea>';
			echo '</div>';
		}
		// languages selector
		echo '<div id="sp-pe-languages-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_ml_html_languages_tabs() . '</div>';
	}
}
add_action( 'edit_form_after_editor', '_sp_multi_language_the_editor' );

function _sp_multi_language_save_post( $post_id ) {
	global $sp_config;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		// ignore the language main stored in `post` table
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$post_title_tmp   = ( isset( $_POST['post_title_'.$l]   ) ? $_POST['post_title_'.$l]   : '' );
		$post_content_tmp = ( isset( $_POST['post_content_'.$l] ) ? $_POST['post_content_'.$l] : '' );
		$post_excerpt_tmp = ( isset( $_POST['post_excerpt_'.$l] ) ? $_POST['post_excerpt_'.$l] : '' );
		update_post_meta( $post_id, '__post_title_'.$l,   $post_title_tmp   );
		update_post_meta( $post_id, '__post_content_'.$l, $post_content_tmp );
		update_post_meta( $post_id, '__post_excerpt_'.$l, $post_excerpt_tmp );
	}
}
add_action( 'save_post', '_sp_multi_language_save_post' );

function sp_ml_ext_post_field( $post_id, $field, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	$post = get_post( intval( $post_id ) );
	if( $post && in_array( $field, array( 'post_title', 'post_content', 'post_excerpt' ) ) ) {
		global $sp_config;
		if( $sp_config['languages']['main_stored'] == $lang )
			return $post->$field;
		else
			return get_post_meta( $post_id, '__'.$field.'_'.$lang, true );
	}
	return '';
}

/** handle post_title, post_content, post_excerpt translation */
function _sp_ml_ext_post_title( $title, $post_id ) {
	$post_type = get_post_type( $post_id );
	// ignore unnecessary post types
	if( in_array( $post_type, array( 'nav_menu_item' ) ) )
		return $title;
	else
		return sp_ml_ext_post_field( $post_id, 'post_title' );
}
function _sp_ml_ext_post_content( $content ) {
	global $post; return sp_ml_ext_post_field( $post->ID, 'post_content' );
}
function _sp_ml_ext_post_excerpt( $excerpt ) {
	global $post; return sp_ml_ext_post_field( $post->ID, 'post_excerpt' );
}

add_filter( 'the_title', '_sp_ml_ext_post_title', 0, 2 );
add_filter( 'the_content', '_sp_ml_ext_post_content', 0, 1 );
add_filter( 'the_excerpt', '_sp_ml_ext_post_excerpt', 0, 1 );
add_filter( 'the_excerpt_rss', '_sp_ml_ext_post_excerpt', 0, 1 );

// ==================== enqueue scripts and stylesheets ====================

function sp_multi_language_enqueue_assets_frontend() {

	global $sp_config;

	wp_enqueue_script( 'sp.multi-language', SP_INCLUDES_URI . '/multi-language/sp.multi-language.front-end.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['languages']['enabled'],
	);
	wp_localize_script( 'sp.multi-language', 'sp_multi_language', $params );

}
add_action( 'wp_enqueue_scripts', 'sp_multi_language_enqueue_assets_frontend' );

function sp_multi_language_enqueue_assets_backend() {

	global $sp_config;

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery.json' );
	sp_enqueue_bootstrap_js();
	add_thickbox();
	wp_enqueue_style( 'sp.multi-language', SP_INCLUDES_URI . '/multi-language/sp.multi-language.back-end.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.multi-language', SP_INCLUDES_URI . '/multi-language/sp.multi-language.back-end.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['languages']['enabled'],
		'main_stored' => $sp_config['languages']['main_stored'],
	);
	wp_localize_script( 'sp.multi-language', 'sp_multi_language', $params );

}
add_action( 'admin_enqueue_scripts', 'sp_multi_language_enqueue_assets_backend' );

// ==================== hooks ====================

// general

add_filter( 'sp_option', 'sp_ml_ext', 10, 2 ); // extract option value using multi-language if enabled

// nav menus

function _sp_ml_menus_config_filter( $menus ) {
	global $sp_config;
	$menus_new = array();
	foreach ( $sp_config['languages']['enabled'] as $l )
		foreach ( $menus as $menu_id => $menu_name )
			$menus_new[$menu_id.'-'.$l] = $menu_name.' ['.$sp_config['languages']['names'][$l].']';
	return $menus_new;
}
add_filter( 'sp_menus_config', '_sp_ml_menus_config_filter' );

// options panel

function _sp_ml_op_header_footer() {
	echo _sp_ml_html_languages_tabs();
}
add_action( 'sp_op_header', '_sp_ml_op_header_footer' );
add_action( 'sp_op_footer', '_sp_ml_op_header_footer' );

function _sp_ml_op_one_name_filter( $HTML, $enabled_ml ) {
	if( $enabled_ml )
		return $HTML . _sp_ml_html_languages_tabs();
	else
		return $HTML;
}
add_filter( 'sp_op_one_name', '_sp_ml_op_one_name_filter', 10, 2 );

// post custom meta

function _sp_ml_ext_pm( $value, $post_id, $key, $lang ) {
	return sp_ml_ext( $value, $lang );
}
add_filter( 'sp_pm', '_sp_ml_ext_pm', 10, 4 );

function _sp_ml_pm_one_name_filter( $HTML, $enabled_ml ) {
	if( $enabled_ml )
		return $HTML . _sp_ml_html_languages_tabs();
	else
		return $HTML;
}
add_filter( 'sp_pm_one_name', '_sp_ml_pm_one_name_filter', 10, 2 );


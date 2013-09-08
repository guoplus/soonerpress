<?php


/** get current language */
function sp_ml_lang() {
	global $sp_config;
	$lang = isset( $_GET['lang'] ) ? substr( $_GET['lang'], 0, 4 ) : '';
	if( ! in_array( $lang, $sp_config['languages']['enabled'] ) )
		$lang = $sp_config['languages']['default'];
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
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s">%s</a>',
					esc_attr( $sp_config['languages']['names'][$l] ),
					esc_attr( $l ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $l ),
					esc_html( $sp_config['languages']['names'][$l] )
				);
				if( $k <= count( $sp_config['languages']['enabled'] ) - 2 )
					$output .= $s['separator'];
			}
			break;
		case 'img':
			foreach( $sp_config['languages']['enabled'] as $k => $l ) {
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" align="absmiddle" /></a>',
					esc_attr( $sp_config['languages']['names'][$l] ),
					esc_attr( $l ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $l ),
					esc_attr( SP_INC_URI . '/multi-language/images/flags/' . $sp_config['languages']['flags'][$l] ),
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

function _sp_ml_add_meta_boxes( $post_type, $post ) {
	global $sp_config;
	// do not show multilanguage meta box if not enabled in current post type
	if( isset( $sp_config['languages']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['languages']['post_type'] ) )
			return false;
	add_meta_box( '_sp_ml_metabox', __( 'Multi Languages', 'sp' ), '_sp_ml_do_metabox', $post_type,
					'side', 'default' );
}
add_action( 'add_meta_boxes', '_sp_ml_add_meta_boxes', 10, 2 );

function _sp_ml_do_metabox( $post ) {
	global $sp_config;
	echo '<div id="sp-ml-post-edit-metabox">';
	echo '<h4>' . __( 'Languages Selector:', 'sp' ) . '</h4>';
	echo '<ul class="sp-ml-lang-tabs-custom" id="sp-pe-languages-selector">';
	foreach( $sp_config['languages']['enabled'] as $k => $l ) {
		printf( '<li><a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" />%s</a></li>',
			esc_attr( $sp_config['languages']['names'][$l] ),
			esc_attr( $l ),
			'button sp-ml-lang-tab-' . $l,
			esc_attr( SP_INC_URI . '/multi-language/images/flags/' . $sp_config['languages']['flags'][$l] ),
			esc_attr( $l ),
			'&nbsp;&nbsp;' . esc_html( $sp_config['languages']['names'][$l] )
		);
	}
	echo '</ul></div>';
}

// preload taxonomies slug list
global $sp_config;
if( isset( $sp_config['languages']['taxonomy'] ) )
	$taxonomies_ml_tmp = (array) $sp_config['languages']['taxonomy'];
else {
	global $wp_taxonomies;
	$taxonomies_ml_tmp = array_keys( $wp_taxonomies );
}

function _sp_ml_post_edit_fields() {
	global $sp_config, $post;
	$post_type = get_post_type( $post );
	// do not add multilanguage fields if not enabled in current post type
	if( isset( $sp_config['languages']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['languages']['post_type'] ) )
			return false;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$post_title   = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_title',   $l ) : '' );
		$post_content = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_content', $l ) : '' );
		$post_excerpt = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_excerpt', $l ) : '' );
		// post title field
		if ( post_type_supports( $post_type, 'title' ) ) {
			echo '<div class="sp-pe-one-field-post_title-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<input type="text" name="post_title'.SP_META_LANG_PREFIX.$l.'" id="post_title'.SP_META_LANG_PREFIX.$l.'" size="30" value="'.esc_attr( $post_title ).'" autocomplete="off" />';
			echo '</div>';
		}
		// post content field
		if ( post_type_supports( $post_type, 'editor' ) ) {
			echo '<div class="sp-pe-one-field-post_content-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			wp_editor( $post_content, 'post_content'.SP_META_LANG_PREFIX.$l, array(
				'textarea_name' => 'post_content'.SP_META_LANG_PREFIX.$l,
				'dfw' => true,
				'tabfocus_elements' => 'insert-media-button,save-post',
				'editor_height' => 360,
			) );
			echo '</div>';
		}
		// post excerpt field
		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			echo '<div class="sp-pe-one-field-post_excerpt-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<textarea rows="1" cols="40" name="post_excerpt'.SP_META_LANG_PREFIX.$l.'" id="post_excerpt'.SP_META_LANG_PREFIX.$l.'">' . esc_textarea( $post_excerpt ) . '</textarea>';
			echo '</div>';
		}
	}
}
add_action( 'edit_form_after_editor', '_sp_ml_post_edit_fields' );

function _sp_ml_term_add_fields( $taxonomy ) {
	global $sp_config;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		// term name
		echo '<div class="sp-te-one-field-name-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
		echo '<input name="name'.SP_META_LANG_PREFIX.$l.'" tyte="text" value="" size="40" aria-required="true" />';
		echo '</div>';
		// term description
		echo '<div class="sp-te-one-field-description-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
		echo '<textarea name="description'.SP_META_LANG_PREFIX.$l.'" rows="5" cols="50" class="large-text"></textarea>';
		echo '</div>';
	}
	// languages selector
	echo '<div class="sp-te-languages-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_ml_html_selector_admin() . '</div>';
}
function _sp_ml_term_edit_fields( $term, $taxonomy ) {
	global $sp_config;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$term_name = sp_ml_ext_term_field( $term->term_id, $taxonomy, 'name', $l );
		$term_description = sp_ml_ext_term_field( $term->term_id, $taxonomy, 'description', $l );
		// term name
		echo '<div class="sp-te-one-field-name-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
		echo '<input name="name'.SP_META_LANG_PREFIX.$l.'" tyte="text" value="'.esc_attr($term_name).'" size="40" aria-required="true" />';
		echo '</div>';
		// term description
		echo '<div class="sp-te-one-field-description-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
		echo '<textarea name="description'.SP_META_LANG_PREFIX.$l.'" rows="5" cols="50" class="large-text">'.esc_textarea($term_description).'</textarea>';
		echo '</div>';
	}
	// languages selector
	echo '<div class="sp-te-languages-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_ml_html_selector_admin() . '</div>';
}
foreach( $taxonomies_ml_tmp as $taxonomy ) {
	add_action( $taxonomy.'_add_form', '_sp_ml_term_add_fields', 10, 1 );
	add_action( $taxonomy.'_edit_form', '_sp_ml_term_edit_fields', 10, 2 );
}

function sp_ml_ext_post_field( $post_id, $field, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	$post = get_post( intval( $post_id ) );
	if( $post && in_array( $field, array( 'post_title', 'post_content', 'post_excerpt' ) ) ) {
		global $sp_config;
		if( $sp_config['languages']['main_stored'] == $lang )
			return $post->$field;
		else
			return get_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang, true );
	}
	return null;
}

function sp_ml_ext_term_field( $term_id, $taxonomy, $field, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	$term = get_term( intval( $term_id ), $taxonomy );
	if( $term && in_array( $field, array( 'name', 'description' ) ) ) {
		global $sp_config;
		if( $sp_config['languages']['main_stored'] == $lang )
			return $term->$field;
		else
			return sp_get_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang );
	}
	return null;
}

function _sp_ml_save_post( $post_id ) {
	global $sp_config;
	$post_type = get_post_type( $post_id );
	if( isset( $sp_config['languages']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['languages']['post_type'] ) )
			return false;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		// ignore the language main stored in `post` table
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$post_title_tmp   = ( isset( $_POST['post_title'.SP_META_LANG_PREFIX.$l]   ) ? $_POST['post_title'.SP_META_LANG_PREFIX.$l]   : '' );
		$post_content_tmp = ( isset( $_POST['post_content'.SP_META_LANG_PREFIX.$l] ) ? $_POST['post_content'.SP_META_LANG_PREFIX.$l] : '' );
		$post_excerpt_tmp = ( isset( $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] ) ? $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] : '' );
		// write datebase
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_title'.SP_META_LANG_PREFIX.$l,   $post_title_tmp   );
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_content'.SP_META_LANG_PREFIX.$l, $post_content_tmp );
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_excerpt'.SP_META_LANG_PREFIX.$l, $post_excerpt_tmp );
	}
}
add_action( 'save_post', '_sp_ml_save_post' );

function _sp_ml_save_term( $term_id, $tt_id ) {
	global $sp_config;
	foreach( $sp_config['languages']['enabled'] as $l ) {
		if( $l == $sp_config['languages']['main_stored'] ) continue;
		$term_name_tmp        = ( isset( $_POST['name'.SP_META_LANG_PREFIX.$l]        ) ? $_POST['name'.SP_META_LANG_PREFIX.$l]        : '' );
		$term_description_tmp = ( isset( $_POST['description'.SP_META_LANG_PREFIX.$l] ) ? $_POST['description'.SP_META_LANG_PREFIX.$l] : '' );
		// write datebase
		sp_update_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.'name'.SP_META_LANG_PREFIX.$l,        $term_name_tmp        );
		sp_update_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.'description'.SP_META_LANG_PREFIX.$l, $term_description_tmp );
	}
}
foreach( $taxonomies_ml_tmp as $taxonomy ) {
	add_action( 'created_'.$taxonomy, '_sp_ml_save_term', 10, 2 );
	add_action( 'edited_'.$taxonomy, '_sp_ml_save_term', 10, 2 );
}

// ==================== enqueue scripts and stylesheets ====================

function sp_ml_enqueue_assets_frontpage() {

	global $sp_config;

	wp_enqueue_script( 'sp.multi-language.frontpage', SP_INC_URI . '/multi-language/sp.multi-language.frontpage.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['languages']['enabled'],
	);
	wp_localize_script( 'sp.multi-language.frontpage', 'sp_multi_language', $params );

}
add_action( 'wp_enqueue_scripts', 'sp_ml_enqueue_assets_frontpage' );

function sp_ml_enqueue_assets_dashboard() {

	global $sp_config;

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'fontawesome-ie7' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.multi-language.dashboard', SP_INC_URI . '/multi-language/sp.multi-language.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.multi-language.dashboard', SP_INC_URI . '/multi-language/sp.multi-language.dashboard.js', array( 'jquery' ), false, true );

	$params = array(
		'current' => sp_ml_lang(),
		'enabled' => $sp_config['languages']['enabled'],
		'main_stored' => $sp_config['languages']['main_stored'],
	);
	wp_localize_script( 'sp.multi-language.dashboard', 'sp_multi_language', $params );

}
add_action( 'admin_enqueue_scripts', 'sp_ml_enqueue_assets_dashboard' );

// ==================== hooks ====================

// general

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

function _sp_ml_op_option_name_filter( $option_name, $lang = '' ) {
	global $sp_config;
	if( ! empty( $lang ) && $sp_config['languages']['main_stored'] != $lang )
		return $option_name . SP_META_LANG_PREFIX . $lang;
	return $option_name;
}
add_filter( 'sp_option_name', '_sp_ml_op_option_name_filter', 10, 2 );

function _sp_ml_op_header_footer() {
	echo _sp_ml_html_selector_admin();
}
add_action( 'sp_op_header', '_sp_ml_op_header_footer' );
add_action( 'sp_op_footer', '_sp_ml_op_header_footer' );

function _sp_ml_cm_one_name_filter( $html, $enabled_ml ) {
	if( $enabled_ml )
		return $html . _sp_ml_html_selector_admin();
	else
		return $html;
}
add_filter( 'sp_op_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_op_register_setting( $option_group, $option_name, $option ) {
	global $sp_config;
	if( ! isset( $option['ml'] ) || ( isset( $option['ml'] ) && $option['ml'] ) )
		foreach( $sp_config['languages']['enabled'] as $l ) {
			if( $l == $sp_config['languages']['main_stored'] ) continue;
			register_setting( $option_group, $option_name . SP_META_LANG_PREFIX . $l );
		}
}
add_action( 'sp_op_register_setting', '_sp_ml_op_register_setting', 10, 3 );

// post custom meta

function _sp_ml_meta_key_filter( $meta_key, $post_id, $lang ) {
	global $sp_config;
	if( ! empty( $lang ) && $sp_config['languages']['main_stored'] != $lang )
		return $meta_key . SP_META_LANG_PREFIX . $lang;
	return $meta_key;
}
add_filter( 'sp_pm_meta_key', '_sp_ml_meta_key_filter', 10, 3 );

add_filter( 'sp_pm_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_pm_update_postmeta( $meta_key, $field, $post_id, $is_ml ) {
	global $sp_config;
	if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
		foreach( $sp_config['languages']['enabled'] as $l ) {
			if( $l == $sp_config['languages']['main_stored'] ) continue;
			$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
				$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
			update_post_meta( $post_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
		}
}
add_action( 'sp_pm_update_postmeta', '_sp_ml_pm_update_postmeta', 10, 4 );

// taxonomy custom meta

add_filter( 'sp_tm_meta_key', '_sp_ml_meta_key_filter', 10, 3 );

add_filter( 'sp_tm_one_name', '_sp_ml_cm_one_name_filter', 10, 2 );

function _sp_ml_tm_update_termmeta( $meta_key, $field, $term_id, $is_ml ) {
	global $sp_config;
	if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
		foreach( $sp_config['languages']['enabled'] as $l ) {
			if( $l == $sp_config['languages']['main_stored'] ) continue;
			$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
				$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
			sp_update_term_meta( $term_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
		}
}
add_action( 'sp_tm_update_termmeta', '_sp_ml_tm_update_termmeta', 10, 4 );


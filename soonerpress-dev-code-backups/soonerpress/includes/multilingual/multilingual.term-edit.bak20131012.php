<?php


// preload taxonomies slug list
global $sp_config;
if( isset( $sp_config['multilingual']['taxonomy'] ) )
	$taxonomies_ml_tmp = (array) $sp_config['multilingual']['taxonomy'];
else {
	global $wp_taxonomies;
	$taxonomies_ml_tmp = array_keys( $wp_taxonomies );
}

function _sp_ml_term_add_fields( $taxonomy ) {
	global $sp_config;
	foreach( $sp_config['multilingual']['enabled'] as $l ) {
		if( $l == $sp_config['multilingual']['main_stored'] ) continue;
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
	echo '<div class="sp-te-multilingual-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_ml_html_selector_admin() . '</div>';
}
function _sp_ml_term_edit_fields( $term, $taxonomy ) {
	global $sp_config;
	foreach( $sp_config['multilingual']['enabled'] as $l ) {
		if( $l == $sp_config['multilingual']['main_stored'] ) continue;
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
	echo '<div class="sp-te-multilingual-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_ml_html_selector_admin() . '</div>';
}
foreach( $taxonomies_ml_tmp as $taxonomy ) {
	add_action( $taxonomy.'_add_form', '_sp_ml_term_add_fields', 10, 1 );
	add_action( $taxonomy.'_edit_form', '_sp_ml_term_edit_fields', 10, 2 );
}

function sp_ml_ext_term_field( $term_id, $taxonomy, $field, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	$term = get_term( intval( $term_id ), $taxonomy );
	if( $term && in_array( $field, array( 'name', 'description' ) ) ) {
		global $sp_config;
		if( $sp_config['multilingual']['main_stored'] == $lang )
			return $term->$field;
		else
			return sp_get_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang );
	}
	return null;
}

function _sp_ml_save_term( $term_id, $tt_id ) {
	global $sp_config;
	foreach( $sp_config['multilingual']['enabled'] as $l ) {
		if( $l == $sp_config['multilingual']['main_stored'] ) continue;
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


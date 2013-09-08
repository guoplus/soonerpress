<?php


// get term meta stored by Taxonomy Custom Meta
function sp_tm( $term_id, $key, $lang = '' ) {
	$value = sp_get_term_meta( $term_id, apply_filters( 'sp_tm_meta_key', SP_CUSTOM_META_PREFIX . $key, $term_id, $lang ) );
	return $value;
}

// preload taxonomies slug list
global $wp_taxonomies;
$taxonomies_tm_tmp = array_keys( $wp_taxonomies );

function _sp_tm_term_add_fields( $taxonomy ) {
	global $sp_config;
	foreach ( $sp_config['taxonomy-custom-meta']['boxes'] as $box ) {
		if ( ! in_array( $taxonomy, (array) $box['taxonomy'] ) )
			continue;
		$ml = isset( $box['ml'] ) ? $box['ml'] : true;
		foreach ( $box['fields'] as $entry ) {
			echo '<div class="form-field sp-tm-field-one sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';
			echo '<label for="" class="sp-cm-one-name">' . $entry['title'] . '</label>';
			if ( sp_enabled_module( 'multi-language' ) && $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
				// multi-language is enabled & available
				foreach ( $sp_config['languages']['enabled'] as $l ) {
					echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $l ) . '">';
					_sp_tm_do_entry_html_field( $entry, 0, $l );
					echo '</div>';
				}
			} else {
				// not in multi-language
				echo '<div class="sp-cm-one-field-content">';
				_sp_tm_do_entry_html_field( $entry, 0 );
				echo '</div>';
			}
			echo '<p class="sp-cm-one-desc">' . $entry['desc'] . '</p>';
			echo '</div>';
		}
	}
}

function _sp_tm_term_edit_fields( $term, $taxonomy ) {
	global $sp_config;
	foreach ( $sp_config['taxonomy-custom-meta']['boxes'] as $box ) {
		if ( ! in_array( $taxonomy, (array) $box['taxonomy'] ) )
			continue;
		$ml = isset( $box['ml'] ) ? $box['ml'] : true;
		foreach ( $box['fields'] as $entry ) {
			echo '<tr class="form-field sp-tm-field-one sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';
			printf( '<th scope="row" valign="top"><label for="" class="sp-cm-one-name">%s</label></th><td>',
				apply_filters( 'sp_tm_one_name', $entry['title'], ( $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );
			if ( sp_enabled_module( 'multi-language' ) && $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
				// multi-language is enabled & available
				foreach ( $sp_config['languages']['enabled'] as $l ) {
					echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $l ) . '">';
					_sp_tm_do_entry_html_field( $entry, $term->term_id, $l );
					echo '</div>';
				}
			} else {
				// not in multi-language
				echo '<div class="sp-cm-one-field-content">';
				_sp_tm_do_entry_html_field( $entry, $term->term_id );
				echo '</div>';
			}
			echo '<span class="description sp-cm-one-desc">' . $entry['desc'] . '</span></td>';
			echo '</tr>';
		}
	}
}

function _sp_tm_do_entry_html_field( $entry, $term_id, $lang = '' ) {
	global $sp_config;
	$value = sp_tm( $term_id, $entry['id'], $lang );
	if ( false !== $value ) // a {false} will be returned if variable was not set
		$entry['value'] = $value;
	$entry['id'] = SP_CUSTOM_META_PREFIX . $entry['id'] .
		( ( ! empty( $lang ) && $sp_config['languages']['main_stored'] != $lang ) ? SP_META_LANG_PREFIX . $lang : '' );
	new SP_CM_FIELD ( $entry );
}

foreach( $taxonomies_tm_tmp as $taxonomy ) {
	add_action( $taxonomy.'_add_form_fields', '_sp_tm_term_add_fields', 10, 1 );
	add_action( $taxonomy.'_edit_form_fields', '_sp_tm_term_edit_fields', 10, 2 );
}

function _sp_tm_save_handler( $term_id, $tt_id, $taxonomy ) {
	global $sp_config;
	foreach ( $sp_config['taxonomy-custom-meta']['boxes'] as $box ) {
		if ( ! in_array( $taxonomy, (array) $box['taxonomy'] ) )
			continue;
		$ml = isset( $box['ml'] ) ? $box['ml'] : true;
		foreach ( $box['fields'] as $entry ) {
			$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$entry['id']] ) ? $_POST[SP_CUSTOM_META_PREFIX.$entry['id']] : '';
			$meta_key = SP_CUSTOM_META_PREFIX . $entry['id'];
			// write datebase
			sp_update_term_meta( $term_id, $meta_key, $data );
			do_action( 'sp_tm_update_termmeta', $meta_key, $entry, $term_id, $ml );
		}
	}
}
add_action( 'created_term', '_sp_tm_save_handler', 10, 3 );
add_action( 'edited_term', '_sp_tm_save_handler', 10, 3 );

function _sp_tm_enqueue_assets_dashboard() {

	global $pagenow;
	if ( 'edit-tags.php' != $pagenow )
		return;

	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.taxonomy-custom-meta.dashboard', SP_INC_URI . '/taxonomy-custom-meta/sp.taxonomy-custom-meta.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.taxonomy-custom-meta.dashboard', SP_INC_URI . '/taxonomy-custom-meta/sp.taxonomy-custom-meta.dashboard.js', array( 'jquery' ), false, true );

}
add_action( 'admin_enqueue_scripts', '_sp_tm_enqueue_assets_dashboard' );


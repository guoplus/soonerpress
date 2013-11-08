<?php
/**
 * Taxonomy Custom Fields module API
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/** get term custom meta stored by SoonerPress */
function sp_tm( $term_id, $key, $locale = '' ) {
	return sp_get_term_meta( $term_id, apply_filters( 'sp_tm_meta_key', SP_CUSTOM_FIELDS_PREFIX . $key, $term_id, $locale ) );
}


class SP_Term_Custom_Meta extends SP_Module {

	function __construct() {
		$this->dc = array(
			'sections' => array(),
		);
		$this->init( 'taxonomy-custom-fields' );
		global $wp_taxonomies;
		foreach( array_keys( $wp_taxonomies ) as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields' , array( $this, 'term_add_fields'  ), 10, 1 );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'term_edit_fields' ), 10, 2 );
		}
		add_action( 'created_term', array( $this, 'admin_save_term' ), 10, 3 );
		add_action( 'edited_term' , array( $this, 'admin_save_term' ), 10, 3 );
	}

	function term_add_fields( $taxonomy ) {
		foreach ( $this->c['sections'] as $section ) {
			if ( ! in_array( $taxonomy, (array) $section['taxonomy'] ) )
				continue;
			$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
			foreach ( $section['fields'] as $entry ) {
				global $_sp_cf_repeatable_field_types;
				$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cf_repeatable_field_types ) ) || ( 'group' == $entry['type'] );
				echo '<div class="form-field sp-tm-field-one sp-cf-one sp-cf-one-t-' . $entry['type'] . '">';
				echo '<label for="" class="sp-cf-one-name">' . $entry['title'] . '</label>';
				echo '<div class="sp-cf-one-field' . ( $multiple ? ' sp-cf-one-field-multiple' : '' ) . '">';
				$this->do_entry_html( $entry, 0, $taxonomy, $ml_section );
				echo '</div>';
				echo '<p class="sp-cf-one-desc">' . $entry['desc'] . '</p>';
				echo '</div>';
			}
		}
	}

	function term_edit_fields( $term, $taxonomy ) {
		foreach ( $this->c['sections'] as $section ) {
			if ( ! in_array( $taxonomy, (array) $section['taxonomy'] ) )
				continue;
			$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
			foreach ( $section['fields'] as $entry ) {
				global $_sp_cf_repeatable_field_types;
				$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cf_repeatable_field_types ) ) || ( 'group' == $entry['type'] );
				echo '<tr class="form-field sp-tm-field-one sp-cf-one sp-cf-one-t-' . $entry['type'] . '">';
				printf( '<th scope="row" valign="top"><label for="" class="sp-cf-one-name">%s</label></th><td>',
					apply_filters( 'sp_tm_one_name', $entry['title'], ( $ml_section && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );
				echo '<div class="sp-cf-one-field' . ( $multiple ? ' sp-cf-one-field-multiple' : '' ) . '">';
				$this->do_entry_html( $entry, $term->term_id, $taxonomy, $ml_section );
				echo '</div>';
				echo '<span class="description sp-cf-one-desc">' . $entry['desc'] . '</span></td>';
				echo '</tr>';
			}
		}
	}

	function do_entry_html( $entry, $term_id, $taxonomy, $ml_section ) {
		if ( sp_module_enabled( 'multilingual' ) && sp_is_taxonomy_ml( $taxonomy ) && $ml_section && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
			// multilingual is enabled & available
			foreach ( sp_get_enabled_languages_locales() as $locale_code ) {
				echo '<div class="sp-cf-one-field-content sp-cf-one-field-l sp-cf-one-field-l-' . esc_attr( $locale_code ) . '">';
				$this->do_entry_html_field( $entry, $term_id, $locale_code );
				echo '</div>';
			}
		} else {
			// not in multilingual
			echo '<div class="sp-cf-one-field-content">';
			$this->do_entry_html_field( $entry, $term_id );
			echo '</div>';
		}

	}

	function do_entry_html_field( $entry, $term_id, $locale_code = '' ) {
		$value = sp_tm( $term_id, $entry['id'], $locale_code );
		if ( false !== $value ) // a {false} will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_CUSTOM_FIELDS_PREFIX . $entry['id'] . ( ! empty( $locale_code ) ? SP_META_LANG_PREFIX . $locale_code : '' );
		new SP_Custom_Fields_Field ( $entry );
	}

	function admin_save_term( $term_id, $tt_id, $taxonomy ) {
		foreach ( $this->c['sections'] as $section ) {
			if ( ! in_array( $taxonomy, (array) $section['taxonomy'] ) )
				continue;
			$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
			foreach ( $section['fields'] as $entry ) {
				$meta_key = SP_CUSTOM_FIELDS_PREFIX . $entry['id'];
				if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] ) ) {
					// write datebase
					sp_update_term_meta( $term_id, $meta_key, $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] );
				}
				do_action( 'sp_tm_update_termmeta', $meta_key, $entry, $term_id, $ml_section );
			}
		}
	}

	function enqueue_assets_dashboard() {

		global $pagenow;
		if ( 'edit-tags.php' != $pagenow )
			return;

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

	}

}

add_action( 'admin_init', create_function( '', 'new SP_Term_Custom_Meta();' ) );


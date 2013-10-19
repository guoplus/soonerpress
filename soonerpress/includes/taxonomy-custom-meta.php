<?php
/**
 * Taxonomy Custom Meta module API
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Custom_Meta
 */


// get term meta stored by Taxonomy Custom Meta
function sp_tm( $term_id, $key, $lang_code = '' ) {
	$value = sp_get_term_meta( $term_id, apply_filters( 'sp_tm_meta_key', SP_CUSTOM_META_PREFIX . $key, $term_id, $lang_code ) );
	return $value;
}


class SP_Term_Custom_Meta extends SP_Module {

	function __construct() {
		$this->dc = array(
			'boxes' => array(),
		);
		$this->init( 'taxonomy-custom-meta' );
		global $wp_taxonomies;
		foreach( array_keys( $wp_taxonomies ) as $taxonomy ) {
			add_action( $taxonomy . '_add_form_fields' , array( $this, 'term_add_fields'  ), 10, 1 );
			add_action( $taxonomy . '_edit_form_fields', array( $this, 'term_edit_fields' ), 10, 2 );
		}
		add_action( 'created_term', array( $this, 'admin_save_term' ), 10, 3 );
		add_action( 'edited_term' , array( $this, 'admin_save_term' ), 10, 3 );
	}

	function term_add_fields( $taxonomy ) {
		foreach ( $this->c['boxes'] as $box ) {
			if ( ! in_array( $taxonomy, (array) $box['taxonomy'] ) )
				continue;
			$ml = isset( $box['ml'] ) ? $box['ml'] : true;
			foreach ( $box['fields'] as $entry ) {
				echo '<div class="form-field sp-tm-field-one sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';
				echo '<label for="" class="sp-cm-one-name">' . $entry['title'] . '</label>';
				if ( sp_module_enabled( 'multilingual' ) && $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
					// multilingual is enabled & available
					foreach ( sp_get_enabled_languages_ids() as $lang_code ) {
						echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $lang_code ) . '">';
						$this->do_entry_html_field( $entry, 0, $lang_code );
						echo '</div>';
					}
				} else {
					// not in multilingual
					echo '<div class="sp-cm-one-field-content">';
					$this->do_entry_html_field( $entry, 0 );
					echo '</div>';
				}
				echo '<p class="sp-cm-one-desc">' . $entry['desc'] . '</p>';
				echo '</div>';
			}
		}
	}

	function term_edit_fields( $term, $taxonomy ) {
		foreach ( $this->c['boxes'] as $box ) {
			if ( ! in_array( $taxonomy, (array) $box['taxonomy'] ) )
				continue;
			$ml = isset( $box['ml'] ) ? $box['ml'] : true;
			foreach ( $box['fields'] as $entry ) {
				echo '<tr class="form-field sp-tm-field-one sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';
				printf( '<th scope="row" valign="top"><label for="" class="sp-cm-one-name">%s</label></th><td>',
					apply_filters( 'sp_tm_one_name', $entry['title'], ( $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );
				if ( sp_module_enabled( 'multilingual' ) && $ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
					// multilingual is enabled & available
					foreach ( sp_get_enabled_languages_ids() as $lang_code ) {
						echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $lang_code ) . '">';
						$this->do_entry_html_field( $entry, $term->term_id, $lang_code );
						echo '</div>';
					}
				} else {
					// not in multilingual
					echo '<div class="sp-cm-one-field-content">';
					$this->do_entry_html_field( $entry, $term->term_id );
					echo '</div>';
				}
				echo '<span class="description sp-cm-one-desc">' . $entry['desc'] . '</span></td>';
				echo '</tr>';
			}
		}
	}

	function do_entry_html_field( $entry, $term_id, $lang_code = '' ) {
		$value = sp_tm( $term_id, $entry['id'], $lang_code );
		if ( false !== $value ) // a {false} will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_CUSTOM_META_PREFIX . $entry['id'] . ( ! empty( $lang_code ) ? SP_META_LANG_PREFIX . $lang_code : '' );
		new SP_CM_Field ( $entry );
	}


	function admin_save_term( $term_id, $tt_id, $taxonomy ) {
		foreach ( $this->c['boxes'] as $box ) {
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

	function enqueue_assets_dashboard() {

		global $pagenow;
		if ( 'edit-tags.php' != $pagenow )
			return;

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

	}

}

new SP_Term_Custom_Meta();


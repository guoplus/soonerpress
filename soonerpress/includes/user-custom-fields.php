<?php
/**
 * User Custom Fields module API
 *
 * @package SoonerPress
 * @subpackage User_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/** get user custom meta */
function sp_um( $user_id = 0, $key, $locale = '' ) {
	return get_user_meta( $user_id, apply_filters( 'sp_um_meta_key', SP_CUSTOM_FIELDS_PREFIX . $key, $user_id, $locale ), true );
}


class SP_User_Custom_Fields extends SP_Module {

	var $pm_column_current_type = '';

	function __construct() {
		$this->dc = array(
			'sections' => array(),
		);
		$this->init( 'user-custom-fields' );
		add_action( 'show_user_profile', array( $this, 'user_edit_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'user_edit_fields' ) );
		add_action( 'user_new_form'    , array( $this, 'user_edit_fields' ) );
		add_action( 'profile_update'   , array( $this, 'admin_save_user_meta' ) );
		add_action( 'user_register'    , array( $this, 'admin_save_user_meta' ) );
	}

	function user_edit_fields( $user ) {
		if ( 'add-new-user' == $user )
			$user_id = 0;
		else
			$user_id = $user->ID;
		foreach ( $this->c['sections'] as $section ) {
			$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
			echo '<div class="sp-um-section">';
			printf( '<h3 class="sp-um-section-title">%s</h3>', $section['title'] );
			echo '<table class="form-table">';
			foreach ( $section['fields'] as $entry ) {
				global $_sp_cf_repeatable_field_types;
				$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cf_repeatable_field_types ) ) || ( 'group' == $entry['type'] );
				echo '<tr class="sp-um-field-one sp-cf-one sp-cf-one-t-' . $entry['type'] . '">';
				printf( '<th scope="row"><label for="" class="sp-cf-one-name">%s</label></th><td>',
					apply_filters( 'sp_um_one_name', $entry['title'], ( $ml_section && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );
				echo '<div class="sp-cf-one-field' . ( $multiple ? ' sp-cf-one-field-multiple' : '' ) . '">';
				$this->do_entry_html( $entry, $user_id, $ml_section );
				echo '</div>';
				echo '<span class="description sp-cf-one-desc">' . $entry['desc'] . '</span></td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '</div>';
		}
	}

	function do_entry_html( $entry, $user_id, $ml_section ) {
		if ( sp_module_enabled( 'multilingual' ) && $ml_section && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
			// multilingual is enabled & available
			foreach ( sp_get_enabled_languages_locales() as $locale_code ) {
				echo '<div class="sp-cf-one-field-content sp-cf-one-field-l sp-cf-one-field-l-' . esc_attr( $locale_code ) . '">';
				$this->do_entry_html_field( $entry, $user_id, $locale_code );
				echo '</div>';
			}
		} else {
			// not in multilingual
			echo '<div class="sp-cf-one-field-content">';
			$this->do_entry_html_field( $entry, $user_id );
			echo '</div>';
		}
	}

	function do_entry_html_field( $entry, $user_id, $locale_code = '' ) {
		$value = sp_um( $user_id, $entry['id'], $locale_code );
		if ( false !== $value ) // a {false} will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_CUSTOM_FIELDS_PREFIX . $entry['id'] . ( ! empty( $locale_code ) ? SP_META_LANG_PREFIX . $locale_code : '' );
		new SP_Custom_Fields_Field ( $entry );
	}

	function admin_save_user_meta( $user_id ) {
		foreach ( $this->c['sections'] as $section ) {
			$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
			foreach ( $section['fields'] as $entry ) {
				$meta_key = SP_CUSTOM_FIELDS_PREFIX . $entry['id'];
				if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] ) ) {
					// write datebase
					update_user_meta( $user_id, $meta_key, $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] );
				}
				do_action( 'sp_um_update_usermeta', $meta_key, $entry, $user_id, $ml_section );
			}
		}
	}

	function enqueue_assets_dashboard() {

		global $pagenow;
		if ( 'profile.php' != $pagenow && 'user-new.php' != $pagenow && 'user-edit.php' != $pagenow )
			return;

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

	}

}

new SP_User_Custom_Fields();


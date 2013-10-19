<?php
/**
 * Core module API for custom meta
 *
 * @package SoonerPress
 * @subpackage Core
 */


$_sp_cm_repeatable_field_types = array( 'text', 'email', 'password', 'textarea', 'file', 'image',
	'colorpicker', 'datepicker' );


class SP_CM_Field {

	public function __construct( $options = array() ) {
		// init passed variables
		$options = wp_parse_args( $options, array(
			'id' => null, 'type' => 'text', 'multiple' => false, 'extra' => array(),
			'value' => isset( $options['std'] ) ? $options['std'] : null, 'std' => null,
			'placeholder' => null, 'choices' => array(),
			'query_vars' => array( 'post_type' => 'page', 'nopaging' => true ),
			'get_terms_args' => array(), 'field_type' => null,
		) );
		// field type supported
		if ( is_callable ( array( $this, '_field_html_' . (string) $options['type'] ) ) ) {
			// HTML output
			global $_sp_cm_repeatable_field_types;
			if ( ! $options['multiple'] ) {
				// not multiple
				call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
					'id' => $options['id'], 'value' => $options['value'], 'extra' => $options, ) );
			} else if ( in_array( $options['type'], $_sp_cm_repeatable_field_types ) ) {
				// multiple field
				if ( is_array( $options['value'] ) && sizeof( $options['value'] ) )
					foreach ( $options['value'] as $v ) {
						echo '<div class="sp-cm-multi-one">';
						call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
							'id' => $options['id'] . '[]', 'value' => $v, 'extra' => $options, ) );
						echo '</div>';
					}
				echo '<div class="sp-cm-multi-one-def">';
				call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
					'id' => $options['id'] . '[]', 'value' => $options['std'], 'extra' => $options, ) );
				echo '</div>';
			} else {
				// multiple not supported
				_e( 'This field cannot be cloned.', 'sp' );
			}
		} else {
			// field type not supported
			_e( 'Unknown field type.', 'sp' );
		}
	}

	private function _field_html_text( $options ) {
		printf ( '<input type="text" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_email( $options ) {
		printf ( '<input type="email" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_password( $options ) {
		printf ( '<input type="password" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_textarea( $options ) {
		printf ( '<textarea name="%s" placeholder="%s">%s</textarea>',
			esc_attr( $options['id'] ), esc_attr( $options['extra']['placeholder'] ), esc_textarea( $options['value'] ) );
	}

	private function _field_html_wysiwyg( $options ) {
		wp_editor( $options['value'], $options['id'],
			array( 'textarea_name' => $options['id'], 'editor_height' => 240, 'dfw' => true ) );
	}

	private function _field_html_datepicker( $options ) {
		printf ( '<input type="text" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_timepicker( $options ) {
		printf ( '<input type="text" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_datetimepicker( $options ) {
		printf ( '<input type="text" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_colorpicker( $options ) {
		printf ( '<input type="text" name="%s" value="%s" placeholder="%s" />',
			esc_attr( $options['id'] ), esc_attr( $options['value'] ), esc_attr( $options['extra']['placeholder'] ) );
	}

	private function _field_html_colorselector( $options ) {
		echo '<div class="sp-colorselector">';
		foreach ( $options['extra']['choices'] as $o_value => $o_name ) {
			if ( is_int( $o_value ) ) { $o_title = ''; $o_value = $o_name; }
			else $o_title = $o_name;
			printf( '<label><input type="radio" name="%s" value="%s"%s /> <span class="sp-colorselector-preview" style="background-color: %s;"></span>%s</label><br />',
				esc_attr( $options['id'] ), esc_attr( $o_value ), ( $o_value == $options['value'] ) ? ' checked="checked"' : '', esc_attr( $o_value ), esc_html( $o_title ) );
		}
		echo '</div>';
	}

	private function _field_html_select( $options ) {
		printf( '<select name="%s">', esc_attr( $options['id'] ) );
		foreach ( $options['extra']['choices'] as $o_value => $o_name )
			printf( '<option value="%s"%s>%s</option>',
				esc_attr( $o_value ), ( $o_value == $options['value'] ) ? ' selected="selected"' : '', esc_html( $o_name ) );
		echo '</select>';
	}

	private function _field_html_selectmulti( $options ) {
		printf( '<select name="%s[]" multiple="multiple" size="7">', esc_attr( $options['id'] ) );
		foreach ( $options['extra']['choices'] as $o_value => $o_name )
			printf( '<option value="%s"%s>%s</option>',
				esc_attr( $o_value ), in_array( $o_value, (array) $options['value'] ) ? ' selected="selected"' : '', esc_html( $o_name ) );
		echo '</select>';
	}

	private function _field_html_checkbox( $options ) {
		foreach ( $options['extra']['choices'] as $o_value => $o_name )
			printf( '<label><input type="checkbox" name="%s[]" value="%s"%s /> %s</label><br />',
				esc_attr( $options['id'] ), esc_attr( $o_value ), in_array( $o_value, (array) $options['value'] ) ? ' checked="checked"' : '', esc_html( $o_name ) );
	}

	private function _field_html_radio( $options ) {
		foreach ( $options['extra']['choices'] as $o_value => $o_name )
			printf( '<label><input type="radio" name="%s" value="%s"%s /> %s</label><br />',
				esc_attr( $options['id'] ), esc_attr( $o_value ), ( $o_value == $options['value'] ) ? ' checked="checked"' : '', esc_html( $o_name ) );
	}

	private function _field_html_posts( $options ) {
		$wp_query_tmp = new WP_Query( $options['extra']['query_vars'] );
		if ( $wp_query_tmp->post_count >= 1 ) {
			$_posts = array();
			foreach ( $wp_query_tmp->posts as $k => $_post )
				$_posts[$_post->ID] = get_the_title( $_post->ID );
			if ( is_callable ( array( $this, '_field_html_' . (string) $options['extra']['field_type'] ) ) )
				call_user_func ( array( $this, '_field_html_' . $options['extra']['field_type'] ), array(
					'id' => $options['id'], 'value' => $options['value'], 'extra' => array( 'choices' => $_posts ) ) );
		}
	}

	private function _field_html_taxonomy( $options ) {
		$_terms_tmp = get_terms( (array) $options['extra']['taxonomy'], $options['extra']['get_terms_args'] );
		if ( sizeof( $_terms_tmp ) ) {
			$_terms = array();
			foreach ( $_terms_tmp as $k => $_term )
				$_terms[$_term->term_id] = $_term->name;
			if ( is_callable ( array( $this, '_field_html_' . (string) $options['extra']['field_type'] ) ) )
				call_user_func ( array( $this, '_field_html_' . $options['extra']['field_type'] ), array(
					'id' => $options['id'], 'value' => $options['value'], 'extra' => array( 'choices' => $_terms ) ) );
		}
	}

	private function _field_html_file( $options ) {
		$url = wp_get_attachment_url( $options['value'] );
		printf ( '<div class="sp-media-editor-field%s">', intval( $options['value'] ) > 0 ? ' selected' : ' notselected' );
		printf ( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
		printf ( '<span class="sp-media-editor-filename">%s</span>', esc_html( basename( $url ) ) );
		printf ( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', esc_attr( $options['id'] ), esc_attr( $options['value'] ) );
		printf ( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select File', 'sp' ) );
		printf ( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
		echo '</div>';
	}

	private function _field_html_image( $options ) {
		$url = wp_get_attachment_url( $options['value'] );
		printf ( '<div class="sp-media-editor-field%s">', intval( $options['value'] ) > 0 ? ' selected' : ' notselected' );
		printf ( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', esc_attr( $url ) );
		printf ( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
		printf ( '<span class="sp-media-editor-filename">%s</span>', esc_html( basename( $url ) ) );
		printf ( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', esc_attr( $options['id'] ), esc_attr( $options['value'] ) );
		printf ( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select File', 'sp' ) );
		printf ( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
		echo '</div>';
	}

}



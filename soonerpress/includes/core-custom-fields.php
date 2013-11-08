<?php
/**
 * Core module API for custom meta
 *
 * @package SoonerPress
 * @subpackage Core
 */

if ( ! defined( 'IN_SP' ) ) exit;


$_sp_cf_repeatable_field_types = array( 'text', 'email', 'password', 'textarea', 'file', 'image',
	'colorpicker', 'datepicker', 'group' );


class SP_Custom_Fields_Field {

	public function __construct( $options = array() ) {
		// init passed variables
		$options = wp_parse_args( $options, array(
			'id' => null, 'type' => 'text', 'multiple' => false, 'extra' => array(),
			'value' => isset( $options['std'] ) ? $options['std'] : null, 'std' => null,
			'placeholder' => null, 'choices' => array(),
			'query_vars' => array( 'post_type' => 'page', 'nopaging' => true ),
			'get_terms_args' => array(), 'field_type' => null,
			'expanded_default' => false, 'row_name_refer_to' => null,
		) );
		// field type supported
		if ( is_callable ( array( $this, '_field_html_' . (string) $options['type'] ) ) ) {
			// HTML output
			global $_sp_cf_repeatable_field_types;
			if ( ! $options['multiple'] && 'group' != $options['type'] ) {
				// not multiple
				call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
					'id' => $options['id'], 'value' => $options['value'], 'extra' => $options, ) );
			} else if ( in_array( $options['type'], $_sp_cf_repeatable_field_types ) ) {
				// multiple field
				if ( is_array( $options['value'] ) && sizeof( $options['value'] ) )
					foreach ( (array) $options['value'] as $k => $v ) {
						echo '<div class="sp-cf-multi-one">';
						call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
							'id' => $options['id'] . ('group'==$options['type']?'['.$k.']':'[]'), 'value' => $v, 'extra' => $options, ) );
						echo '</div>';
					}
				echo '<div class="sp-cf-multi-one-def">';
				call_user_func ( array( $this, '_field_html_' . $options['type'] ), array(
					'id' => $options['id'] . ('group'==$options['type']?'[SP_SERIAL_ID]':'[]'), 'value' => $options['std'], 'extra' => $options, ) );
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

	private function _field_html_group( $options ) {
		printf( '<div class="sp-cf-nest-group-title" data-expanded_default="%s" data-row_name_refer_to="%s">',
			( $options['extra']['expanded_default'] ? '1' : '0' ), esc_attr( $options['extra']['row_name_refer_to'] ) );
		echo $options['extra']['row_title'];
		echo '</div>';
		echo '<div class="sp-cf-nest-group-content">';
		foreach ( $options['extra']['fields'] as $field ) {
			echo '<div class="sp-cf-nest-field sp-cf-nest-field-' . $field['type'] . ( isset( $field['multiple'] ) && $field['multiple'] ? ' sp-cf-nest-field-multiple' : null ) . '">';
			printf( '<div class="sp-cf-nest-title">%s</div>', $field['title'] );
			$field_id_old = $field['id'];
			$field['value'] = isset( $options['value'][$field_id_old] ) ? $options['value'][$field_id_old] : null;
			$field['id'] = $options['id'] . '[' . $field_id_old . ']';
			new SP_Custom_Fields_Field ( $field );
			printf( '<div class="sp-cf-nest-description">%s</div>', $field['desc'] );
			echo '</div>';
		}
		echo '</div>';
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

	private function _field_html_radio_icon( $options ) {
		foreach ( $options['extra']['choices'] as $o_value => $o_name )
			printf( '<span class="sp_radio_icon_choice"><label><input type="radio" name="%s" value="%s"%s /><img src="%s" title="%s" /><span class="sp_radio_icon_choice_title">%s</span></label></span>',
				esc_attr( $options['id'] ), esc_attr( $o_value ), ( $o_value == $options['value'] ) ? ' checked="checked"' : '', esc_attr( $o_name[0] ), esc_attr( $o_name[1] ), esc_html( $o_name[1] ) );
	}

	private function _field_html_on_off( $options ) {
		printf( '<span class="sp_on_off_choice"><label><input type="radio" name="%s" value="%s"%s /><span class="sp_on_off_choice_icon sp_on_off_choice_icon_off" title="%s"></span></label></span>',
			esc_attr( $options['id'] ), 0, ( 0 == $options['value'] ) ? ' checked="checked"' : '', esc_attr( __( 'On', 'sp' ) ) );
		printf( '<span class="sp_on_off_choice"><label><input type="radio" name="%s" value="%s"%s /><span class="sp_on_off_choice_icon" title="%s"></span></label></span>',
			esc_attr( $options['id'] ), 1, ( 1 == $options['value'] ) ? ' checked="checked"' : '', esc_attr( __( 'Off', 'sp' ) ) );
	}

	private function _field_html_post( $options ) {
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

	private function _field_html_font( $options ) {
		if ( is_callable ( array( $this, '_field_html_' . (string) $options['extra']['field_type'] ) ) )
			call_user_func ( array( $this, '_field_html_' . $options['extra']['field_type'] ), array(
				'id' => $options['id'], 'value' => $options['value'], 'extra' => array( 'choices' => $options['extra']['choices'] ) ) );
		printf( '<div class="sp_font_selector_preview" style="font-family: %s;">%s</div>', esc_attr( $options['value'] ), __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 'sp' ) );
	}

	private function _field_html_google_maps( $options ) {
		echo '<div class="sp-cf-field-google-maps">';
		printf ( '<textarea name="%s[address]" placeholder="%s" class="sp-cf-field-google-maps-address">%s</textarea>',
			esc_attr( $options['id'] ), esc_attr( $options['extra']['placeholder'] ), esc_textarea( $options['value']['address'] ) );
		printf ( '<input name="%s[lat]" value="%s" type="hidden" class="sp-cf-field-google-maps-lat" />',
			esc_attr( $options['id'] ), esc_attr( $options['value']['lat'] ) );
		printf ( '<input name="%s[lng]" value="%s" type="hidden" class="sp-cf-field-google-maps-lng" />',
			esc_attr( $options['id'] ), esc_attr( $options['value']['lng'] ) );
		echo '</div>';
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


$_sp_cm_ajax_nonce = wp_create_nonce( 'sp-cm-ajax-nonce' );

function _sp_cm_google_maps_retrive() {
	if ( isset( $_REQUEST['address'] ) && isset( $_REQUEST['sp_cm_ajax_nonce'] ) ) {
		if ( ! wp_verify_nonce( $_REQUEST['sp_cm_ajax_nonce'], 'sp-cm-ajax-nonce' ) )
			wp_die( __( 'Cheatin&#8217; uh?' ) );
		exit( file_get_contents( 'http://maps.google.com/maps/api/geocode/json?address=' . urlencode( $_REQUEST['address'] ) . '&sensor=false' ) );
	}
}
add_action( 'wp_ajax_sp_google_maps_retrive', '_sp_cm_google_maps_retrive' );


function _sp_core_cm_enqueue_assets_dashboard() {

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'fontawesome-ie7' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_media();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_style( 'sp.jqueryui-datepicker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'jquery-ui-timepicker-addon' );
	wp_enqueue_script( 'jquery-ui-timepicker-addon' );
	wp_enqueue_style( 'sp.core.custom-fields.dashboard', SP_INC_URI . '/core/sp.core.custom-fields.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.core.custom-fields.dashboard', SP_INC_URI . '/core/sp.core.custom-fields.dashboard.js', array( 'jquery' ), false, true );

	global $_sp_cm_ajax_nonce;
	wp_localize_script( 'sp.core.custom-fields.dashboard', 'sp_core_cm', array(
		'l10n' => array(
			'add_new'         => __( 'Add new', 'sp' ),
			'delete'          => __( 'Delete', 'sp' ),
			'delete_all'      => __( 'Delete All', 'sp' ),
			'toggle'          => __( 'Toggle', 'sp' ),
			'toggle_all'      => __( 'Toggle All', 'sp' ),
			'collapse_all'    => __( 'Collapse All', 'sp' ),
			'expand_all'      => __( 'Expand All', 'sp' ),
			'click_to_toggle' => __( 'Click to toggle', 'sp' ),
		),
		'sp_cm_ajax_nonce' => $_sp_cm_ajax_nonce,
	) );

}
add_action( 'admin_enqueue_scripts', '_sp_core_cm_enqueue_assets_dashboard' );


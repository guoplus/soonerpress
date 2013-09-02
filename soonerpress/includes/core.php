<?php


if( defined( 'SP_DEBUG_MODE' ) && SP_DEBUG_MODE ) :
	error_reporting( E_ALL | E_STRICT );
endif;

/** get option value from database */
function sp_option( $key, $lang = '' ) {
	global $sp_config;
	$result = get_option( SP_OPTIONS_PREFIX . $key ); // get option value from database
	$result = apply_filters( 'sp_option', $result, $lang );
	return $result;
}

/** serialize an array to string */
function sp_serialize( $value ) {
	// return json_encode( $value, JSON_UNESCAPED_UNICODE );
	return serialize( $value );
}

/** unserialize a string to array */
function sp_unserialize( $value ) {
	return unserialize( $value );
}

/** HTML head title output, using wp_title parsed args */
function sp_title( $sep = '&laquo;', $display = false, $seplocation = 'right' ) {
	return wp_title( $sep, $display, $seplocation );
}

/** register default scripts and stylesheets */
function _sp_default_scripts() {
	wp_register_script( 'jquery.migrate', SP_JS . '/jquery.migrate.min.js', array( 'jquery' ), '1.2.1', true );
	wp_register_script( 'jquery.json', SP_JS . '/jquery.json.min.js', array( 'jquery' ), '2.4', true );
	wp_register_script( 'jquery.cookie', SP_JS . '/jquery.cookie.min.js', array( 'jquery' ), '1.3.1', true );
	wp_register_script( 'jquery.placeholder', SP_JS . '/jquery.placeholder.min.js', array( 'jquery' ), '2.0.7', true );
}
function _sp_default_styles() {
	wp_register_style( 'sp.jqueryui-datepicker', SP_PLUGINS . '/jqueryui/themes/smoothness/jquery-ui-datepicker.min.css', array(), false, 'all' );
}
add_action( 'init', '_sp_default_scripts' );
add_action( 'init', '_sp_default_styles' );

function sp_enqueue_bootstrap_js() {
	wp_enqueue_script( 'bootstrap', SP_PLUGINS . '/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.3.1', false );
}

function sp_enqueue_bootstrap_css() {
	wp_enqueue_style( 'bootstrap', SP_PLUGINS . '/bootstrap/css/bootstrap.min.css', array(), '2.3.1', 'screen' );
	wp_enqueue_style( 'bootstrap-responsive', SP_PLUGINS . '/bootstrap/css/bootstrap-responsive.min.css', array(), '2.3.1', 'screen' );
}

function sp_enqueue_fontawesome() {
	wp_enqueue_style( 'fontawesome', SP_PLUGINS . '/fontawesome/css/font-awesome.min.css', array(), '3.0.2', 'all' );
	wp_enqueue_style( 'fontawesome-ie7', SP_PLUGINS . '/fontawesome/css/font-awesome-ie7.min.css', array(), '3.0.2', 'all' );
	global $wp_styles;
	$wp_styles->add_data( 'fontawesome-ie7', 'conditional', 'IE 7' );
}

function sp_enqueue_jquery_own() {
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', SP_JS . '/jquery.min.js', array(), '1.10.2', false );
}

function sp_icon_src( $name ) {
	return sprintf( '<img class="sp-icon-img" src="%s" alt="%s" align="absmiddle" />',
		esc_attr( SP_IMAGES . '/icons/' . $name . '.png' ),
		esc_attr( $name . ' icon' ) );
}

function sp_icon_font( $name ) {
	return sprintf( '<i class="icon-%s"></i>', $name );
}

/** check if a module is enabled */
function sp_enabled_module( $module ) {
	global $_enabled_modules;
	return in_array( $module, $_enabled_modules );
}

// additional core functions
$sp_modules_additional = array( 'for-developers', 'adjacent-post-link' );
foreach ( $sp_modules_additional as $m ) {
	if ( file_exists( SP_INCLUDES . '/core-' . $m . '.php' ) ) {
		require_once( SP_INCLUDES . '/core-' . $m . '.php' );
	}
}

function _sp_core_enqueue_assets_backend() {

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'editor' );
	wp_enqueue_style( 'sp.jqueryui-datepicker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'sp.core', SP_INCLUDES_URI . '/core/sp.core.back-end.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.core', SP_INCLUDES_URI . '/core/sp.core.back-end.js', array( 'jquery' ), false, true );

	wp_localize_script( 'sp.core', 'sp_core_text', array(
		'add_new' => __( 'Add new', 'sp' ),
		'delete' => __( 'Delete', 'sp' ),
	) );

}
add_action( 'admin_enqueue_scripts', '_sp_core_enqueue_assets_backend' );


// framework private library functions

$_sp_custom_meta_cloneable_field_types = array( 'text', 'email', 'password', 'textarea', 'file', 'image',
	'colorpicker', 'datepicker' );

/** walk custom meta entry field HTML output */
function __sp_custom_meta_do_entry_html_field( $id, $type, $is_multiple, $value, $std, $options = array() ) {
	extract( $options );
	$is_nested = isset( $is_nested ) ? $is_nested : false;
	if( isset( $nest_name ) )
		printf( '<span class="sp-cm-multi-one-nested-name">%s</span>', $nest_name );
	if( $is_nested )
		echo '<div class="sp-cm-one-field-nest-multiple">';
	$_multi_one_before     = '<div class="sp-cm-multi-one">';
	$_multi_one_after      = '</div>';
	$_multi_one_def_before = '<div class="sp-cm-multi-one-def">';
	$_multi_one_def_after  = '</div>';
	switch( $type ) {
		case 'text':
		case 'datepicker':
		case 'colorpicker':
			if ( ! $is_multiple ) {
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( $_multi_one_before.'<input type="text" name="%s[]" value="%s" />'.$_multi_one_after, $id, esc_attr( $v ) );
				printf( $_multi_one_def_before.'<input type="text" name="%s[]" value="%s" />'.$_multi_one_def_after, $id, esc_attr( $std ) );
			}
		break;
		case 'email':
			if ( ! $is_multiple ) {
				printf( '<input type="email" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( $_multi_one_before.'<input type="email" name="%s[]" value="%s" />'.$_multi_one_after, $id, esc_attr( $v ) );
				printf( $_multi_one_def_before.'<input type="email" name="%s[]" value="%s" />'.$_multi_one_def_after, $id, esc_attr( $std ) );
			}
		break;
		case 'password':
			if ( ! $is_multiple ) {
				printf( '<input type="password" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( $_multi_one_before.'<input type="password" name="%s[]" value="%s" />'.$_multi_one_after, $id, esc_attr( $v ) );
				printf( $_multi_one_def_before.'<input type="password" name="%s[]" value="%s" />'.$_multi_one_def_after, $id, esc_attr( $std ) );
			}
		break;
		case 'colorselector':
			echo '<div class="sp-colorselector">';
			foreach ( $choices as $o_value => $o_name ) {
				if ( is_int( $o_value ) ) { $o_title = ''; $o_value = $o_name; }
				else $o_title = $o_name;
				printf( '<label><input type="radio" name="%s" value="%s"%s /> <span class="sp-colorselector-preview" style="background-color: %s;"></span>%s</label><br />',
					$id, $o_value, ( $o_value == $value ) ? ' checked="checked"' : '', $o_value, $o_title );
			}
			echo '</div>';
		break;
		case 'textarea':
			if ( ! $is_multiple ) {
				printf( '<textarea name="%s">%s</textarea>', $id, esc_textarea( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( $_multi_one_before.'<textarea name="%s[]">%s</textarea>'.$_multi_one_after, $id, esc_textarea( $v ) );
				printf( $_multi_one_def_before.'<textarea name="%s[]">%s</textarea>'.$_multi_one_def_after, $id, esc_textarea( $std ) );
			}
		break;
		case 'wysiwyg':
			wp_editor( $value, $id, array( 'textarea_name' => $id, 'editor_height' => 240, 'dfw' => true ) );
		break;
		case 'file':
			if ( ! $is_multiple ) {
				$url = wp_get_attachment_url( $value );
				echo '<div class="sp-media-editor-field' . ( 0 != intval( $value ) ? ' selected' : ' notselected' ) . '">';
				printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
				printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
				printf( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $value ) );
				printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select File', 'sp' ) );
				printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
				echo '</div>';
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v ) {
						if ( 0 != intval( $v ) ) {
							echo $_multi_one_before;
								$url = wp_get_attachment_url( $v );
								echo '<div class="sp-media-editor-field selected">';
								printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
								printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
								printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $v ) );
								printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select File', 'sp' ) );
								printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
								echo '</div>';
							echo $_multi_one_after;
						}
					}
				echo $_multi_one_def_before;
					echo '<div class="sp-media-editor-field notselected">';
					printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
					printf( '<span class="sp-media-editor-filename">%s</span>', '' );
					printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, '0' );
					printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select File', 'sp' ) );
					printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
					echo '</div>';
				echo $_multi_one_def_after;
			}
		break;
		case 'image':
			if ( ! $is_multiple ) {
				$url = wp_get_attachment_url( $value );
				echo '<div class="sp-media-editor-field' . ( 0 != intval( $value ) ? ' selected' : ' notselected' ) . '">';
				printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', esc_attr( $url ) );
				printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
				printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
				printf( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $value ) );
				printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select Image', 'sp' ) );
				printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
				echo '</div>';
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v ) {
						if ( 0 != intval( $v ) ) {
							echo $_multi_one_before;
								$url = wp_get_attachment_url( $v );
								echo '<div class="sp-media-editor-field selected">';
								printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', esc_attr( $url ) );
								printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
								printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
								printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $v ) );
								printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select Image', 'sp' ) );
								printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
								echo '</div>';
							echo $_multi_one_after;
						}
					}
				echo $_multi_one_def_before;
					echo '<div class="sp-media-editor-field notselected">';
					printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', '' );
					printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
					printf( '<span class="sp-media-editor-filename">%s</span>', '' );
					printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, '0' );
					printf( '<a href="#" class="button sp-btn-media-addnew">%s</a>', __( 'Select Image', 'sp' ) );
					printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
					echo '</div>';
				echo $_multi_one_def_after;
			}
		break;
		case 'select':
			printf( '<select name="%s">', $id );
			foreach ( $choices as $o_value => $o_name )
				printf( '<option value="%s"%s>%s</option>',
					$o_value, ( $o_value == $value ) ? ' selected="selected"' : '', $o_name );
			echo '</select>';
		break;
		case 'select_multi':
			printf( '<select name="%s[]" multiple="multiple" size="7">', $id );
			foreach ( $choices as $o_value => $o_name )
				printf( '<option value="%s"%s>%s</option>',
					$o_value, in_array( $o_value, (array) $value ) ? ' selected="selected"' : '', $o_name );
			echo '</select>';
		break;
		case 'checkbox':
			foreach ( $choices as $o_value => $o_name )
				printf( '<label><input type="checkbox" name="%s" value="%s"%s /> %s</label><br />',
					$id, $o_value, ( $o_value == $value ) ? ' checked="checked"' : '', $o_name );
		break;
		case 'radio':
			foreach ( $choices as $o_value => $o_name )
				printf( '<label><input type="radio" name="%s" value="%s"%s /> %s</label><br />',
					$id, $o_value, ( $o_value == $value ) ? ' checked="checked"' : '', $o_name );
		break;
		case 'pages':
			printf( '<select name="%s">', $id );
			$pages_tmp = get_posts( array( 'post_type' => 'page', 'nopaging' => true ) );
			foreach ( $pages_tmp as $p )
				printf( '<option value="%s"%s>%s</option>',
					$p->ID, ( $p->ID == $value ) ? ' selected="selected"' : '', esc_html( get_the_title( $p->ID ) ) );
			echo '</select>';
		break;
		// case 'group':
		// 	// ==================== multiple group ====================
		// 	// somebody dead.
		// 	break;
		default:
			_e( 'Unknown field type.', 'sp' );
	}
	if( $is_nested )
		echo '</div>';
}


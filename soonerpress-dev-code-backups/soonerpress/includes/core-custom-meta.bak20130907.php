<?php


$_sp_cm_repeatable_field_types = array( 'text', 'email', 'password', 'textarea', 'file', 'image',
	'colorpicker', 'datepicker' );

/** walk custom meta entry field HTML output */
function __sp_cm_do_entry_html_field( $id, $type, $is_multiple, $value, $std, $options = array() ) {
	extract( $options );
	$is_nested = isset( $is_nested ) ? $is_nested : false;
	if( isset( $nest_name ) )
		printf( '<span class="sp-cm-multi-one-nested-name">%s</span>', $nest_name );
	if( $is_nested )
		echo '<div class="sp-cm-one-field-nest-multiple"><div class="sp-cm-one-field-nest-multiple-content">';
	$_multi_one_before     = '<div class="sp-cm-multi-one">';
	$_multi_one_after      = '</div>';
	$_multi_one_def_before = '<div class="sp-cm-multi-one-def">';
	$_multi_one_def_after  = '</div>';
	switch( $type ) {
		case 'text':
		case 'colorpicker':
		case 'datepicker':
		case 'timepicker':
		case 'datetimepicker':
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
		echo '</div></div>';
}


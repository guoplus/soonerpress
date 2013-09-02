<?php


$sp_options_ignore_types = array( 'title', 'info' );
$sp_options_cloneable_field_types = array( 'text', 'textarea', 'file', 'image', 'select' );

/** add to admin menu */
function sp_options_add_page() {
	global $sp_config;
	add_menu_page( __( 'Options Panel', 'sp' ), __( 'Options Panel', 'sp' ), 'manage_options', 'options_panel', 'sp_options_do_html', false, 3 );
	foreach ( $sp_config['options']['tabs'] as $k => $option_tab )
		add_submenu_page( 'options_panel', $option_tab['title'], $option_tab['title'], 'manage_options', 'options_panel'.'&tab='.$k, create_function( '$a', 'return null;' ) );
}
add_action( 'admin_menu', 'sp_options_add_page' );

/** register setting field to WordPress */
function sp_options_init() {
	global $sp_config, $sp_options_ignore_types;
	foreach ( $sp_config['options']['tabs'] as $option_tab ) {
		foreach ( $option_tab['fields'] as $option ) {
			if( in_array( $option['type'], $sp_options_ignore_types ) )
				continue;
			register_setting( 'sp_options_panel', SP_OPTIONS_PREFIX . $option['id'], 'sp_options_validate' );
		}
	}
}
add_action( 'admin_init', 'sp_options_init' );

/** options data submission validation */
function sp_options_validate( $value ) {
	return $value;
}

/** options panel HTML output */
function sp_options_do_html() {
	$settings_updated = ( ! isset( $_GET['settings-updated'] ) ) ? false : true;
	global $sp_config;
	?>
	<div class="wrap sp-wrap sp-options-panel">
		<div id="icon-index" class="icon32"><br></div>
		<h2><?php echo wp_get_theme() . ' ' . __( 'Options Panel', 'sp' ); ?></h2>
		<?php if( $settings_updated ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved.', 'sp' ); ?></strong></p></div>
		<?php endif; ?>
		<?php if( isset( $sp_config['options']['before_form'] ) ) echo $sp_config['options']['before_form']; ?>
		<form method="post" action="options.php" id="sp-options-panel-form">
			<?php settings_fields( 'sp_options_panel' ); ?>
			<div id="sp-options-panel-wrap">
				<?php if( isset( $sp_config['options']['show_header'] ) && $sp_config['options']['show_header'] ) : ?>
				<div id="sp-options-panel-header">
					<?php do_action( 'sp_op_header' ); ?>
					<div id="sp-options-panel-header-ctrl">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'sp' ); ?>" />
						<input type="reset" class="button" value="<?php _e( 'Reset All', 'sp' ); ?>" />
					</div>
					<div class="clearfix"></div>
				</div><!-- #sp-options-panel-header -->
				<div class="clearfix"></div>
				<?php endif; ?>
				<div id="sp-options-panel-tabs">
					<ul>
						<?php foreach ( $sp_config['options']['tabs'] as $option_tab ) : ?>
						<li><a href="#"><?php if( isset( $option_tab['icon'] ) ) : ?><span class="sp-op-tab-icon"><?php echo $option_tab['icon']; ?></span><?php endif; ?><?php echo esc_html( $option_tab['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div><!-- #sp-options-panel-tabs -->
				<div id="sp-options-panel-boxes">
					<ul>
						<?php foreach ( $sp_config['options']['tabs'] as $k => $option_tab ) : ?>
						<li id="sp-options-tab-<?php echo $k; ?>" class="sp-options-tab">
							<table><tbody>
							<?php foreach ( $option_tab['fields'] as $f ) : ?>
							<?php sp_options_do_entry_html( $f ); ?>
							<?php endforeach; ?>
							</tbody></table>
						</li>
						<?php endforeach; ?>
					</ul>
				</div><!-- #sp-options-panel-boxes -->
				<div class="clearfix"></div>
				<?php if( isset( $sp_config['options']['show_footer'] ) && $sp_config['options']['show_footer'] ) : ?>
				<div id="sp-options-panel-footer">
					<?php do_action( 'sp_op_footer' ); ?>
					<div id="sp-options-panel-footer-ctrl">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'sp' ); ?>" />
						<input type="reset" class="button" value="<?php _e( 'Reset All', 'sp' ); ?>" />
					</div>
					<div class="clearfix"></div>
				</div><!-- #sp-options-panel-footer -->
				<?php endif; ?>
			</div><!-- #sp-options-panel-wrap -->
		</form>
		<?php if( isset( $sp_config['options']['after_form'] ) ) echo $sp_config['options']['after_form']; ?>
	</div>
	<?php
}

/** options panel entry HTML output */
function sp_options_do_entry_html( $entry ) {
	global $sp_config, $sp_options_ignore_types, $sp_options_cloneable_field_types;
	echo '<tr valign="top" class="sp-op-one sp-op-one-t-' . $entry['type'] . '">';
	if( ! in_array( $entry['type'], $sp_options_ignore_types ) ) {
		printf( '<th scope="row" class="sp-op-one-name">%s</th>', apply_filters( 'sp_op_one_name', $entry['title'] ) );
	}
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $sp_options_cloneable_field_types );
	echo '<td class="sp-op-one-field' . ( $multiple ? ' sp-op-one-field-multiple' : '' ) . '"' .
		( in_array( $entry['type'], $sp_options_ignore_types ) ? ' colspan="2"' : '' ) . '>';
	switch( $entry['type'] ) {
		case 'title':
			printf( '<h3>%s</h3>', esc_html( $entry['title'] ) );
			break;
		case 'info':
			printf( '<p>%s</p>', esc_html( $entry['title'] ) );
			break;
		default:
			do_action( 'sp_op_before_entry_field' );
			if( ! sp_in_ml() ) {
				sp_options_do_entry_html_field( $entry );
			} else {
				foreach ( $sp_config['languages']['enabled'] as $l ) {
					echo '<div class="sp-op-one-field-l sp-op-one-field-l-' . esc_attr( $l ) . '">';
					sp_options_do_entry_html_field( $entry, $l );
					echo '</div>';
				}
				echo '<input name="' . SP_OPTIONS_PREFIX . $entry['id'] . '[ml]" type="hidden" value="1" />';
			}
			do_action( 'sp_op_after_entry_field' );
			break;			
	}
	if( ! in_array( $entry['type'], $sp_options_ignore_types ) && isset( $entry['desc'] ) && ! empty( $entry['desc'] ) ) {
		printf( '<span class="sp-op-one-desc">%s</span>', $entry['desc'] );
	}
	echo '</td>';
	echo '</tr>';
}

/** options panel field HTML output */
function sp_options_do_entry_html_field( $entry, $lang = '' ) {
	$id = SP_OPTIONS_PREFIX . $entry['id'] . ( $lang ? '[' . $lang . ']' : '' );
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'];
	$value = sp_option( $entry['id'], $lang );echo get_option($entry['id']);
	$std = isset( $entry['std'] ) ? $entry['std'] : '';
	$value = ( ! $multiple && empty( $value ) ) ? $std : $value;
	$options = isset( $entry['values'] ) ? $entry['values'] : array();
	switch( $entry['type'] ) {
		case 'text':
		case 'colorpicker':
			if( ! $multiple ) {
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-op-multi-one"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-op-multi-one-def"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
			}
		break;
		case 'email':
			if( ! $multiple ) {
				printf( '<input type="email" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-op-multi-one"><input type="email" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-op-multi-one-def"><input type="email" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
			}
		break;
		case 'password':
			if( ! $multiple ) {
				printf( '<input type="password" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-op-multi-one"><input type="password" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-op-multi-one-def"><input type="password" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
			}
		break;
		case 'datepicker':
			if( ! $multiple ) {
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-op-multi-one"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-op-multi-one-def"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
			}
		break;
		case 'colorselector':
			if( ! $multiple ) {
				echo '<div class="sp-colorselector">';
				foreach ( $options as $o_value => $o_name ) {
					if( is_int( $o_value ) ) { $o_title = ''; $o_value = $o_name; }
					else $o_title = $o_name;
					printf( '<label><input type="radio" name="%s" value="%s"%s /> <span class="sp-colorselector-preview" style="background-color: %s;"></span>%s</label><br />',
						$id, $o_value, ( $o_value == $value ) ? ' checked="checked"' : '', $o_value, $o_title );
				}
				echo '</div>';
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v ) {
						echo '<div class="sp-op-multi-one">';
							echo '<div class="sp-colorselector">';
							printf( '<input type="text" name="%s[]" value="%s" />', $id, esc_attr( $v ) );
							printf( '<span class="sp-colorselector-preview" style="background-color: %s;"></span>', esc_attr( $v ) );
							echo '</div>';
						echo '</div>';
					}
				echo '<div class="sp-op-multi-one-def">';
					echo '<div class="sp-colorselector">';
					printf( '<input type="text" name="%s[]" value="%s" />', $id, esc_attr( $std ) );
					printf( '<span class="sp-colorselector-preview" style="background-color: %s;"></span>', esc_attr( $std ) );
					echo '</div>';
				echo '</div>';
			}
		break;
		case 'textarea':
			if( ! $multiple ) {
				printf( '<textarea name="%s">%s</textarea>', $id, esc_textarea( $value ) );
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-op-multi-one"><textarea name="%s[]">%s</textarea></span>', $id, esc_textarea( $v ) );
				printf( '<span class="sp-op-multi-one-def"><textarea name="%s[]">%s</textarea></span>', $id, esc_textarea( $std ) );
			}
		break;
		case 'wysiwyg':
			wp_editor( $value, $id, array( 'textarea_name' => $id, 'editor_height' => 240, 'dfw' => true ) );
		break;
		case 'file':
			if( ! $multiple ) {
				$url = wp_get_attachment_url( $value );
				echo '<div class="sp-media-editor-field' . ( 0 != intval( $value ) ? ' selected' : ' notselected' ) . '">';
				printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
				printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
				printf( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $value ) );
				printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select File', 'sp' ) );
				printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
				echo '</div>';
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v ) {
						if( 0 != intval( $v ) ) {
							echo '<div class="sp-op-multi-one">';
								$url = wp_get_attachment_url( $v );
								echo '<div class="sp-media-editor-field selected">';
								printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
								printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
								printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $v ) );
								printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select File', 'sp' ) );
								printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
								echo '</div>';
							echo '</div>';
						}
					}
				echo '<div class="sp-op-multi-one-def">';
					echo '<div class="sp-media-editor-field notselected">';
					printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No file selected.', 'sp' ) );
					printf( '<span class="sp-media-editor-filename">%s</span>', '' );
					printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, '0' );
					printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select File', 'sp' ) );
					printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
					echo '</div>';
				echo '</div>';
			}
		break;
		case 'image':
			if( ! $multiple ) {
				$url = wp_get_attachment_url( $value );
				echo '<div class="sp-media-editor-field' . ( 0 != intval( $value ) ? ' selected' : ' notselected' ) . '">';
				printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
				printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
				printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', esc_attr( $url ) );
				printf( '<input type="hidden" name="%s" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $value ) );
				printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select Image', 'sp' ) );
				printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
				echo '</div>';
			} else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v ) {
						if( 0 != intval( $v ) ) {
							echo '<div class="sp-op-multi-one">';
								$url = wp_get_attachment_url( $v );
								echo '<div class="sp-media-editor-field selected">';
								printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
								printf( '<span class="sp-media-editor-filename">%s</span>', esc_attr( basename( $url ) ) );
								printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', esc_attr( $url ) );
								printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, esc_attr( $v ) );
								printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select Image', 'sp' ) );
								printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
								echo '</div>';
							echo '</div>';
						}
					}
				echo '<div class="sp-op-multi-one-def">';
					echo '<div class="sp-media-editor-field notselected">';
					printf( '<span class="sp-media-editor-notselected">%s</span>', __( 'No image selected.', 'sp' ) );
					printf( '<span class="sp-media-editor-filename">%s</span>', '' );
					printf( '<span class="sp-media-editor-preview"><img src="%s" class="sp-media-editor-preview-image" /></span>', '' );
					printf( '<input type="hidden" name="%s[]" class="sp-media-editor-input" value="%s" />', $id, '0' );
					printf( '<a href="#" class="button sp-btn-media-add">%s</a>', __( 'Select Image', 'sp' ) );
					printf( '<a href="#" class="button sp-btn-media-delete">%s</a>', __( 'Cancel', 'sp' ) );
					echo '</div>';
				echo '</div>';
			}
		break;
		case 'select':
			printf( '<select name="%s">', $id );
			foreach ( $options as $o_value => $o_name )
				printf( '<option value="%s"%s>%s</option>',
					$o_value, ( $o_value == $value ) ? ' selected="selected"' : '', $o_name );
			echo '</select>';
		break;
		case 'select_multi':
			printf( '<select name="%s[]" multiple="multiple" size="7">', $id );
			foreach ( $options as $o_value => $o_name )
				printf( '<option value="%s"%s>%s</option>',
					$o_value, in_array( $o_value, (array) $value ) ? ' selected="selected"' : '', $o_name );
			echo '</select>';
		break;
		case 'pages':
			printf( '<select name="%s">', $id );
			$pages_tmp = get_posts( array( 'post_type' => 'page', 'nopaging' => true ) );
			foreach ( $pages_tmp as $p )
				printf( '<option value="%s"%s>%s</option>',
					$p->ID, ( $p->ID == $value ) ? ' selected="selected"' : '', esc_html( get_the_title( $p->ID ) ) );
			echo '</select>';
		break;
		case 'radio':
			foreach ( $options as $o_value => $o_name )
				printf( '<label><input type="radio" name="%s" value="%s"%s /> %s</label><br />',
					$id, $o_value, ( $o_value == $value ) ? ' checked="checked"' : '', $o_name );
		break;
	}
}

function sp_options_panel_enqueue_assets_backend() {

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	add_thickbox();
	wp_enqueue_script( 'editor' );
	wp_enqueue_style( 'sp.jqueryui-datepicker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/sp.options-panel.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/sp.options-panel.back-end.js', array( 'jquery' ), false, true );

	$params = array(
		'add_new' => __( 'Add new', 'sp' ),
		'delete' => __( 'Delete', 'sp' ),
	);
	wp_localize_script( 'sp.options-panel', 'sp_options_panel_text', $params );

}
add_action( 'admin_enqueue_scripts', 'sp_options_panel_enqueue_assets_backend' );


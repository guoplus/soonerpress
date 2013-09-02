<?php


$_sp_options_ignore_types = array( 'title', 'info' );

/** add to admin menu */
function _sp_options_add_page() {
	global $sp_config;
	add_menu_page( __( 'Options Panel', 'sp' ), __( 'Options Panel', 'sp' ), 'manage_options', 'options_panel', '_sp_options_do_html', false, 3 );
	foreach ( $sp_config['options']['tabs'] as $k => $option_tab )
		add_submenu_page( 'options_panel', $option_tab['title'], $option_tab['title'], 'manage_options', 'options_panel'.'&tab='.$k, create_function( '$a', 'return null;' ) );
}
add_action( 'admin_menu', '_sp_options_add_page' );

/** register setting field to WordPress */
function _sp_options_init() {
	global $sp_config, $_sp_options_ignore_types;
	foreach ( $sp_config['options']['tabs'] as $option_tab ) {
		foreach ( $option_tab['fields'] as $option ) {
			if ( in_array( $option['type'], $_sp_options_ignore_types ) )
				continue;
			register_setting( 'sp_options_panel', SP_OPTIONS_PREFIX . $option['id'], '_sp_options_validate' );
		}
	}
}
add_action( 'admin_init', '_sp_options_init' );

/** options data submission validation */
function _sp_options_validate( $value ) {
	return $value;
}

/** options panel HTML output */
function _sp_options_do_html() {
	$settings_updated = ( ! isset( $_GET['settings-updated'] ) ) ? false : true;
	global $sp_config;
	?>

	<div class="wrap sp-wrap sp-options-panel">

		<div id="icon-index" class="icon32"><br></div>
		<h2><?php echo wp_get_theme() . ' ' . __( 'Options Panel', 'sp' ); ?></h2>

		<?php if ( $settings_updated ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved.', 'sp' ); ?></strong></p></div>
		<?php endif; ?>

		<?php if ( isset( $sp_config['options']['before_form'] ) ) echo $sp_config['options']['before_form']; ?>

		<form method="post" action="options.php" id="sp-options-panel-form">
			<?php settings_fields( 'sp_options_panel' ); ?>

			<div id="sp-options-panel-wrap">

				<?php if ( isset( $sp_config['options']['show_header'] ) && $sp_config['options']['show_header'] ) : ?>
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
						<li><a href="#"><?php if ( isset( $option_tab['icon'] ) ) : ?><span class="sp-options-tab-icon"><?php echo $option_tab['icon']; ?></span><?php endif; ?><?php echo esc_html( $option_tab['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div><!-- #sp-options-panel-tabs -->

				<div id="sp-options-panel-boxes">
					<ul>
						<?php foreach ( $sp_config['options']['tabs'] as $k => $option_tab ) : ?>
						<li id="sp-options-tab-<?php echo $k; ?>" class="sp-options-tab">
							<table><tbody>
							<?php foreach ( $option_tab['fields'] as $f ) : ?>
							<?php _sp_options_do_entry_html( $f ); ?>
							<?php endforeach; ?>
							</tbody></table>
						</li>
						<?php endforeach; ?>
					</ul>
				</div><!-- #sp-options-panel-boxes -->
				<div class="clearfix"></div>

				<?php if ( isset( $sp_config['options']['show_footer'] ) && $sp_config['options']['show_footer'] ) : ?>
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

		<?php if ( isset( $sp_config['options']['after_form'] ) ) echo $sp_config['options']['after_form']; ?>

	</div>

	<?php

}

/** a options panel entry HTML output */
function _sp_options_do_entry_html( $entry ) {

	global $sp_config, $_sp_options_ignore_types, $_sp_custom_meta_cloneable_field_types;
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_custom_meta_cloneable_field_types );

	echo '<tr valign="top" class="sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';

	// not a non-field type
	if ( ! in_array( $entry['type'], $_sp_options_ignore_types ) ) {
		printf( '<th scope="row" class="sp-cm-one-name">%s</th>', apply_filters( 'sp_op_one_name', $entry['title'], ( ( ! isset( $entry['ml'] ) ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) );
	}

	// field name
	echo '<td class="sp-cm-one-field' . ( $multiple ? ' sp-cm-one-field-multiple' : '' ) . '"' .
		( in_array( $entry['type'], $_sp_options_ignore_types ) ? ' colspan="2"' : '' ) . '>';

	// field input
	switch ( $entry['type'] ) {
		case 'title':
			printf( '<h3>%s</h3>', esc_html( $entry['title'] ) );
			break;
		case 'info':
			printf( '<p>%s</p>', esc_html( $entry['title'] ) );
			break;
		default:
			do_action( 'sp_op_before_entry_field' );
			if ( ! sp_enabled_module( 'multi-language' ) || ( isset( $entry['ml'] ) && ! $entry['ml'] ) ) {
				// not in multi-language
				_sp_options_do_entry_html_field( $entry );
			} else {
				// multi-language is enabled & available
				foreach ( $sp_config['languages']['enabled'] as $l ) {
					echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $l ) . '">';
					_sp_options_do_entry_html_field( $entry, $l );
					echo '</div>';
				}
				// multi-language mark
				echo '<input name="' . SP_OPTIONS_PREFIX . $entry['id'] . '[ml]" type="hidden" value="1" />';
			}
			do_action( 'sp_op_after_entry_field' );
			break;			
	}

	// field description
	if ( ! in_array( $entry['type'], $_sp_options_ignore_types ) && isset( $entry['desc'] ) && ! empty( $entry['desc'] ) ) {
		printf( '<span class="sp-cm-one-desc">%s</span>', $entry['desc'] );
	}

	echo '</td>';

	echo '</tr>';

}

/** a options panel field HTML output */
function _sp_options_do_entry_html_field( $entry, $lang = '' ) {
	$id = SP_OPTIONS_PREFIX . $entry['id'] . ( $lang ? '[' . $lang . ']' : '' );
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'];
	$value = sp_option( $entry['id'], $lang );
	$std = isset( $entry['std'] ) ? $entry['std'] : '';
	$value = ( ! $multiple && empty( $value ) ) ? $std : $value;
	$choices = isset( $entry['choices'] ) ? $entry['choices'] : array();
	__sp_custom_meta_do_entry_html_field( $id, $entry['type'], $multiple, $value, $std,
		array( 'choices' => $choices ) );
}

function _sp_options_panel_enqueue_assets_backend() {

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/sp.options-panel.back-end.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/sp.options-panel.back-end.js', array( 'jquery' ), false, true );

}
add_action( 'admin_enqueue_scripts', '_sp_options_panel_enqueue_assets_backend' );


<?php


$_sp_op_ignore_types = array( 'title', 'info' );

/** get option value stored by Options Panel */
function sp_option( $key, $lang = '' ) {
	$result = get_option( apply_filters( 'sp_option_name', SP_OPTION_PREFIX . $key, $lang ) );
	return $result;
}

/** add to admin menu */
function _sp_op_add_page() {
	global $sp_config;
	add_menu_page( __( 'Options Panel', 'sp' ), __( 'Options Panel', 'sp' ), 'manage_options', 'options_panel', '_sp_op_do_html', false, 3 );
}
add_action( 'admin_menu', '_sp_op_add_page' );

/** register setting field to WordPress */
function _sp_op_init() {
	global $sp_config, $_sp_op_ignore_types;
	foreach ( $sp_config['options']['tabs'] as $option_tab ) {
		foreach ( $option_tab['fields'] as $option ) {
			if ( in_array( $option['type'], $_sp_op_ignore_types ) )
				continue;
			$option_name = SP_OPTION_PREFIX . $option['id'];
			register_setting( 'sp_options_panel', $option_name );
			do_action( 'sp_op_register_setting', 'sp_options_panel', $option_name, $option );
		}
	}
}
add_action( 'admin_init', '_sp_op_init' );

/** options panel HTML output */
function _sp_op_do_html() {
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
							<?php foreach ( $option_tab['fields'] as $field ) : ?>
							<?php _sp_op_do_entry_html( $field ); ?>
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
function _sp_op_do_entry_html( $entry ) {

	global $sp_config, $_sp_op_ignore_types, $_sp_cm_repeatable_field_types;
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cm_repeatable_field_types );

	echo '<tr valign="top" class="sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';

	// not a non-field type
	if ( ! in_array( $entry['type'], $_sp_op_ignore_types ) ) {
		printf( '<th scope="row" class="sp-cm-one-name">%s</th>', apply_filters( 'sp_op_one_name', $entry['title'], ( ( ! isset( $entry['ml'] ) ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) );
	}

	// field name
	echo '<td class="sp-cm-one-field' . ( $multiple ? ' sp-cm-one-field-multiple' : '' ) . '"' .
		( in_array( $entry['type'], $_sp_op_ignore_types ) ? ' colspan="2"' : '' ) . '>';

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
				echo '<div class="sp-cm-one-field-content">';
				_sp_op_do_entry_html_field( $entry );
				echo '</div>';
			} else {
				// multi-language is enabled & available
				foreach ( $sp_config['languages']['enabled'] as $l ) {
					echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $l ) . '">';
					_sp_op_do_entry_html_field( $entry, $l );
					echo '</div>';
				}
			}
			do_action( 'sp_op_after_entry_field' );
			break;			
	}

	// field description
	if ( ! in_array( $entry['type'], $_sp_op_ignore_types ) && isset( $entry['desc'] ) && ! empty( $entry['desc'] ) ) {
		printf( '<span class="sp-cm-one-desc">%s</span>', $entry['desc'] );
	}

	echo '</td>';

	echo '</tr>';

}

/** a options panel field HTML output */
function _sp_op_do_entry_html_field( $entry, $lang = '' ) {
	global $sp_config;
	$value = sp_option( $entry['id'], $lang );
	if( false !== $value ) // a {false} will be returned if variable was not set
		$entry['value'] = $value;
	$entry['id'] = SP_OPTION_PREFIX . $entry['id'] .
		( ( ! empty( $lang ) && $sp_config['languages']['main_stored'] != $lang ) ? SP_META_LANG_PREFIX . $lang : '' );
	new SP_CM_FIELD ( $entry );
}

function _sp_op_enqueue_assets_dashboard() {

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'fontawesome-ie7' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.options-panel.dashboard', SP_INC_URI . '/options-panel/sp.options-panel.dashboard.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.options-panel.dashboard', SP_INC_URI . '/options-panel/sp.options-panel.dashboard.js', array( 'jquery' ), false, true );

}
add_action( 'admin_enqueue_scripts', '_sp_op_enqueue_assets_dashboard' );


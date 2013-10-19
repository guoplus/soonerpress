<?php
/**
 * Options Panel module API
 *
 * @package SoonerPress
 * @subpackage Options_Panel
 */


/** get option value stored by Options Panel */
function sp_option( $key, $locale_code = '' ) {
	$result = get_option( apply_filters( 'sp_option_name', SP_OPTION_PREFIX . $key, $locale_code ) );
	return $result;
}


class SP_Options_Panel extends SP_Module {

	var $op_ignore_types = array( 'title', 'info' );

	function __construct() {
		$this->dc = array(
			'menu_title'  => __( 'Options Panel', 'sp' ),
			'page_title'  => wp_get_theme() . ' ' . __( 'Options Panel', 'sp' ),
			'show_header' => true,
			'show_footer' => false,
			'before_form' => null,
			'after_form'  => null,
			'tabs'        => array(),
		);
		$this->init( 'options-panel' );
		// admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu') );
	}

	// ==================== admin menu ====================

	function add_admin_menu() {
		// register setting field to WordPress
		foreach ( $this->c['tabs'] as $option_tab ) {
			foreach ( $option_tab['fields'] as $option ) {
				if ( in_array( $option['type'], $this->op_ignore_types ) )
					continue;
				$option_name = SP_OPTION_PREFIX . $option['id'];
				register_setting( 'sp_options_panel', $option_name );
				do_action( 'sp_op_register_setting', 'sp_options_panel', $option_name, $option );
			}
		}
		// add page to admin menu
		add_menu_page( $this->c['page_title'], $this->c['menu_title'], 'manage_options', 'options_panel', array( $this, 'admin_menu_do_html' ), false, 3 );
	}

	function admin_menu_do_html() {
		$page_title = get_admin_page_title();
		?>

		<div class="wrap sp-wrap sp-options-panel">

			<div id="icon-index" class="icon32"><br></div>
			<h2><?php echo $page_title; ?></h2>

			<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved.', 'sp' ); ?></strong></p></div>
			<?php endif; ?>

			<?php echo $this->c['before_form']; ?>

			<form method="post" action="options.php" id="sp-options-panel-form">
				<?php settings_fields( 'sp_options_panel' ); ?>

				<div id="sp-options-panel-wrap">

					<?php if ( $this->c['show_header'] ) : ?>
					<div id="sp-options-panel-header">
						<?php do_action( 'sp_op_header' ); ?>
						<div id="sp-options-panel-header-ctrl">
							<input type="submit" class="btn-op-submit button-primary" value="<?php _e( 'Save Changes', 'sp' ); ?>" />
							<input type="reset" class="btn-op-reset button" value="<?php _e( 'Reset All', 'sp' ); ?>" />
						</div>
						<div class="clearfix"></div>
					</div><!-- #sp-options-panel-header -->
					<div class="clearfix"></div>
					<?php endif; ?>

					<div id="sp-options-panel-tabs">
						<ul>
							<?php foreach ( $this->c['tabs'] as $option_tab ) : ?>
							<li><a href="#"><?php if ( isset( $option_tab['icon'] ) ) : ?><span class="sp-options-tab-icon"><?php echo $option_tab['icon']; ?></span><?php endif; ?><?php echo esc_html( $option_tab['title'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div><!-- #sp-options-panel-tabs -->

					<div id="sp-options-panel-boxes">
						<ul>
							<?php foreach ( $this->c['tabs'] as $k => $option_tab ) : ?>
							<li id="sp-options-tab-<?php echo $k; ?>" class="sp-options-tab">
								<table><tbody>
								<?php foreach ( $option_tab['fields'] as $field ) : ?>
								<?php $this->do_entry_html( $field ); ?>
								<?php endforeach; ?>
								</tbody></table>
							</li>
							<?php endforeach; ?>
						</ul>
					</div><!-- #sp-options-panel-boxes -->
					<div class="clearfix"></div>

					<?php if ( $this->c['show_footer'] ) : ?>
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

			<?php echo $this->c['after_form']; ?>

		</div>

		<?php
	}

	function do_entry_html( $entry ) {

		global $_sp_cm_repeatable_field_types;
		$multiple = isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cm_repeatable_field_types );

		echo '<tr valign="top" class="sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';

		// not a non-field type
		if ( ! in_array( $entry['type'], $this->op_ignore_types ) )
			printf( '<th scope="row" class="sp-cm-one-name">%s</th>', apply_filters( 'sp_op_one_name', $entry['title'], ( ( ! isset( $entry['ml'] ) ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) );

		// field name
		echo '<td class="sp-cm-one-field' . ( $multiple ? ' sp-cm-one-field-multiple' : '' ) . '"' .
			( in_array( $entry['type'], $this->op_ignore_types ) ? ' colspan="2"' : '' ) . '>';

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
				if ( ! sp_module_enabled( 'multilingual' ) || ( isset( $entry['ml'] ) && ! $entry['ml'] ) ) {
					// not in multi-language
					echo '<div class="sp-cm-one-field-content">';
					$this->do_entry_html_field( $entry );
					echo '</div>';
				} else {
					// multilingual is enabled & available
					foreach ( sp_get_enabled_languages_ids() as $lang_code ) {
						echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $lang_code ) . '">';
						$this->do_entry_html_field( $entry, $lang_code );
						echo '</div>';
					}
				}
				do_action( 'sp_op_after_entry_field' );
				break;			
		}

		// field description
		if ( ! in_array( $entry['type'], $this->op_ignore_types ) && isset( $entry['desc'] ) && ! empty( $entry['desc'] ) ) {
			printf( '<span class="sp-cm-one-desc">%s</span>', $entry['desc'] );
		}

		echo '</td>';

		echo '</tr>';

	}

	function do_entry_html_field( $entry, $lang_code = '' ) {
		$value = sp_option( $entry['id'], $lang_code );
		if( false !== $value ) // a {false} will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_OPTION_PREFIX . $entry['id'] . ( ! empty( $lang_code ) ? SP_META_LANG_PREFIX . $lang_code : '' );
		new SP_CM_Field ( $entry );
	}

	function enqueue_assets_dashboard() {

		wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'fontawesome-ie7' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

		wp_localize_script( 'sp.' . $this->slug . '.dashboard', 'sp_options_panel_l10n', array(
			'are_you_sure' => __( 'Are you sure?', 'sp' ),
		) );

	}

}

new SP_Options_Panel();


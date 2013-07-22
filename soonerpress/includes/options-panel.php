<?php


$sp_options_ignore_types = array( 'title', 'info' );

function sp_options_add_page() {
	global $sp_config;
	add_menu_page( __( 'Options Panel', 'sp' ), __( 'Options Panel', 'sp' ), 'manage_options', 'options_panel', 'sp_options_do_html', false, 3 );
	foreach ( $sp_config['options']['tabs'] as $k => $option_tab )
		add_submenu_page( 'options_panel', $option_tab['title'], $option_tab['title'], 'manage_options', 'options_panel'.'&tab='.$k, create_function( '$a', 'return null;' ) );
}
add_action( 'admin_menu', 'sp_options_add_page' );


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


function sp_options_validate( $value ) {

	return $value;
}


function sp_options_do_html() {
	if ( ! isset( $_GET['settings-updated'] ) ) $_GET['settings-updated'] = false;
	global $sp_config;
	?>
	<div class="wrap sp-wrap sp-options-panel">
		<div id="icon-index" class="icon32"><br></div>
		<h2><?php echo wp_get_theme() . ' ' . __( 'Options Panel', 'sp' ); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'sp_options_panel' ); ?>
			<div id="sp-options-panel-wrap">
				<div id="sp-options-panel-header">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'sp' ); ?>" />
					<input type="reset" class="button" value="<?php _e( 'Reset All', 'sp' ); ?>" />
				</div>
				<div class="clearfix"></div>
				<ul id="sp-options-panel-tabs">
					<?php foreach ( $sp_config['options']['tabs'] as $option_tab ) : ?>
					<li><a href="#"><?php if( isset( $option_tab['icon'] ) ) echo $option_tab['icon']; echo esc_html( $option_tab['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
				<ul id="sp-options-panel-boxes">
					<?php foreach ( $sp_config['options']['tabs'] as $k => $option_tab ) : ?>
					<li id="sp-options-tab-<?php echo $k; ?>" class="sp-options-tab">
						<?php foreach ( $option_tab['fields'] as $option ) : ?>
						<?php sp_options_do_entry_html( $option ); ?>
						<?php endforeach; ?>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="clearfix"></div>
				<div id="sp-options-panel-footer">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'sp' ); ?>" />
					<input type="reset" class="button" value="<?php _e( 'Reset All', 'sp' ); ?>" />
				</div>
			</div><!-- #sp-options-panel-wrap -->
		</form>
	</div>
	<?php
}


function sp_options_do_entry_html( $option ) {
	echo '<div class="sp-op-en sp-op-en-t-' . $option['type'] . '">';
	global $sp_config, $sp_options_ignore_types;
	if( ! in_array( $option['type'], $sp_options_ignore_types ) ) {
		printf( '<span class="sp-op-en-name">%s</span>', $option['title'] );
		$id = SP_OPTIONS_PREFIX . $option['id'];
		$multiple = isset( $option['multiple'] ) && $option['multiple'];
		$value = get_option( $id );
		$std = isset( $option['std'] ) ? $option['std'] : '';
		$value = ( ! $multiple && empty( $value ) ) ? $std : $value;
	}
	switch( $option['type'] ) {
		case 'title':
			printf( '<h3>%s</h3>', esc_html( $option['title'] ) );
			break;
		case 'info':
			printf( '<p>%s</p>', esc_html( $option['title'] ) );
			break;
		case 'text':
			if( ! $multiple )
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			else {
				if( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<input type="text" name="%s[]" value="%s" />', $id, esc_attr( $v ) );
				else
					printf( '<input type="text" name="%s[]" value="%s" />', $id, esc_attr( $std ) );
				printf( '<div class="sp-op-multi-one"><input type="text" name="%s[]" value="%s" /></div>', $id, esc_attr( $std ) );
			}
			break;
		case 'textarea':
			printf( '<textarea name="%s">%s</textarea>', $id, esc_textarea( $value ) );
	}
	if( ! in_array( $option['type'], $sp_options_ignore_types ) && isset( $option['desc'] ) && ! empty( $option['desc'] ) ) {
		printf( '<span class="sp-op-en-desc">%s</span>', $option['desc'] );
	}
	echo '</div>';
}


function sp_enqueue_scripts_options_panel() {

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	sp_enqueue_bootstrap_js();
	add_thickbox();
	wp_enqueue_style( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/assets/sp.options-panel.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.options-panel', SP_INCLUDES_URI . '/options-panel/assets/sp.options-panel.js', array( 'jquery' ), false, true );

}
add_action( 'admin_enqueue_scripts', 'sp_enqueue_scripts_options_panel' );


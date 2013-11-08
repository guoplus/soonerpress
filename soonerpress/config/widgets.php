<?php
/**
 * Widgets module configuration
 *
 * @package SoonerPress
 * @subpackage Widgets
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

/** Widget: Sample Widget */
class SP_widget_sample extends WP_Widget {

	function __construct() {
		parent::__construct( 'sample_widget', __( 'Sample Widget', 'sp' ), array( 'description' => __( 'A sample widget.', 'sp' ) ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		?>
			<?php echo $before_widget; ?>
			<?php if( ! empty( $title ) ) echo $before_title . $title . $after_title; ?>
			<!-- TODO -->
			<?php echo $after_widget; ?>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( $instance, array( 'title' => 'Sample Title', 'param' => 'value', ) );
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('param'); ?>"><?php _e('Param Name:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('param'); ?>" name="<?php echo $this->get_field_name('param'); ?>" type="text" value="<?php echo esc_attr( $instance['param'] ); ?>" /></p>
		<?php
	}

}


/** Register Widgets */
function sp_register_widgets() {

	register_widget( 'SP_widget_sample' );

}
add_action( 'widgets_init', 'sp_register_widgets' );


/** Unregister Widgets */
function sp_unregister_widgets() {

	// unregister_widget( 'WP_Widget_Pages' );            // Pages Widget
	// unregister_widget( 'WP_Widget_Calendar' );         // Calendar Widget
	// unregister_widget( 'WP_Widget_Archives' );         // Archives Widget
	// unregister_widget( 'WP_Widget_Links' );            // Links Widget
	// unregister_widget( 'WP_Widget_Meta' );             // Meta Widget
	// unregister_widget( 'WP_Widget_Search' );           // Search Widget
	// unregister_widget( 'WP_Widget_Text' );             // Text Widget
	// unregister_widget( 'WP_Widget_Categories' );       // Categories Widget
	// unregister_widget( 'WP_Widget_Recent_Posts' );     // Recent Posts Widget
	// unregister_widget( 'WP_Widget_Recent_Comments' );  // Recent Comments Widget
	// unregister_widget( 'WP_Widget_RSS' );              // RSS Widget
	// unregister_widget( 'WP_Widget_Tag_Cloud' );        // Tag Cloud Widget
	// unregister_widget( 'WP_Nav_Menu_Widget' );         // Menus Widget

}
add_action( 'widgets_init', 'sp_unregister_widgets' );


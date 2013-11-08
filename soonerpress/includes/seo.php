<?php
/**
 * SEO module API
 *
 * @package SoonerPress
 * @subpackage SEO
 */

if ( ! defined( 'IN_SP' ) ) exit;


class SP_SEO extends SP_Module {

	var $fields = array(
		'title'       => 'Title',
		'description' => 'Description',
		'keywords'    => 'Keywords',
	);

	function __construct() {
		$this->init( 'seo' );
		// hooks
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post'     , array( $this, 'save_post_meta' ) );
		add_action( 'wp_head'       , array( $this, 'html_head_title_output' ) );
	}

	function add_meta_boxes() {
		if( sizeof( $this->c ) ) {
			$post_types = array_keys( $this->c );
			foreach ( $post_types as $post_type ) {
				add_meta_box( 'sp_seo', __( 'SEO Settings', 'sp' ), array( $this, 'do_html_meta_box' ), $post_type, 'side' );
			}
		}
	}

	function do_html_meta_box( $post ) {
		$post_type = get_post_type( $post );
		?>
		<?php foreach ( $this->fields as $field => $field_name ) :
			if( in_array( $field, $this->c[$post_type] ) ) : ?>
		<div class="sp_seo_meta_field"><label for="sp_seo_meta_<?php echo $field; ?>"><strong><?php echo $field_name; ?></strong>
			<textarea name="sp_seo_meta_<?php echo $field; ?>" id="sp_seo_meta_<?php echo $field; ?>"><?php echo esc_textarea( get_post_meta( $post->ID, '_sp_seo_' . $field, true ) ); ?></textarea></label></div>
		<?php endif; endforeach; ?>
		<?php
	}

	function save_post_meta( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
		$post_type = get_post_type( $post_id );
		if( isset( $this->c[$post_type] ) )
			foreach ( $this->c[$post_type] as $field ) {
				if ( isset( $_POST['sp_seo_meta_'.$field] ) ) {
					if( ! empty( $_POST['sp_seo_meta_'.$field] ) )
						add_post_meta( $post_id, '_sp_seo_'.$field, $_POST['sp_seo_meta_'.$field], true ) or
							update_post_meta( $post_id, '_sp_seo_'.$field, $_POST['sp_seo_meta_'.$field] );
					else
						delete_post_meta( $post_id, '_sp_seo_'.$field );
				}
			}
	}

	function html_head_title_output() {
		$t = $d = $k = '';
		global $post;
		if ( is_home() || is_front_page() ) {
			$t = sp_option( 'global_title' );
			$d = sp_option( 'global_description' );
			$k = sp_option( 'global_keywords' );
		} elseif ( is_singular() ) {
			$t = get_post_meta( $post->ID, '_sp_seo_title',       true );
			$d = get_post_meta( $post->ID, '_sp_seo_description', true );
			$k = get_post_meta( $post->ID, '_sp_seo_keywords',    true );
		}
		if( empty( $t ) )
			$t = sp_title();
		printf( '<title>%s</title>', esc_html( $t ) );
		if( ! empty( $d ) )
			printf( '<meta name="description" content="%s" />', esc_attr( $d ) );
		if( ! empty( $k ) )
			printf( '<meta name="keywords" content="%s" />', esc_attr( $k ) );
	}

	function enqueue_assets_dashboard() {

		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );

	}

}

new SP_SEO();


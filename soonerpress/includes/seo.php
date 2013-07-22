<?php


function sp_seo_add_meta_boxes() {
	global $sp_config;
	if( $sp_config['seo'] ) {
		$post_types = array_keys( $sp_config['seo'] );
		foreach ( $post_types as $post_type ) {
			add_meta_box( 'sp_seo', __( 'SEO Settings', 'sp' ), 'sp_seo_meta_box_do_html', $post_type, 'side' );
		}
	}
}
add_action( 'add_meta_boxes', 'sp_seo_add_meta_boxes' );

function sp_seo_meta_box_do_html( $post ) {
	global $sp_config;
	$post_type = get_post_type( $post );
	?>
	<?php if( in_array( 'title', $sp_config['seo'][$post_type] ) ) : ?>
	<p><label for=""><?php _e( 'Title', 'sp' ); ?><br />
		<textarea name="sp_seo_meta_title" id="sp_seo_meta_title"><?php echo esc_textarea( get_post_meta( $post->ID, '_sp_seo_title', true ) ); ?></textarea></label></p>
	<?php endif; ?>
	<?php if( in_array( 'description', $sp_config['seo'][$post_type] ) ) : ?>
	<p><label for=""><?php _e( 'Description', 'sp' ); ?><br />
		<textarea name="sp_seo_meta_description" id="sp_seo_meta_description"><?php echo esc_textarea( get_post_meta( $post->ID, '_sp_seo_description', true ) ); ?></textarea></label></p>
	<?php endif; ?>
	<?php if( in_array( 'keywords', $sp_config['seo'][$post_type] ) ) : ?>
	<p><label for=""><?php _e( 'Keywords', 'sp' ); ?><br />
		<textarea name="sp_seo_meta_keywords" id="sp_seo_meta_keywords"><?php echo esc_textarea( get_post_meta( $post->ID, '_sp_seo_keywords', true ) ); ?></textarea></label></p>
	<?php endif; ?>
	<?php
}

function sp_seo_save_post_meta( $post_id ) {
	if ( ! current_user_can( 'edit_page', $post_id ) )
		return;
	global $sp_config;
	$post_type = get_post_type( $post_id );
	foreach ( $sp_config['seo'][$post_type] as $field ) {
		if ( isset( $_POST['sp_seo_meta_'.$field] ) ) {
			if( ! empty( $_POST['sp_seo_meta_'.$field] ) )
				add_post_meta( $post_id, '_sp_seo_'.$field, $_POST['sp_seo_meta_'.$field], true ) or
					update_post_meta( $post_id, '_sp_seo_'.$field, $_POST['sp_seo_meta_'.$field] );
			else
				delete_post_meta( $post_id, '_sp_seo_'.$field );
		}
	}
}
add_action( 'save_post', 'sp_seo_save_post_meta' );


function sp_title_output() {
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
add_action( 'wp_head', 'sp_title_output' );


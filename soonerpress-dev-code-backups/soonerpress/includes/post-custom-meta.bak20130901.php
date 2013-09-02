<?php


/** get post custom meta */
function sp_pm( $post_id, $key, $lang = '' ) {
	$value = get_post_meta( $post_id, '_'.$key, true );
	$value = apply_filters( 'sp_pm', $value, $post_id, $key, $lang );
	return $value;
}

function sp_post_meta_add_meta_boxes( $post_type, $post ) {
	global $sp_config;
	if ( isset( $sp_config['post-custom-meta']['boxes'] ) && $sp_config['post-custom-meta']['boxes'] ) {
		foreach( $sp_config['post-custom-meta']['boxes'] as $box ) {
			// add meta box to edit form
			if ( sp_post_meta_can_be_added( $box['cond'], $post->ID ) )
				add_meta_box( $box['id'], $box['title'], 'sp_post_meta_do_box', get_post_type( $post ),
					'advanced', 'default', $box );
		}
	}
}
add_action( 'add_meta_boxes', 'sp_post_meta_add_meta_boxes', 10, 2 );

function sp_post_meta_can_be_added( $cond, $post_id ) {
	$can_be_added = true;
	if ( isset( $cond['post_type'] ) ) {
		$post_type = get_post_type( $post_id );
		if ( ! in_array( $post_type, (array) $cond['post_type'] ) )
			$can_be_added = false;
	}
	if ( isset( $cond['page_template'] ) ) {
		$page_template = get_post_meta( $post_id, '_wp_page_template', true );
		if ( ! in_array( $page_template, (array) $cond['page_template'] ) )
			$can_be_added = false;
	}
	return $can_be_added;
}

function sp_post_meta_do_box( $post, $metabox ) {
	$box = $metabox['args'];
	echo '<div class="sp-pm-box-wrap">';
	if ( isset( $box['fields'] ) && $box['fields'] )
		foreach( $box['fields'] as $f )
			sp_post_meta_do_entry_html( $f, $post->ID );
	echo '</div>';
}

function sp_post_meta_do_entry_html( $entry, $post_id ) {
	global $sp_config;
	echo '<div class="sp-pm-one sp-pm-one-t-' . $entry['type'] . '">';
	// entry title
	printf( '<span class="sp-pm-one-name">%s</span>',
		$entry['title'] .
			( ( sp_in_ml() && ( ( ! isset( $entry['ml'] ) ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ?
				sp_ml_html_languages_tabs() : '' ) );
	$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] ) || ( 'group' == $entry['type'] );
	// entry field
	echo '<span class="sp-pm-one-field' . ( $multiple ? ' sp-pm-one-field-multiple' : '' ) . '">';
	if ( ! sp_in_ml() || ( isset( $entry['ml'] ) && ! $entry['ml'] ) ) {
		sp_post_meta_do_entry_html_field( $entry, $post_id );
	} else {
		foreach( $sp_config['languages']['enabled'] as $l ) {
			echo '<span class="sp-pm-one-field-l sp-pm-one-field-l-' . esc_attr( $l ) . '">';
			sp_post_meta_do_entry_html_field( $entry, $post_id, $l );
			echo '</span>';
		}
	}
	echo '</span>';
	// entry description
	if ( isset( $entry['desc'] ) && ! empty( $entry['desc'] ) )
		printf( '<span class="sp-pm-one-desc">%s</span>', $entry['desc'] );
	echo '<div class="clearfix"></div></div>';
}

function sp_post_meta_do_entry_html_field( $entry, $post_id, $lang = '' ) {
	$id = $entry['id'] . ( ! empty( $lang ) ? '['.$lang.']' : '' );
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'];
	$std = isset( $entry['std'] ) ? $entry['std'] : '';
	$value = sp_pm( $post_id, $entry['id'], $lang );
	switch( $entry['type'] ) {
		case 'text':
			// ==================== text ====================
			if ( ! $multiple ) {
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-pm-multi-one"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-pm-multi-one-def"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
			}
			break;
		case 'textarea':
			// ==================== textarea ====================
			if ( ! $multiple ) {
				printf( '<textarea name="%s">%s</textarea>', $id, esc_textarea( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-pm-multi-one"><textarea name="%s[]">%s</textarea>', $id, esc_textarea( $v ) );
				printf( '<span class="sp-pm-multi-one-def"><textarea name="%s[]">%s</textarea>', $id, esc_textarea( $std ) );
			}
			break;
		case 'group':
			// ==================== multiple group ====================
			$fields = $entry['fields'];
			$single_title = $entry['single_title'];
			if ( is_array( $value ) && $value )
				foreach ( $value as $k => $v ) {
					echo '<div class="sp-pm-multi-one-group">';
					printf( '<span class="sp-pm-multi-one-singletitle">%s</span>', $single_title );
					echo '<div class="sp-pm-multi-one-singlecontent">';
					foreach( $fields as $f ) {
						sp_post_meta_do_entry_html_field_nested( $f, $id . '['.$k.']', $v );
					}
					echo '</div>';
					echo '</div>';
				}
			echo '<div class="sp-pm-multi-one-def">';
			printf( '<span class="sp-pm-multi-one-singletitle">%s</span>', $single_title );
			echo '<div class="sp-pm-multi-one-singlecontent">';
			foreach( $fields as $f ) {
				sp_post_meta_do_entry_html_field_nested( $f, $id . '[SP_SERIAL_ID]' );
			}
			echo '</div>';
			echo '</div>';
			break;
	}
}

function sp_post_meta_do_entry_html_field_nested( $entry, $id_parent, $value_origin = '' ) {
	$id = $id_parent . '[' . $entry['id'] . ']';
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'];
	$value = ( ( sizeof( $value_origin ) && isset( $value_origin[$entry['id']] ) ) ? $value_origin[$entry['id']] : '' );
	$std = isset( $entry['std'] ) ? $entry['std'] : '';
	printf( '<span class="sp-pm-multi-one-nested-name">%s</span>', $entry['title'] );
	switch( $entry['type'] ) {
		case 'text':
			// ==================== text ====================
			if ( ! $multiple ) {
				printf( '<input type="text" name="%s" value="%s" />', $id, esc_attr( $value ) );
			} else {
				echo '<span class="sp-pm-one-field-nest-multiple">';
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-pm-multi-one"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $v ) );
				printf( '<span class="sp-pm-multi-one-def"><input type="text" name="%s[]" value="%s" /></span>', $id, esc_attr( $std ) );
				echo '</span>';
			}
			break;
		case 'textarea':
			// ==================== textarea ====================
			if ( ! $multiple ) {
				printf( '<textarea name="%s">%s</textarea>', $id, esc_textarea( $value ) );
			} else {
				if ( is_array( $value ) && $value )
					foreach ( $value as $v )
						printf( '<span class="sp-pm-multi-one"><textarea name="%s[]">%s</textarea></span>', $id, esc_textarea( $v ) );
				printf( '<span class="sp-pm-multi-one-def"><textarea name="%s[]">%s</textarea></span>', $id, esc_textarea( $std ) );
			}
			break;
		// case 'group':
		// 	// ==================== multiple group ====================
		// 	// somebody dead.
		// 	break;
	}
}

function sp_post_meta_save_post( $post_id ) {
	global $sp_config;
	if ( isset( $sp_config['post-custom-meta']['boxes'] ) && $sp_config['post-custom-meta']['boxes'] ) {
		foreach( $sp_config['post-custom-meta']['boxes'] as $box ) {
			if ( sp_post_meta_can_be_added( $box['cond'], $post_id ) )
				if ( isset( $box['fields'] ) && $box['fields'] )
					foreach( $box['fields'] as $f ) {
						if ( isset( $_POST[$f['id']] ) ) {
							$data = $_POST[$f['id']];
							if ( get_magic_quotes_gpc() )
								$data = stripslashes_deep( $data );
							if ( sp_in_ml() && ( ( ! isset( $f['ml'] ) ) || ( isset( $f['ml'] ) && $f['ml'] ) ) ) {
								$data['ml'] = true;
							}
							// delete_post_meta( $post_id, '_'.$f['id'] );
							update_post_meta( $post_id, '_'.$f['id'], $data );
						}
					}
		}
	}
}
add_action( 'save_post', 'sp_post_meta_save_post' );

function sp_post_meta_enqueue_assets_backend() {

	global $pagenow;
	if( 'post.php' != $pagenow )
		return;

	sp_enqueue_fontawesome();
	wp_enqueue_script( 'jquery' );
	add_thickbox();
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style( 'sp.post-custom-meta', SP_INCLUDES_URI . '/post-custom-meta/sp.post-custom-meta.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.post-custom-meta', SP_INCLUDES_URI . '/post-custom-meta/sp.post-custom-meta.js', array( 'jquery' ), false, true );

	wp_localize_script( 'sp.post-custom-meta', 'sp_post_custom_meta_text', array(
		'add_new' => __( 'Add new', 'sp' ),
		'delete' => __( 'Delete', 'sp' ),
	) );

}
add_action( 'admin_enqueue_scripts', 'sp_post_meta_enqueue_assets_backend' );


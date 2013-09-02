<?php


/** get post custom meta */
function sp_pm( $post_id, $key, $lang = '' ) {
	$value = get_post_meta( $post_id, '_'.$key, true );
	$value = apply_filters( 'sp_pm', $value, $post_id, $key, $lang );
	return $value;
}

/** walk each post meta box and add to WordPress post edit */
function _sp_post_meta_add_meta_boxes( $post_type, $post ) {
	global $sp_config;
	if ( isset( $sp_config['post-custom-meta']['boxes'] ) && $sp_config['post-custom-meta']['boxes'] ) {
		foreach( $sp_config['post-custom-meta']['boxes'] as $box ) {
			// add meta box to edit form
			if ( _sp_post_meta_can_be_added( $box['cond'], $post->ID ) )
				add_meta_box( $box['id'], $box['title'], '_sp_post_meta_do_box', get_post_type( $post ),
					'advanced', 'default', $box );
		}
	}
}
add_action( 'add_meta_boxes', '_sp_post_meta_add_meta_boxes', 10, 2 );

/** check if a post meta box is available for the specified post */
function _sp_post_meta_can_be_added( $cond, $post_id ) {
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

/** post meta box HTML output */
function _sp_post_meta_do_box( $post, $metabox ) {
	$box = $metabox['args'];
	echo '<div class="sp-pm-box-wrap">';
	if ( isset( $box['fields'] ) && $box['fields'] )
		foreach( $box['fields'] as $f )
			_sp_post_meta_do_entry_html( $f, $post->ID );
	echo '</div>';
}

/** a post meta entry HTML output */
function _sp_post_meta_do_entry_html( $entry, $post_id ) {

	global $sp_config;

	echo '<div class="sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';

	// entry title
	printf( '<span class="sp-cm-one-name">%s</span>', apply_filters( 'sp_pm_one_name', $entry['title'], ( ( ! isset( $entry['ml'] ) ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) );

	// entry field
	$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] ) || ( 'group' == $entry['type'] );
	echo '<div class="sp-cm-one-field' . ( $multiple ? ' sp-cm-one-field-multiple' : '' ) . '">';
	if ( ! sp_enabled_module( 'multi-language' ) || ( isset( $entry['ml'] ) && ! $entry['ml'] ) ) {
		// not in multi-language
		_sp_post_meta_do_entry_html_field( $entry, $post_id );
	} else {
		// multi-language is enabled & available
		foreach( $sp_config['languages']['enabled'] as $l ) {
			echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $l ) . '">';
			_sp_post_meta_do_entry_html_field( $entry, $post_id, $l );
			echo '</div>';
		}
		echo '<input name="' . $entry['id'] . '[ml]" type="hidden" value="1" />';
	}
	echo '</div>';

	// entry description
	if ( isset( $entry['desc'] ) && ! empty( $entry['desc'] ) )
		printf( '<span class="sp-cm-one-desc">%s</span>', $entry['desc'] );

	echo '<div class="clearfix"></div>';
	echo '</div>';

}

/** a post meta field HTML output */
function _sp_post_meta_do_entry_html_field( $entry, $post_id, $lang = '' ) {
	$id = $entry['id'] . ( ! empty( $lang ) ? '['.$lang.']' : '' );
	$multiple = isset( $entry['multiple'] ) && $entry['multiple'];
	$value = sp_pm( $post_id, $entry['id'], $lang );
	$std = isset( $entry['std'] ) ? $entry['std'] : '';
	$value = ( ! $multiple && empty( $value ) ) ? $std : $value;
	$choices = isset( $entry['choices'] ) ? $entry['choices'] : array();
	switch ( $entry['type'] ) {
		case 'group':
			$fields = $entry['fields'];
			$single_title = $entry['single_title'];
			if ( is_array( $value ) && $value )
				foreach ( $value as $k => $v ) {
					echo '<div class="sp-cm-multi-one-group">';
					printf( '<span class="sp-cm-multi-one-singletitle">%s</span>', $single_title );
					echo '<div class="sp-cm-multi-one-singlecontent">';
					foreach( $fields as $f ) {
						$multiple_nested = isset( $f['multiple'] ) && $f['multiple'];
						__sp_custom_meta_do_entry_html_field(
							$id.'['.$k.']'.'['.$f['id'].']',
							$f['type'],
							$multiple_nested,
							( sizeof( $v ) && isset( $v[$f['id']] ) ) ? $v[$f['id']] : '',
							isset( $f['std'] ) ? $f['std'] : '',
							array( 'is_nested' => $multiple_nested, 'nest_name' => $f['title'],
								'choices' => isset( $f['choices'] ) ? $f['choices'] : array() ) );
					}
					echo '</div>';
					echo '</div>';
				}
			echo '<div class="sp-cm-multi-one-def">';
			printf( '<span class="sp-cm-multi-one-singletitle">%s</span>', $single_title );
			echo '<div class="sp-cm-multi-one-singlecontent">';
			foreach( $fields as $f ) {
				$multiple_nested = isset( $f['multiple'] ) && $f['multiple'];
				__sp_custom_meta_do_entry_html_field(
					$id.'[SP_SERIAL_ID]'.'['.$f['id'].']',
					$f['type'],
					$multiple_nested,
					'',
					isset( $f['std'] ) ? $f['std'] : '',
					array( 'is_nested' => $multiple_nested, 'nest_name' => $f['title'],
						'choices' => isset( $f['choices'] ) ? $f['choices'] : array() ) );
			}
			echo '</div>';
			echo '</div>';
			break;
		default:
			__sp_custom_meta_do_entry_html_field( $id, $entry['type'], $multiple, $value, $std,
				array( 'choices' => $choices ) );
	}
}

/** save available post meta to current editing post */
function _sp_post_meta_save_post_handler( $post_id ) {
	global $sp_config;
	if ( isset( $sp_config['post-custom-meta']['boxes'] ) && $sp_config['post-custom-meta']['boxes'] ) {
		foreach( $sp_config['post-custom-meta']['boxes'] as $box ) {
			if ( _sp_post_meta_can_be_added( $box['cond'], $post_id ) )
				if ( isset( $box['fields'] ) && sizeof( $box['fields'] ) )
					foreach( $box['fields'] as $f ) {
						$data = isset( $_POST[$f['id']] ) ? $_POST[$f['id']] : '';
						// filter magic quotes
						if ( get_magic_quotes_gpc() )
							$data = stripslashes_deep( $data );
						// write datebase
						update_post_meta( $post_id, '_'.$f['id'], $data );
					}
		}
	}
}
add_action( 'save_post', '_sp_post_meta_save_post_handler' );

function _sp_post_meta_enqueue_assets_backend() {

	global $pagenow;
	if ( 'post.php' != $pagenow )
		return;

	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'sp.post-custom-meta', SP_INCLUDES_URI . '/post-custom-meta/sp.post-custom-meta.back-end.css', array(), false, 'screen' );
	wp_enqueue_script( 'sp.post-custom-meta', SP_INCLUDES_URI . '/post-custom-meta/sp.post-custom-meta.back-end.js', array( 'jquery' ), false, true );

}
add_action( 'admin_enqueue_scripts', '_sp_post_meta_enqueue_assets_backend' );


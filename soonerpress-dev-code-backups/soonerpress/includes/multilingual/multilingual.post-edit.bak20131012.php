<?php


function _sp_ml_add_meta_boxes( $post_type, $post ) {
	global $sp_config;
	// do not show multilanguage meta box if not enabled in current post type
	if( isset( $sp_config['multilingual']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['multilingual']['post_type'] ) )
			return false;
	add_meta_box( '_sp_ml_metabox', __( 'Multilingual', 'sp' ), '_sp_ml_do_metabox', $post_type,
					'side', 'default' );
}
add_action( 'add_meta_boxes', '_sp_ml_add_meta_boxes', 10, 2 );

function _sp_ml_do_metabox( $post ) {
	global $sp_config;
	echo '<div id="sp-ml-post-edit-metabox">';
	echo '<h4>' . __( 'Languages Selector:', 'sp' ) . '</h4>';
	echo '<ul class="sp-ml-lang-tabs-custom" id="sp-pe-multilingual-selector">';
	foreach( $sp_config['multilingual']['enabled'] as $k => $l ) {
		printf( '<li><a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" />%s</a></li>',
			esc_attr( $sp_config['multilingual']['names'][$l] ),
			esc_attr( $l ),
			'button sp-ml-lang-tab-' . $l,
			esc_attr( SP_INC_URI . '/multilingual/images/flags/' . $sp_config['multilingual']['flags'][$l] ),
			esc_attr( $l ),
			'&nbsp;&nbsp;' . esc_html( $sp_config['multilingual']['names'][$l] )
		);
	}
	echo '</ul></div>';
}

function _sp_ml_post_edit_fields() {
	global $sp_config, $post;
	$post_type = get_post_type( $post );
	// do not add multilanguage fields if not enabled in current post type
	if( isset( $sp_config['multilingual']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['multilingual']['post_type'] ) )
			return false;
	foreach( $sp_config['multilingual']['enabled'] as $l ) {
		if( $l == $sp_config['multilingual']['main_stored'] ) continue;
		$post_title   = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_title',   $l ) : '' );
		$post_content = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_content', $l ) : '' );
		$post_excerpt = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_excerpt', $l ) : '' );
		// post title field
		if ( post_type_supports( $post_type, 'title' ) ) {
			echo '<div class="sp-pe-one-field-post_title-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<input type="text" name="post_title'.SP_META_LANG_PREFIX.$l.'" id="post_title'.SP_META_LANG_PREFIX.$l.'" size="30" value="'.esc_attr( $post_title ).'" autocomplete="off" />';
			echo '</div>';
		}
		// post content field
		if ( post_type_supports( $post_type, 'editor' ) ) {
			echo '<div class="sp-pe-one-field-post_content-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			wp_editor( $post_content, 'post_content'.SP_META_LANG_PREFIX.$l, array(
				'textarea_name' => 'post_content'.SP_META_LANG_PREFIX.$l,
				'dfw' => true,
				'tabfocus_elements' => 'insert-media-button,save-post',
				'editor_height' => 360,
			) );
			echo '</div>';
		}
		// post excerpt field
		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			echo '<div class="sp-pe-one-field-post_excerpt-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
			echo '<textarea rows="1" cols="40" name="post_excerpt'.SP_META_LANG_PREFIX.$l.'" id="post_excerpt'.SP_META_LANG_PREFIX.$l.'">' . esc_textarea( $post_excerpt ) . '</textarea>';
			echo '</div>';
		}
	}
}
add_action( 'edit_form_after_editor', '_sp_ml_post_edit_fields' );

function sp_ml_ext_post_field( $post_id, $field, $lang = '' ) {
	if( empty( $lang ) )
		$lang = sp_ml_lang();
	$post = get_post( intval( $post_id ) );
	if( $post && in_array( $field, array( 'post_title', 'post_content', 'post_excerpt' ) ) ) {
		global $sp_config;
		if( $sp_config['multilingual']['main_stored'] == $lang )
			return $post->$field;
		else
			return get_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang, true );
	}
	return null;
}

function _sp_ml_save_post( $post_id ) {
	global $sp_config;
	$post_type = get_post_type( $post_id );
	if( isset( $sp_config['multilingual']['post_type'] ) )
		if( ! in_array( $post_type, (array) $sp_config['multilingual']['post_type'] ) )
			return false;
	foreach( $sp_config['multilingual']['enabled'] as $l ) {
		// ignore the language main stored in `post` table
		if( $l == $sp_config['multilingual']['main_stored'] ) continue;
		$post_title_tmp   = ( isset( $_POST['post_title'.SP_META_LANG_PREFIX.$l]   ) ? $_POST['post_title'.SP_META_LANG_PREFIX.$l]   : '' );
		$post_content_tmp = ( isset( $_POST['post_content'.SP_META_LANG_PREFIX.$l] ) ? $_POST['post_content'.SP_META_LANG_PREFIX.$l] : '' );
		$post_excerpt_tmp = ( isset( $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] ) ? $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] : '' );
		// write datebase
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_title'.SP_META_LANG_PREFIX.$l,   $post_title_tmp   );
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_content'.SP_META_LANG_PREFIX.$l, $post_content_tmp );
		update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_excerpt'.SP_META_LANG_PREFIX.$l, $post_excerpt_tmp );
	}
}
add_action( 'save_post', '_sp_ml_save_post' );


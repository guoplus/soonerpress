<?php
/**
 * Post Custom Meta module API
 *
 * @package SoonerPress
 * @subpackage Post_Custom_Meta
 */


/** get post custom meta */
function sp_pm( $key, $post_id = 0, $locale_code = '' ) {
	if ( intval( $post_id ) <= 0 ) {
		global $post;
		if ( ! isset( $post->ID ) )
			$post_id = $post->ID;
		else
			return null;
	}
	return get_post_meta( $post_id, apply_filters( 'sp_pm_meta_key', SP_CUSTOM_META_PREFIX . $key, $post_id, $locale_code ), true );
}


class SP_Post_Custom_Meta extends SP_Module {

	var $pm_column_current_type = '';

	function __construct() {
		$this->dc = array(
			'boxes' => array(),
		);
		$this->init('post-custom-meta');
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
		add_action( 'save_post'     , array( $this, 'admin_save_post_meta' ) );
		add_action( 'admin_init'    , array( $this, 'display_column_init' ) );
	}

	/** walk each post meta box and add to WordPress post edit */
	function add_meta_boxes( $post_type, $post ) {
		if ( isset( $this->c['boxes'] ) && $this->c['boxes'] ) {
			foreach ( $this->c['boxes'] as $box ) {
				// add meta box to edit form
				if ( $this->box_can_be_added( $box['cond'], $post->ID ) )
					add_meta_box( $box['id'], $box['title'], array( $this, 'do_box_html' ), get_post_type( $post ),
						'advanced', 'default', $box );
			}
		}
	}

	/** check if a post meta box is available for the specified post */
	function box_can_be_added( $cond, $post_id ) {
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
	function do_box_html( $post, $metabox ) {
		$box = $metabox['args'];
		$ml = isset( $metabox['args']['ml'] ) ? $metabox['args']['ml'] : true;
		echo '<div class="sp-pm-box-wrap">';
		if ( isset( $box['fields'] ) && $box['fields'] )
			foreach ( $box['fields'] as $field )
				$this->do_entry_html( $field, $ml, $post->ID );
		echo '</div>';
	}

	/** a post meta entry HTML output */
	function do_entry_html( $entry, $is_ml, $post_id ) {

		echo '<div class="sp-cm-one sp-cm-one-t-' . $entry['type'] . '">';

		// entry title
		printf( '<span class="sp-cm-one-name">%s</span>', apply_filters( 'sp_pm_one_name', $entry['title'], ( $is_ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );

		// entry field
		$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] ) || ( 'group' == $entry['type'] );
		echo '<div class="sp-cm-one-field' . ( $multiple ? ' sp-cm-one-field-multiple' : '' ) . '">';
		if ( sp_module_enabled( 'multilingual' ) && $is_ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
			// multilingual is enabled & available
			foreach ( sp_get_enabled_languages_ids() as $locale_code ) {
				echo '<div class="sp-cm-one-field-l sp-cm-one-field-l-' . esc_attr( $locale_code ) . '">';
				$this->do_entry_html_field( $entry, $post_id, $locale_code );
				echo '</div>';
			}
		} else {
			// not in multilingual
			echo '<div class="sp-cm-one-field-content">';
			$this->do_entry_html_field( $entry, $post_id );
			echo '</div>';
		}
		echo '</div>';

		// entry description
		if ( isset( $entry['desc'] ) && ! empty( $entry['desc'] ) )
			printf( '<span class="sp-cm-one-desc">%s</span>', $entry['desc'] );

		echo '<div class="clearfix"></div>';
		echo '</div>';

	}

	/** a post meta field HTML output */
	function do_entry_html_field( $entry, $post_id, $locale_code = '' ) {
		$value = sp_pm( $entry['id'], $post_id, $locale_code );
		if ( '' !== $value ) // a '' will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_CUSTOM_META_PREFIX . $entry['id'] . ( ! empty( $locale_code ) ? SP_META_LANG_PREFIX . $locale_code : '' );
		switch ( $entry['type'] ) {
			case 'group':
				$fields = $entry['fields'];
				// parse unspecified entry options
				$entry = wp_parse_args( $entry, array(
					'row_title' => null, 'row_name_refer_to' => null, 'expanded_default' => false,
				) );
				// walk existing data
				if ( isset( $entry['value'] ) && is_array( $entry['value'] ) && $entry['value'] )
					foreach ( $entry['value'] as $k => $value ) {
						printf( '<div class="sp-cm-multi-one-group" data-expanded_default="%s" data-row_name_refer_to="%s">',
							( $entry['expanded_default'] ? '1' : '0' ), esc_attr( $entry['row_name_refer_to'] ) );
						printf( '<div class="sp-cm-multi-one-singletitle">%s</div>', $entry['row_title'] );
						echo '<div class="sp-cm-multi-one-singlecontent">';
						foreach ( $fields as $entry_child ) {
							$multiple_child = isset( $entry_child['multiple'] ) && $entry_child['multiple'];
							$value_child = ( sizeof( $value ) && isset( $value[$entry_child['id']] ) ) ? $value[$entry_child['id']] : '';
							if ( isset( $value_child ) )
								$entry_child['value'] = $value_child;
							$entry_child['id'] = $entry['id'] . '[' . $k . ']' . '[' . $entry_child['id'] . ']';
							printf( '<span class="sp-cm-multi-one-nested-name">%s</span>', esc_html( $entry_child['title'] ) );
							if ( $multiple_child )
								echo '<div class="sp-cm-one-field-nest-multiple"><div class="sp-cm-one-field-nest-multiple-content">';
							new SP_CM_Field ( $entry_child );
							if ( $multiple_child )
								echo '</div></div>';
						}
						echo '</div>';
						echo '</div>';
					}
				// preload add-new field HTML
				printf( '<div class="sp-cm-multi-one-def" data-expanded_default="%s" data-row_name_refer_to="%s">',
					( $entry['expanded_default'] ? '1' : '0' ), esc_attr( $entry['row_name_refer_to'] ) );
				printf( '<div class="sp-cm-multi-one-singletitle">%s</div>', $entry['row_title'] );
				echo '<div class="sp-cm-multi-one-singlecontent">';
				foreach ( $fields as $entry_child ) {
					$multiple_child = isset( $entry_child['multiple'] ) && $entry_child['multiple'];
					$entry_child['id'] = $entry['id'] . '[SP_SERIAL_ID]' . '[' . $entry_child['id'] . ']';
						printf( '<span class="sp-cm-multi-one-nested-name">%s</span>', esc_html( $entry_child['title'] ) );
						if ( $multiple_child )
							echo '<div class="sp-cm-one-field-nest-multiple"><div class="sp-cm-one-field-nest-multiple-content">';
						new SP_CM_Field ( $entry_child );
						if ( $multiple_child )
							echo '</div></div>';
				}
				echo '</div>';
				echo '</div>';
				break;
			default:
				new SP_CM_Field ( $entry );
		}
	}

	/** save available post meta to current editing post */
	function admin_save_post_meta( $post_id ) {
		foreach ( $this->c['boxes'] as $box ) {
			// judge conditions
			if ( $this->box_can_be_added( $box['cond'], $post_id ) ) {
				$ml = isset( $box['ml'] ) ? $box['ml'] : true;
				foreach ( $box['fields'] as $entry ) {
					$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$entry['id']] ) ? $_POST[SP_CUSTOM_META_PREFIX.$entry['id']] : '';
					$meta_key = SP_CUSTOM_META_PREFIX . $entry['id'];
					// write datebase
					update_post_meta( $post_id, $meta_key, $data );
					do_action( 'sp_pm_update_postmeta', $meta_key, $entry, $post_id, $ml );
				}
			}
		}
	}

	function display_column_init() {
		foreach ( $this->c['boxes'] as $box ) {
			$post_types = (array) $box['cond']['post_type'];
			foreach ( $post_types as $post_type ) {
				// add column title to global columns array
				add_filter( 'manage_'.$post_type.'_posts_columns', array( $this, 'display_column_columns' ) );
				// hook function to output HTML
				add_action( 'manage_'.$post_type.'_posts_custom_column', array( $this, 'display_column_custom_column' ), 10, 2 );
			}
		}
	}

	function display_column_columns( $columns ) {
		// get current editing post-type
		$post_type_current = $this->get_current_object_type();
		foreach ( $this->c['boxes'] as $box ) {
			$post_types = (array) $box['cond']['post_type'];
			// box is available for current post-type
			if ( in_array( $post_type_current, $post_types ) )
				foreach ( $box['fields'] as $f )
					if ( isset( $f['display_column'] ) && $f['display_column'] )
						$columns[$f['id']] = $f['title'];
		}
		return $columns;
	}

	function display_column_custom_column( $column_name, $post_id ) {
		// get current editing post-type
		$post_type_current = $this->get_current_object_type();
		foreach ( $this->c['boxes'] as $box ) {
			$post_types = (array) $box['cond']['post_type'];
			// box is available for current post-type
			if ( in_array( $post_type_current, $post_types ) )
				foreach ( $box['fields'] as $f )
					if ( $f['id'] == $column_name ) {
						$display_column_type = $f['display_column'];
						$value = sp_pm( $f['id'], $post_id );
						switch( $display_column_type ) {
							case 'text':
								echo $value;
								break;
							case 'image':
								$image_src = wp_get_attachment_url( intval( $value ), 'full' );
								$image_title = get_the_title( intval( $value ) );
								$image_edit_link = get_edit_post_link( intval( $value ) );
								printf( '<a href="%s" target="_blank"><img src="%s" alt="%s" style="max-width: 150px; max-height: 50px;" /></a>',
									esc_attr( $image_edit_link ), esc_attr( $image_src ), esc_attr( $image_title ) );
								break;
							case 'link':
								printf( '<a href="%s" target="_blank">%s</a>',
									esc_attr( $value ), esc_html( $value ) );
								break;
						}
					}
		}
	}

	function get_current_object_type() {
		global $current_screen;
		$current_object_type = isset( $current_screen->post_type ) ? $current_screen->post_type : '';
		return $current_object_type;
	}

	function enqueue_assets_dashboard() {

		global $pagenow;
		if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
			return;

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

	}

}

new SP_Post_Custom_Meta();


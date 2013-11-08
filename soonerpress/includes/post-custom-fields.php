<?php
/**
 * Post Custom Fields module API
 *
 * @package SoonerPress
 * @subpackage Post_Custom_Fields
 */

if ( ! defined( 'IN_SP' ) ) exit;


/** get post custom meta */
function sp_pm( $post_id, $key, $locale = '' ) {
	return get_post_meta( $post_id, apply_filters( 'sp_pm_meta_key', SP_CUSTOM_FIELDS_PREFIX . $key, $post_id, $locale ), true );
}


class SP_Post_Custom_Fields extends SP_Module {

	var $pm_column_current_type = '';

	function __construct() {
		$this->dc = array(
			'sections' => array(),
		);
		$this->init( 'post-custom-fields' );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
		add_action( 'save_post'     , array( $this, 'admin_save_post_meta' ) );
		add_action( 'admin_init'    , array( $this, 'display_column_init' ) );
	}

	/** walk each post meta box and add to WordPress post edit */
	function add_meta_boxes( $post_type, $post ) {
		if ( isset( $this->c['sections'] ) && $this->c['sections'] ) {
			foreach ( $this->c['sections'] as $box ) {
				// add meta box to edit form
				if ( $this->section_can_be_added( $box['cond'], $post->ID ) )
					add_meta_box( $box['id'], $box['title'], array( $this, 'do_meta_box_html' ), get_post_type( $post ),
						'advanced', 'default', $box );
			}
		}
	}

	/** check if a post meta box is available for the specified post */
	function section_can_be_added( $cond, $post_id ) {
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
	function do_meta_box_html( $post, $metabox ) {
		$box = $metabox['args'];
		$ml_section = isset( $metabox['args']['ml'] ) ? $metabox['args']['ml'] : true;
		echo '<div class="sp-pm-section">';
		if ( isset( $box['fields'] ) && $box['fields'] )
			foreach ( $box['fields'] as $field )
				$this->do_entry_html( $field, $ml_section, $post->ID );
		echo '</div>';
	}

	/** a post meta entry HTML output */
	function do_entry_html( $entry, $is_ml, $post_id ) {

		echo '<div class="sp-pm-field-one sp-cf-one sp-cf-one-t-' . $entry['type'] . '">';

		// entry title
		printf( '<span class="sp-cf-one-name">%s</span>', apply_filters( 'sp_pm_one_name', $entry['title'], ( $is_ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) ) );

		// entry field
		global $_sp_cf_repeatable_field_types;
		$multiple = ( isset( $entry['multiple'] ) && $entry['multiple'] && in_array( $entry['type'], $_sp_cf_repeatable_field_types ) ) || ( 'group' == $entry['type'] );
		echo '<div class="sp-cf-one-field' . ( $multiple ? ' sp-cf-one-field-multiple' : '' ) . '">';
		if ( sp_module_enabled( 'multilingual' ) && $is_ml && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) ) {
			// multilingual is enabled & available
			foreach ( sp_get_enabled_languages_locales() as $locale_code ) {
				echo '<div class="sp-cf-one-field-content sp-cf-one-field-l sp-cf-one-field-l-' . esc_attr( $locale_code ) . '">';
				$this->do_entry_html_field( $entry, $post_id, $locale_code );
				echo '</div>';
			}
		} else {
			// not in multilingual
			echo '<div class="sp-cf-one-field-content">';
			$this->do_entry_html_field( $entry, $post_id );
			echo '</div>';
		}
		echo '</div>';

		// entry description
		if ( isset( $entry['desc'] ) && ! empty( $entry['desc'] ) )
			printf( '<span class="sp-cf-one-desc">%s</span>', $entry['desc'] );

		echo '<div class="clearfix"></div>';
		echo '</div>';

	}

	/** a post meta field HTML output */
	function do_entry_html_field( $entry, $post_id, $locale_code = '' ) {
		$value = sp_pm( $post_id, $entry['id'], $locale_code );
		if ( '' !== $value ) // a '' will be returned if variable was not set
			$entry['value'] = $value;
		$entry['id'] = SP_CUSTOM_FIELDS_PREFIX . $entry['id'] . ( ! empty( $locale_code ) ? SP_META_LANG_PREFIX . $locale_code : '' );
		new SP_Custom_Fields_Field ( $entry );
	}

	/** save available post meta to current editing post */
	function admin_save_post_meta( $post_id ) {
		foreach ( $this->c['sections'] as $section ) {
			// judge conditions
			if ( $this->section_can_be_added( $section['cond'], $post_id ) ) {
				$ml_section = isset( $section['ml'] ) ? $section['ml'] : true;
				foreach ( $section['fields'] as $entry ) {
					$meta_key = SP_CUSTOM_FIELDS_PREFIX . $entry['id'];
					if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] ) ) {
						// write datebase
						update_post_meta( $post_id, $meta_key, $_POST[SP_CUSTOM_FIELDS_PREFIX.$entry['id']] );
					}
					do_action( 'sp_pm_update_postmeta', $meta_key, $entry, $post_id, $ml_section );
				}
			}
		}
	}

	function display_column_init() {
		foreach ( $this->c['sections'] as $box ) {
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
		foreach ( $this->c['sections'] as $box ) {
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
		foreach ( $this->c['sections'] as $section ) {
			$post_types = (array) $section['cond']['post_type'];
			// section is available for current post-type
			if ( in_array( $post_type_current, $post_types ) )
				$ml_section = isset( $metabox['args']['ml'] ) ? $metabox['args']['ml'] : true;
				foreach ( $section['fields'] as $entry )
					if ( $entry['id'] == $column_name ) {
						$display_column_type = $entry['display_column'];
						if ( sp_module_enabled( 'multilingual' ) && $ml_section && ( ! isset( $entry['ml'] ) || ( isset( $entry['ml'] ) && $entry['ml'] ) ) )
							$locale = sp_lang();
						else
							$locale = null;
						$value = sp_pm( $post_id, $entry['id'], $locale );
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

new SP_Post_Custom_Fields();


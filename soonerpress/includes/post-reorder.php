<?php
/**
 * Post Re-order module API
 *
 * @package SoonerPress
 * @subpackage Post_Re-order
 */

if ( ! defined( 'IN_SP' ) ) exit;


class SP_PO_Reorder_Walker extends Walker {

	var $db_fields = array( 'parent' => 'post_parent', 'id' => 'ID' );

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output ) {

		$db_fields_id = $this->db_fields['id'];

		$this->start_el( $output, $element, $depth, $args );

		$output .= sprintf( '<div class="sp-po-reorder-item-info">'.
				'<span class="sp-po-item-title">%s</span>'.
				'<span class="sp-po-item-id">ID: %d</span>'.
				'<span class="sp-po-item-date">Date: %s</span>'.
				'<span class="sp-po-item-editlink"><a href="%s" target="_blank">%s</a></span>'.
				'</div>',
			esc_html( get_the_title( $element->ID ) ),
			$element->ID,
			date( 'Y-m-d', strtotime( $element->post_date ) ),
			get_edit_post_link( $element->ID ),
			__( 'Edit', 'sp' )
		);

		if ( isset( $children_elements[$element->$db_fields_id] ) )
			foreach ( $children_elements[$element->$db_fields_id] as $child_element ) {
				$this->start_lvl( $output, $depth, $args );
				$this->display_element( $child_element, $children_elements, $max_depth, $depth, $args, $output );
				$this->end_lvl( $output, $depth, $args );
			}

		$this->end_el( $output, $element, $depth, $args );

	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<ul>';
	}

	function end_lvl( &$output, $depth = 0, $args = array() )  {
		$output .= '</ul>';
	}

	function start_el( &$output, $element, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$db_fields_id = $this->db_fields['id'];
		$output .= '<li id="post-'.$element->$db_fields_id.'">';
	}

	function end_el( &$output, $element, $depth = 0, $args = array() ) {
		$output .= '</li>';
	}

}


class SP_Post_Reorder extends SP_Module {

	var $embedded_post_type = array();

	function __construct() {
		$this->dc = array(
			'page' => array(
				'menu_mode' => 'independent',
			),
		);
		$this->init( 'post-reorder' );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_save_reorder_data' ) );
		add_filter( 'the_posts', array( $this, 'sort_posts' ), 10, 2 );
	}

	// ==================== admin menu ====================

	function add_admin_menu() {
		foreach ( $this->c as $post_type => $settings ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( $post_type_object ) {
				$menu_mode = $settings['menu_mode'];
				if ( 'independent' == $menu_mode ) {
					$page_title = $post_type_object->label . ' ' . __( 'Re-Order', 'sp' );
					$menu_title = $post_type_object->label . ' ' . __( 'Re-Order', 'sp' );
					$capability = 'edit_posts';
					$menu_slug = 'reorder_post_type_' . $post_type;
					if ( 'post' == $post_type )
						$parent_slug = 'edit.php';
					else if ( 'attachment' == $post_type )
						$parent_slug = 'upload.php';
					else
						$parent_slug = 'edit.php?post_type=' . $post_type;
					add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array( $this, 'independent_reorder_page_html' ) );
				} elseif ( 'embedded' == $menu_mode ) {
					$this->embedded_post_type[] = $post_type;
				}
			}
		}
	}

	function independent_reorder_page_html() {
		$page_title = get_admin_page_title();
		$post_type = str_replace( 'reorder_post_type_', null, $_GET['page'] );
		$post_type_object = get_post_type_object( $post_type );
		if ( $post_type_object ) :
			$reorder_type = ( isset( $_GET['sp_po_reorder_type'] ) ? $_GET['sp_po_reorder_type'] : 'archive' );
			// items filter
			$query_args = array(
				'post_type' => $post_type,
				'orderby' => 'menu_order', 'order' => 'ASC',
				'nopaging' => true,
			);
			$reorder_type = isset( $_GET['sp_po_reorder_type'] ) ? $_GET['sp_po_reorder_type'] : 'archive';
			if ( 'archive' != $reorder_type ) {
				$taxonomy_name = str_replace( 'taxonomy_', null, $reorder_type );
				$term_id = intval( $_GET[$reorder_type] );
				$query_args['tax_query'][] = array(
					'taxonomy' => $taxonomy_name,
					'field' => 'id',
					'terms' => $term_id
				);
			}
			$query_tmp = new WP_Query( $query_args );
		?>
		<div class="wrap sp-wrap">

			<div id="icon-edit" class="icon32"><br></div>
			<h2><?php echo esc_html( $page_title ); ?></h2>

			<?php sp_msg( 'dashboard' ); ?>

			<h3><?php _e( 'Contents Filter', 'sp' ); ?></h3>

			<form id="sp-po-filters-form" action="<?php echo esc_attr( admin_url( 'edit.php' ) ); ?>" method="get">
				<input name="post_type" type="hidden" value="<?php echo esc_attr( $post_type ); ?>" />
				<input name="page" type="hidden" value="<?php echo esc_attr( $_GET['page'] ); ?>" />
				<label><input name="sp_po_reorder_type" type="radio" value="archive"<?php checked( 'archive', $reorder_type ); ?> /> <?php _e( 'Archive', 'sp' ); ?></label>
		<?php
			$taxonomies = get_object_taxonomies( $post_type );
			foreach ( $taxonomies as $_taxonomy_name ) {
				$_taxonomy = get_taxonomy( $_taxonomy_name );
				$terms_tmp = get_terms( $_taxonomy_name, array( 'hide_empty' => false ) );
		?>
				<label><input name="sp_po_reorder_type" type="radio" value="taxonomy_<?php echo esc_attr( $_taxonomy_name ); ?>"<?php checked( 'taxonomy_'.$_taxonomy_name, $reorder_type ); disabled( (boolean) $terms_tmp, false ); ?> /> <?php echo esc_html( $_taxonomy->label ); ?>
		<?php
				if ( $terms_tmp ) :
		?>
				<select name="taxonomy_<?php echo esc_attr( $_taxonomy_name ); ?>">
		<?php
					foreach ( $terms_tmp as $_term ) {
		?>
							<option value="<?php echo $_term->term_id; ?>"<?php selected( ( isset( $_GET['taxonomy_'.$_taxonomy_name] ) ? $_GET['taxonomy_'.$_taxonomy_name] : null ), $_term->term_id ); ?>><?php echo esc_html( $_term->name ); ?></option>
		<?php
					}
		?>
				</select>
		<?php
				else :
		?>
					<i><?php _e( 'No terms found.', 'sp' ); ?></i>
		<?php
				endif;
		?>
				</label>
		<?php
			} // $taxonomies
		?>
				<p class="submit"><input type="submit" class="button" value="<?php echo esc_attr( __( 'Filter', 'sp' ) ); ?>" /></p>
			</form>

			<h3><?php _e( 'Re-order Form', 'sp' ); ?></h3>

			<form id="sp-po-reorder" action="" method="post">
				<div id="sp-po-reorder-warp">
					<ul>
		<?php
			$reorder_walker = new SP_PO_Reorder_Walker();
			echo $reorder_walker->walk( $query_tmp->posts, 999 );
		?>
					</ul>
				</div>
				<?php sp_output_url_query_vars_form(); ?>
				<input name="sp_po_reorder_data" type="hidden" />
				<input name="action" type="hidden" value="sp_po_save_reorder_data" />
				<?php submit_button( __( 'Save Changes', 'sp' ) ); ?>
			</form>

		</div>
		<?php
		endif; // $post_type_object
	}

	/** saving order data */
	function admin_save_reorder_data() {
		if ( is_admin() && isset( $_POST['action'] ) && 'sp_po_save_reorder_data' == $_POST['action'] ) {
			$reorder_data = $_POST['sp_po_reorder_data'];
			$reorder_type = isset( $_POST['sp_po_reorder_type'] ) ? $_POST['sp_po_reorder_type'] : 'archive';
			$post_type = $_POST['post_type'];
			$post_type_object = get_post_type_object( $post_type );
			wp_parse_str( $reorder_data, $reorder_data );
			if ( 'archive' == $reorder_type ) {
				$i = 1;
				foreach ( $reorder_data['post'] as $post_id => $parent_id ) {
					$post_args = array( 'ID' => $post_id, 'menu_order' => $i );
					if ( $post_type_object->hierarchical ) {
						if ( intval( $parent_id ) <= 0 )
							$parent_id = 0;
						$post_args['post_parent'] = $parent_id;
					}
					wp_update_post( $post_args );
					$i ++;
				}
			} else {
				$taxonomy_name = str_replace( 'taxonomy_', null, $reorder_type );
				$term_id = intval( $_POST[$reorder_type] );
				$reorder_data_ids = array_keys( $reorder_data['post'] );
				$this->save_reorder_data_term( $term_id, $reorder_data_ids );
				clean_term_cache( $term_id, $taxonomy_name, true );
			}
			sp_msg_add( __( 'Re-order data saved.', 'sp' ) );
		}
	}

	private function save_reorder_data_term( $term_id, $reorder_data ) {
		return update_option( SP_OPTION_POST_ORDER_DATA_PREFIX . 'term_' . $term_id, $reorder_data );
	}

	private function get_reorder_data_term( $term_id ) {
		return get_option( SP_OPTION_POST_ORDER_DATA_PREFIX . 'term_' . $term_id );
	}

	/** sort posts by custom order for output */
	function sort_posts( $posts, $query ) {
		// do not sort if not order by 'menu_order'
		if ( ! isset( $query->query_vars['orderby'] ) || ( isset( $query->query_vars['orderby'] ) && 'menu_order' != $query->query_vars['orderby'] ) )
			return $posts;
		$tax_queries = $query->tax_query->queries;
		if ( sizeof( $tax_queries ) ) {
			$tax_query = reset( $tax_queries );
			if ( 1 == sizeof( $tax_query['terms'] ) && 'IN' == strtoupper( $tax_query['operator'] ) ) {
				$posts_tmp = array();
				$term = get_term_by( $tax_query['field'], $tax_query['terms'][0], $tax_query['taxonomy'] );
				$sorted_ids = $this->get_reorder_data_term( $term->term_id );
				if ( null != $sorted_ids && sizeof( $sorted_ids ) )
					foreach ( $sorted_ids as $_post_id ) {
						foreach ( $posts as $k => $_post ) {
							if ( $_post_id == $_post->ID ) {
								array_push( $posts_tmp, $_post );
								unset( $posts[$k] );
							}
						}
					}
				return array_merge( $posts_tmp, $posts );
			}
		}
		return $posts;
	}

	// ==================== enqueue scripts and stylesheets ====================

	function enqueue_assets_dashboard() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-nested-sortable-addon' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

		wp_localize_script( 'sp.' . $this->slug . '.dashboard', 'sp_post_reorder', array(
			'l10n' => array(
				're_order' => __( 'Re-order', 'sp' ),
				're_order_cancel' => __( 'Cancel Re-order', 'sp' ),
				're_order_save' => __( 'Save Re-order', 'sp' ),
			),
			'embedded_post_type' => $this->embedded_post_type,
		) );

	}

}

new SP_Post_Reorder();


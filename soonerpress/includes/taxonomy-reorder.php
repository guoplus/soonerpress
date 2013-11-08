<?php
/**
 * Taxonomy Re-order module API
 *
 * @package SoonerPress
 * @subpackage Taxonomy_Re-order
 */

if ( ! defined( 'IN_SP' ) ) exit;


class SP_TO_Reorder_Walker extends Walker {

	var $db_fields = array( 'parent' => 'parent', 'id' => 'term_id' );

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output ) {

		$db_fields_id = $this->db_fields['id'];

		$this->start_el( $output, $element, $depth, $args );

		$output .= sprintf( '<div class="sp-to-reorder-item-info">'.
				'<span class="sp-to-item-title">%s</span>'.
				'<span class="sp-to-item-id">ID: %d</span>'.
				'<span class="sp-to-item-editlink">%s</span>'.
				'</div>',
			esc_html( $element->name ),
			$element->term_id,
			edit_term_link( __( 'Edit', 'sp' ), null, null, $element, false )
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
		$output .= '<li id="tag-'.$element->$db_fields_id.'">';
	}

	function end_el( &$output, $element, $depth = 0, $args = array() ) {
		$output .= '</li>';
	}

}


class SP_Taxonomy_Reorder extends SP_Module {

	var $embedded_taxonomy = array();

	function __construct() {
		$this->init( 'taxonomy-reorder' );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'init', array( $this, 'admin_save_reorder_data' ) );
		add_filter( 'get_terms', array( $this, 'sort_terms' ), 10, 3 );
		add_filter( 'get_terms_args', array( $this, 'terms_args' ), 10, 2 );
	}

	// ==================== admin menu ====================

	function add_admin_menu() {
		foreach ( $this->c as $taxonomy_name => $settings ) {
			$taxonomy = get_taxonomy( $taxonomy_name );
			if ( $taxonomy ) {
				$menu_mode = $settings['menu_mode'];
				if ( 'independent' == $menu_mode ) {
					$page_title = $taxonomy->label . ' ' . __( 'Re-Order', 'sp' );
					$menu_title = $taxonomy->label . ' ' . __( 'Re-Order', 'sp' );
					$capability = 'edit_posts';
					$menu_slug = 'reorder_taxonomy_' . $taxonomy_name;
					foreach ( $taxonomy->object_type as $post_type ) {
						if ( 'post' == $post_type )
							$parent_slug = 'edit.php';
						else if ( 'attachment' == $post_type )
							$parent_slug = 'upload.php';
						else
							$parent_slug = 'edit.php?post_type=' . $post_type;
						add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array( $this, 'independent_reorder_page_html' ) );
					}
				} elseif ( 'embedded' == $menu_mode ) {
					$this->embedded_taxonomy[] = $taxonomy_name;
				}
			}
		}
	}

	function independent_reorder_page_html() {
		$page_title = get_admin_page_title();
		$taxonomy_name = str_replace( 'reorder_taxonomy_', null, $_GET['page'] );
		$taxonomy = get_taxonomy( $taxonomy_name );
		if ( ! $taxonomy || is_wp_error( $taxonomy ) )
			return;
		$terms = get_terms( $taxonomy_name, array( 'hide_empty' => false, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		?>
		<div class="wrap sp-wrap">

			<div id="icon-edit" class="icon32"><br></div>
			<h2><?php echo esc_html( $page_title ); ?></h2>

			<?php sp_msg( 'dashboard' ); ?>

			<h3><?php _e( 'Re-order Form', 'sp' ); ?></h3>

			<form id="sp-to-reorder" action="" method="post">
				<div id="sp-to-reorder-warp">
					<ul>
		<?php
			$reorder_walker = new SP_TO_Reorder_Walker();
			echo $reorder_walker->walk( $terms, 999 );
		?>
					</ul>
				</div>
				<?php sp_output_url_query_vars_form(); ?>
				<input name="taxonomy" value="<?php echo esc_attr( $taxonomy_name ); ?>" type="hidden" />
				<input name="sp_to_reorder_data" type="hidden" />
				<input name="action" value="sp_to_save_reorder_data" type="hidden" />
				<?php submit_button( __( 'Save Changes', 'sp' ) ); ?>
			</form>

		</div>
		<?php
	}

	/** saving order data */
	function admin_save_reorder_data() {
		if ( is_admin() && isset( $_POST['action'] ) && 'sp_to_save_reorder_data' == $_POST['action'] ) {
			$reorder_data = $_POST['sp_to_reorder_data'];
			$taxonomy_name = $_POST['taxonomy'];
			wp_parse_str( $reorder_data, $reorder_data );
			if ( is_taxonomy_hierarchical( $taxonomy_name ) ) {
				foreach ( $reorder_data['tag'] as $term_id => $parent_id ) {
					if ( intval( $parent_id ) <= 0 )
						$parent_id = 0;
					if ( term_exists( $term_id, $taxonomy_name ) )
						wp_update_term( $term_id, $taxonomy_name, array( 'parent' => $parent_id ) );
				}
			}
			$reorder_data_ids = array_keys( $reorder_data['tag'] );
			$this->save_reorder_data( $taxonomy_name, $reorder_data_ids );
			sp_msg_add( __( 'Re-order data saved.', 'sp' ) );
		}
	}

	private function save_reorder_data( $taxonomy, $reorder_data ) {
		return update_option( SP_OPTION_TERM_ORDER_DATA_PREFIX . $taxonomy, $reorder_data );
	}

	private function get_reorder_data( $taxonomy ) {
		return get_option( SP_OPTION_TERM_ORDER_DATA_PREFIX . $taxonomy );
	}

	/** sort terms by custom order for output */
	function sort_terms( $terms, $taxonomies, $args ) {
		// do not sort if not order by 'menu_order'
		if ( ! isset( $args['orderby'] ) || ( isset( $args['orderby'] ) && 'menu_order' != $args['orderby'] ) || 'all' != $args['fields'] )
			return $terms;
		if ( 1 == sizeof( $taxonomies ) ) {
			$terms_tmp = array();
			$sorted_ids = $this->get_reorder_data( reset( $taxonomies ) );
			if ( null != $sorted_ids && sizeof( $sorted_ids ) )
				foreach ( $sorted_ids as $_term_id ) {
					foreach ( $terms as $k => $_term ) {
						if ( $_term_id == $_term->term_id ) {
							array_push( $terms_tmp, $_term );
							unset( $terms[$k] );
						}
					}
				}
			return array_merge( $terms_tmp, $terms );
		}
		return $terms;
	}

	function terms_args( $args, $taxonomies ) {
		if ( ! isset( $args['orderby'] ) || ( isset( $args['orderby'] ) && empty( $args['orderby'] ) ) ) {
			$args['orderby'] = 'menu_order';
			$args['order'] = 'ASC';
		}
		return $args;
	}

	// ==================== enqueue scripts and stylesheets ====================

	function enqueue_assets_dashboard() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-nested-sortable-addon' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

		wp_localize_script( 'sp.' . $this->slug . '.dashboard', 'sp_taxonomy_reorder', array(
			'l10n' => array(
				're_order' => __( 'Re-order', 'sp' ),
				're_order_cancel' => __( 'Cancel Re-order', 'sp' ),
				're_order_save' => __( 'Save Re-order', 'sp' ),
			),
			'embedded_taxonomy' => $this->embedded_taxonomy,
		) );

	}

}

new SP_Taxonomy_Reorder();


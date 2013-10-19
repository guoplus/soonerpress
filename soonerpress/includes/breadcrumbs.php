<?php
/**
 * Breadcrumbs module API
 *
 * @package SoonerPress
 * @subpackage Breadcrumbs
 */


function sp_breadcrumbs( $echo = true ) {
	$sp_breadcrumbs = new SP_Breadcrumbs();
	if ( $echo )
		echo $sp_breadcrumbs->get_output();
	else
		return $sp_breadcrumbs->get_output();
}


class SP_Breadcrumbs extends SP_Module {

	function __construct() {
		$this->dc = array(
			'home_text'           => __( 'Home', 'sp' ),
			'separator'           => ' &raquo; ',
			'singular'            => array(),
			'link_before'         => '<span class="bc-link">',
			'link_after'          => '</span>',
			'static_before'       => '<span class="bc-static">',
			'static_after'        => '</span>',
			'home_before'         => '<span class="bc-home">',
			'home_after'          => '</span>',
			'archive_title_class' => 'bc-archive-title',
		);
		$this->init( 'breadcrumbs' );
		$this->c['singular'] = wp_parse_args( $this->c['singular'], array(
			'post' => 'category',
			'page' => 'path',
			'attachment' => 'independent',
		) );
		// process
		$this->breadcrumbs();
	}

	private function breadcrumbs() {
		// home link
		$this->o .= $this->c['home_before'];
		$this->o .= sprintf( '<a href="%s">%s</a>',
			esc_attr( home_url('/') ),
			esc_html( $this->c['home_text'] )
		);
		$this->o .= $this->c['home_after'];
		// archive
		if ( is_search() ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_search();
			$this->wrap_static_after();
		elseif ( get_query_var( 'author' ) ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_author();
			$this->wrap_static_after();
		elseif ( get_query_var( 'day' ) || 8 == strlen( get_query_var( 'm' ) ) ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_daily();
			$this->wrap_static_after();
		elseif ( get_query_var( 'monthnum' ) || 6 == strlen( get_query_var( 'm' ) ) ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_monthly();
			$this->wrap_static_after();
		elseif ( get_query_var( 'year' ) || 4 == strlen( get_query_var( 'm' ) ) ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_yearly();
			$this->wrap_static_after();
		elseif ( is_tax() || is_category() || is_tag() ) :
			$this->o .= $this->c['separator'];
			$this->archive_tax();
		elseif ( is_post_type_archive() ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_post_type();
			$this->wrap_static_after();			
		elseif ( is_archive() ) :
			$this->o .= $this->c['separator'];
			$this->wrap_static_before();
			$this->archive_else();
			$this->wrap_static_after();
		endif;
		// singular
		if ( is_singular() ) :
			$this->o .= $this->c['separator'];
			$this->singular();
		endif;
	}

	private function wrap_static_before() {
		$this->o .= $this->c['static_before'];
	}

	private function wrap_static_after() {
		$this->o .= $this->c['static_after'];
	}

	private function wrap_link_before() {
		$this->o .= $this->c['link_before'];
	}

	private function wrap_link_after() {
		$this->o .= $this->c['link_after'];
	}

	private function archive_search() {
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Search Results for: %s', 'sp' ) ),
			get_search_query() );
	}

	private function archive_author() {
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Author Archives: %s', 'sp' ) ),
			get_the_author_meta( 'display_name', get_query_var( 'author' ) ) );
	}

	private function archive_post_type() {
		$queried_object = get_queried_object();
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( '%s Archives', 'sp' ) ),
			$queried_object->labels->name );
	}

	private function archive_daily() {
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Daily Archives: %s', 'sp' ) ),
			get_the_date() );
	}

	private function archive_monthly() {
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Monthly Archives: %s', 'sp' ) ),
			get_the_date( 'F Y' ) );
	}

	private function archive_yearly() {
		$this->o .= sprintf(
			sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Yearly Archives: %s', 'sp' ) ),
			get_the_date( 'Y' ) );
	}

	private function archive_tax() {
		$queried_object = get_queried_object();
		$taxonomy_name = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;
		$term = get_term( $term_id, $taxonomy_name );
		// output full path if hierarchical
		if ( is_taxonomy_hierarchical( $taxonomy_name ) ) {
			$path = array();
			$this->walk_term_path( $path, $term->term_id, $taxonomy_name );
			// output terms path
			foreach ( array_reverse( $path ) as $_term_id ) {
				$_term = get_term( $_term_id, $taxonomy_name );
				$this->wrap_link_before();
				$this->o .= sprintf( '<a href="%s">%s</a>', get_term_link( $_term ), esc_html( $_term->name ) );
				$this->wrap_link_after();
				$this->o .= $this->c['separator'];
			}
		}
		// output current term
		$this->wrap_static_before();
		$this->o .= esc_html( $term->name );
		$this->wrap_static_after();
	}

	private function archive_else() {
		$this->o .= sprintf( '<span class="%s">%s</span>', esc_attr( $this->c['archive_title_class'] ), __( 'Archives', 'sp' ) );
	}

	private function singular() {
		$current_post_id = get_the_ID();
		$post_type = get_post_type();
		$display_mode = isset( $this->c['singular'][$post_type] ) ? $this->c['singular'][$post_type] : 'independent';
		switch ( $display_mode ) {
			case 'path':
				if ( is_post_type_hierarchical( $post_type ) ) {
					// map parent and grandparent and grand-grandparent
					$path = array();
					$this->walk_post_path( $path, $current_post_id );
					// output post parents
					foreach ( array_reverse( $path ) as $_post_id ) {
						$_post = get_post( $_post_id );
						$this->wrap_link_before();
						$this->o .= sprintf( '<a href="%s">%s</a>', get_permalink( $_post_id ), get_the_title( $_post_id ) );
						$this->wrap_link_after();
						$this->o .= $this->c['separator'];
					}
					// output current post
					$this->wrap_static_before();
					$this->o .= get_the_title( $current_post_id );
					$this->wrap_static_after();
				}
				break;
			case 'independent':
				$this->wrap_static_before();
				$this->o .= get_the_title( $current_post_id );
				$this->wrap_static_after();
				break;
			default: // post type taxonomy
				$taxonomy_name = $this->c['singular'][$post_type];
				if ( taxonomy_exists( $taxonomy_name ) ) {
					$terms = wp_get_object_terms( $current_post_id, $taxonomy_name );
					if ( $terms && sizeof( $terms ) ) {
						$term = reset( $terms );
						if ( is_taxonomy_hierarchical( $taxonomy_name ) ) {
							$path = array( $term->term_id );
							$this->walk_term_path( $path, $term->term_id, $taxonomy_name );
							// output terms path
							foreach ( array_reverse( $path ) as $_term_id ) {
								$_term = get_term( $_term_id, $taxonomy_name );
								$this->wrap_link_before();
								$this->o .= sprintf( '<a href="%s">%s</a>', get_term_link( $_term ), esc_html( $_term->name ) );
								$this->wrap_link_after();
								$this->o .= $this->c['separator'];
							}
						} else {
							$this->wrap_link_before();
							$this->o .= sprintf( '<a href="%s">%s</a>', get_term_link( $term ), esc_html( $term->name ) );
							$this->wrap_link_after();
							$this->o .= $this->c['separator'];
						}
						// output current post
						$this->wrap_static_before();
						$this->o .= get_the_title( $current_post_id );
						$this->wrap_static_after();
					}
				}
		} // {switch}
	}

	private function walk_post_path( &$path, $post_id ) {
		$post = get_post( $post_id );
		if ( $post->post_parent ) {
			array_push( $path, $post->post_parent );
			$this->walk_post_path( $path, $post->post_parent );
		}
	}

	private function walk_term_path( &$path, $term_id, $taxonomy ) {
		$term = get_term( $term_id, $taxonomy );
		if ( $term->parent ) {
			array_push( $path, $term->parent );
			$this->walk_term_path( $path, $term->parent, $taxonomy );
		}
	}

}


<?php
/**
 * Pagination module API
 *
 * @package SoonerPress
 * @subpackage Pagination
 */

if ( ! defined( 'IN_SP' ) ) exit;


function sp_pagination( $echo = true ) {
	$sp_pagination = new SP_Pagination();
	if ( $echo )
		echo $sp_pagination->get_output();
	else
		return $sp_pagination->get_output();
}


class SP_Pagination extends SP_Module {

	function __construct() {
		$this->dc = array(
			'range'                 => 5,
			'first'                 => ' &laquo; ',
			'last'                  => ' &raquo; ',
			'previous'              => ' &lsaquo; ',
			'next'                  => ' &rsaquo; ',
			'previous_extend'       => '...',
			'next_extend'           => '...',
			'before'                => '<div class="pagination">',
			'after'                 => '</div>',
			'show_in_only_one_page' => false,
		);
		$this->init( 'pagination' );
		// hooks
		add_filter( 'previous_posts_link_attributes', array( $this, 'previous_posts_link_attributes' ) );
		add_filter( 'next_posts_link_attributes'    , array( $this, 'next_posts_link_attributes' ) );
		// process
		$this->pagination();
	}

	function previous_posts_link_attributes() {
		return 'class="extend previouspostslink"';
	}

	function next_posts_link_attributes() {
		return 'class="extend nextpostslink"';
	}

	private function pagination() {
		$range = intval( $this->c['range'] );
		global $paged, $wp_query;
		$max_page = $wp_query->max_num_pages;
		if ( ( $max_page <= 1 && ! $this->c['show_in_only_one_page'] ) || is_singular() )
			return;
		$this->o .= $this->c['before'];
		$this->o .= '<span class="pages">Pages: </span>';
		if ( ! $paged ) {
			$paged = 1;
		}
		if ( $paged != 1 ) {
			$this->o .= '<a href="' . get_pagenum_link(1) . '" class="extend first">' . $this->c['first'] . '</a>';
		}
		$this->o .= get_previous_posts_link( $this->c['previous'] );
		if ( $max_page > $range ) {
			if ( $paged < $range ) {
				for ( $i = 1; $i <= ( $range + 1 ); $i ++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if ( $i == $paged )
						$classes[] = 'current';
					$this->o .= sprintf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
				$this->o .= '<span class="extend">' . $this->c['next_extend'] . '</span>';
			} elseif ( $paged >= ( $max_page - ceil( ( $range / 2 ) ) ) ) {
				$this->o .= '<span class="extend">' . $this->c['previous_extend'] . '</span>';
				for ( $i = $max_page - $range; $i <= $max_page; $i ++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if ( $i == $paged )
						$classes[] = 'current';
					$this->o .= sprintf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
			} elseif ( $paged >= $range && $paged < ( $max_page - ceil( ( $range / 2 ) ) ) ) {
				$this->o .= '<span class="extend">' . $this->c['previous_extend'] . '</span>';
				for ( $i = ( $paged - ceil( $range / 2 ) ); $i <= ( $paged + ceil( ( $range / 2 ) ) ); $i ++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if ( $i == $paged )
						$classes[] = 'current';
					$this->o .= sprintf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
				$this->o .= '<span class="extend">' . $this->c['next_extend'] . '</span>';
			}
		} else {
			for ( $i = 1; $i <= $max_page; $i ++ ) {
				$classes = array( 'page' );
				$href = get_pagenum_link($i);
				if ( $i == $paged )
					$classes[] = 'current';
				$this->o .= sprintf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
			}
		}
		$this->o .= get_next_posts_link( $this->c['next'] );
		if ( $paged != $max_page ) {
			$this->o .= '<a href="' . get_pagenum_link($max_page) . '" class="extend last">' . $this->c['last'] . '</a>';
		}
		$this->o .= $this->c['after'];
	}

}


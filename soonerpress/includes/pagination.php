<?php


function sp_pagination( $settings ) {
	global $sp_config;
	$s = wp_parse_args( $settings, array(
		'range' => $sp_config['pagination']['range'],
		'before' => '',
		'after' => '',
	) );
	$range = intval( $s['range'] );
	global $paged, $wp_query;
	if ( ! $max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	if( $max_page > 1 ) {
		echo $s['before'];
		echo '<div class="wp-pagenavi">';
		echo '<span class="pages">Pages: </span>';
		if( ! $paged ) {
			$paged = 1;
		}
		if( $paged != 1 ) {
			echo '<a href="' . get_pagenum_link(1) . '" class="extend first">' . $sp_config['pagination']['first'] . '</a>';
		}
		previous_posts_link( $sp_config['pagination']['previous'] );
		if( $max_page > $range ) {
			if( $paged < $range ) {
				for( $i = 1; $i <= ( $range + 1 ); $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
				echo '<span class="extend">' . $sp_config['pagination']['next_extend'] . '</span>';
			} elseif( $paged >= ( $max_page - ceil( ( $range/2 ) ) ) ) {
				echo '<span class="extend">' . $sp_config['pagination']['previous_extend'] . '</span>';
				for( $i = $max_page - $range; $i <= $max_page; $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
			} elseif( $paged >= $range && $paged < ( $max_page - ceil( ( $range/2 ) ) ) ) {
				echo '<span class="extend">' . $sp_config['pagination']['previous_extend'] . '</span>';
				for( $i = ( $paged - ceil( $range/2 ) ); $i <= ( $paged + ceil( ( $range/2 ) ) ); $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
				echo '<span class="extend">' . $sp_config['pagination']['next_extend'] . '</span>';
			}
		} else {
			for( $i = 1; $i <= $max_page; $i++ ) {
				$classes = array( 'page' );
				$href = get_pagenum_link($i);
				if( $i == $paged )
					$classes[] = 'current';
				printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
			}
		}
		next_posts_link( $sp_config['pagination']['next'] );
		if( $paged != $max_page ) {
			echo '<a href="' . get_pagenum_link($max_page) . '" class="extend last">' . $sp_config['pagination']['last'] . '</a>';
		}
		echo '</div><!-- .wp-pagenavi -->';
		echo $s['after'];
	}
}

function dp_previous_posts_link_attributes() {
	return 'class="previouspostslink"';
}
add_filter( 'previous_posts_link_attributes', 'dp_previous_posts_link_attributes' );

function dp_next_posts_link_attributes() {
	return 'class="nextpostslink"';
}
add_filter( 'next_posts_link_attributes', 'dp_next_posts_link_attributes' );


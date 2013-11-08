<?php
/*
	Template Name: Event Archive
*/
?>
<?php get_header(); ?>

<div id="content">

	<?php if ( sp_module_enabled( 'breadcrumb' ) ) : ?>
	<nav id="breadcrumb">
		<?php sp_breadcrumb(); ?>
	</nav>
	<?php endif; ?>

<?php
	$showposts = get_option( 'posts_per_page' );
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	query_posts( array( 'post_type' => 'event', 'showposts' => $showposts, 'paged' => $paged, 'orderby' => 'post_date', 'order' => 'DESC' ) );
?>

	<div id="events">
	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>
			<div class="event-thumb"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo esc_attr( wp_get_attachment_url( sp_pm( $post->ID, 'event_thumb', sp_lang() ), 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" /></a></div>
			<h2 class="event-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small class="event-meta"><?php printf( __( 'Show on %s', 'sp' ), date( get_option( 'date_format' ), strtotime( sp_pm( $post->ID, 'event_date' ) ) ) ); ?></small>
			<div class="event-excerpt">
				<?php the_excerpt(); ?>
			</div>
			<div class="event-links"><?php _e( 'Links: ', 'sp' ); ?><?php $links_html = array(); foreach ( sp_pm( $post->ID, 'event_links' ) as $l ) { $links_html[] = '<a href="' . esc_attr( $l ) . '" title="' . esc_attr( $l ) . '">' . esc_html( $l ) . '</a>'; } echo implode( ' &bull; ', $links_html ); ?></div>
		</article>

		<?php endwhile; ?>

		<?php if ( sp_module_enabled( 'pagination' ) ) : ?>
		<nav id="pagination">
			<?php sp_pagination(); ?>
		</nav>
		<?php endif; ?>

	<?php else : ?>

		<?php _e( 'Sorry, no posts matched your criteria.', 'sp' ); ?>

	<?php endif; ?>
	</div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

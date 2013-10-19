<?php get_header(); ?>

<div id="main">

<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

	<div class="post-content">
		<?php the_content( __( '(more&hellip;)', 'sp' ) ); ?>
	</div>

	<?php endwhile; ?>

<?php else : ?>

	<?php _e( 'Sorry, no posts matched your criteria.', 'sp' ); ?>

<?php endif; ?>

<?php get_sidebar(); ?>

</div><!-- #main -->

<?php get_footer(); ?>

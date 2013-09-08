<?php get_header(); ?>

<div id="main">

<?php echo sp_ml_html_selector( array( 'type' => 'text' ) ); ?>

<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

	<div class="post-content">
		<?php the_content( __( 'Read more ...', 'sp' ) ); ?>
	</div>

	<?php endwhile; ?>

<?php else : ?>

	<?php _e( 'Sorry, no posts matched your criteria.', 'sp' ); ?>

<?php endif; ?>

</div><!-- #main -->

<?php get_footer(); ?>

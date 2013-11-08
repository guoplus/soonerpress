<?php get_header(); ?>

<div id="content">

	<?php if ( sp_module_enabled( 'breadcrumb' ) ) : ?>
	<nav id="breadcrumb">
		<?php sp_breadcrumb(); ?>
	</nav>
	<?php endif; ?>

	<div id="loop">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>

		<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

		<div class="post-content">
			<?php the_content( __( '(more&hellip;)', 'sp' ) ); ?>
		</div>

		<?php the_taxonomies( array( 'before' => '<div class="post-meta">', 'after' => '</div>' ) ); ?>

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

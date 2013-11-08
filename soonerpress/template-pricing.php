<?php
/*
	Template Name: Pricing Archive
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
	query_posts( array( 'post_type' => 'pricing', 'showposts' => $showposts, 'paged' => $paged, 'orderby' => 'post_date', 'order' => 'DESC' ) );
?>

	<div id="posts">
	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article <?php post_class(); ?>>
			<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small class="post-meta"><?php printf( __( 'Posted on %1$s by %2$s', 'sp' ),
				sprintf( '<time class="date time published updated sc" datetime="%s" title="%s">%s</time> ', get_the_time( 'Y-m-d\TH:i:s.uP' ), get_the_time(), get_the_date() ),
				sprintf( '<a href="%s" class="vcard" target="_blank" rel="author"><span class="fn">%s</span></a> ', esc_attr( get_the_author_meta( 'user_url' ) ), esc_html( get_the_author_meta( 'display_name' ) ) )
			); ?>
			| <?php comments_popup_link( __( 'No Comments', 'sp' ), __( '1 Comment', 'sp' ), __( '% Comments', 'sp' ), '', __( 'Comments off', 'sp' ) ); ?>
			<?php edit_post_link( __( 'Edit', 'sp' ), ' | ', '' ); ?></small>
			<div class="post-content">
				<?php the_content( __( '(more&hellip;)', 'sp' ) ); ?>
			</div>
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

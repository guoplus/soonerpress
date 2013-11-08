<?php
/*
	Template Name: Business Archive
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
	query_posts( array( 'post_type' => 'branch', 'showposts' => $showposts, 'paged' => $paged, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>

	<div id="branches">

		<div id="branches-map-wrap">
			<div id="branches-map"></div>
		</div>

<script type="text/javascript">
;(function($) {
$(document).ready( function() {
	branch_map = new GMaps( {
		'div': '#branches-map',
		'lat': <?php $loc = sp_option( 'page_branches_init_location' ); echo $loc['lat']; ?>,
		'lng': <?php echo $loc['lng']; ?>,
		'zoom': <?php echo sp_option( 'page_branches_init_zoom' ); ?>,
	} );
	$('.hentry.branch.show_on_map').each( function() {
		branch_map.addMarker( {
			lat: $(this).data('lat'),
			lng: $(this).data('lng'),
			title: $(this).find('.branch-title').text(),
			infoWindow: {
				content: '<h3>'+$(this).find('.branch-title').html()+'</h3>'+$(this).find('.branch-info').html()+'<p><small>'+$(this).find('.branch-meta').html()+'</small></p>',
			},
		} );
	} );
} );
})(jQuery);
</script>

	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php $loc = sp_pm( $post->ID, 'branch_address', sp_lang() );
			$post_class[] = has_term( 'show-on-map', 'branch_property' ) ? 'show_on_map' : null;
			$post_class[] = has_term( 'featured', 'branch_property' ) ? 'featured' : null; ?>
		<article <?php post_class( $post_class ); ?> data-lat="<?php echo esc_html( $loc['lat'] ); ?>" data-lng="<?php echo esc_html( $loc['lng'] ); ?>">
			<h2 class="branch-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="branch-info">
				<?php the_content(); ?>
			</div>
			<small class="branch-meta"><?php _e( 'Address: ', 'sp' ); ?><span class="branch-address"><?php echo esc_html( $loc['address'] ); ?></span></small>
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

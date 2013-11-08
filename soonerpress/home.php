<?php
/*
	Template Name: Homepage
*/
?>
<?php get_header(); ?>

<div id="content">

	<?php $query_tmp = new WP_Query( array( 'post_type' => 'slide', 'nopaging' => true, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
	<div id="home-slider">
		<?php if ( $query_tmp->post_count >= 1 ) : ?>
		<ul class="slides">
			<?php foreach ( $query_tmp->posts as $s ) : ?>
			<li>
				<div class="slide-text">
					<h3 class="slide-title"><?php echo esc_html( sp_pm( $s->ID, 'slide_title', sp_lang() ) ); ?></h3>
					<div class="slide-description"><?php echo wpautop( sp_pm( $s->ID, 'slide_description', sp_lang() ) ); ?></div>
				</div>
				<img src="<?php echo esc_attr( wp_get_attachment_url( sp_pm( $s->ID, 'slide_image', sp_lang() ), 'full' ) ); ?>" alt="<?php echo esc_attr( sp_pm( $s->ID, 'slide_title', sp_lang() ) ); ?>" />
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>


</div>

<?php get_footer(); ?>

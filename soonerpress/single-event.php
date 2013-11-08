<?php get_header(); ?>

<div id="content">

	<?php if ( sp_module_enabled( 'breadcrumb' ) ) : ?>
	<nav id="breadcrumb">
		<?php sp_breadcrumb(); ?>
	</nav>
	<?php endif; ?>

	<div id="event">
	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php
		$event_links = sp_pm( $post->ID, 'event_links' );
		$event_sponsors = sp_pm( $post->ID, 'event_sponsors', sp_lang() );
	?>

		<article <?php post_class(); ?>>

			<h2 class="event-title"><?php the_title(); ?></h2>

			<div class="event-banner"><img src="<?php echo esc_attr( wp_get_attachment_url( sp_pm( $post->ID, 'event_image', sp_lang() ), 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" /></div>

			<div class="event-content">
				<?php the_content(); ?>
			</div>

			<div class="event-meta">
				<h3><?php _e( 'Event Info', 'sp' ); ?></h3>
				<ul>
					<li><strong><?php _e( 'Show Date: ', 'sp' ); ?></strong><?php echo sp_pm( $post->ID, 'event_date' ); ?></li>
					<li><strong><?php _e( 'Age Limit: ', 'sp' ); ?></strong><?php echo sp_pm( $post->ID, 'event_age_limit' ); ?>+</li>
				</ul>
			</div>

			<div class="event-links">
				<h3><?php _e( 'Links', 'sp' ); ?></h3>
				<ul>
					<?php foreach ( $event_links as $l ) : ?>
					<li><a href="<?php echo esc_attr( $l ); ?>"><?php echo esc_html( $l ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="event-sponsors">
				<h3><?php _e( 'Sponsors', 'sp' ); ?></h3>
				<ul>
					<?php foreach ( $event_sponsors as $sponsor ) : $sponsor_links = $sponsor['sponsor_links'] ?>
					<li>
						<span class="event-sponsor-logo"><img src="<?php echo esc_attr( wp_get_attachment_url( $sponsor['sponsor_logo_image'], 'full' ) ); ?>" alt="<?php echo esc_attr( $sponsor['sponsor_name'] ); ?>" /></span>
						<?php $links_html = array(); foreach ( $sponsor_links as $l ) {
							$links_html[] = '<a href="' . esc_attr( $l['link_url'] ) . '" title="' . esc_attr( $l['link_url'] ) . '">' . esc_html( $l['link_title'] ) . '</a>';
						} echo implode( ' &bull; ', $links_html ); ?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>

		</article>

		<?php endwhile; ?>

	<?php endif; ?>
	</div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

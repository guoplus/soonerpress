<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta http-equiv="Content-Type" content="<?php echo esc_attr( get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) ); ?>" />

	<meta name="format-detection" content="telephone=no" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div id="all">

	<div id="header">

		<div id="logo"><a href="<?php echo esc_attr( trailingslashit( home_url() ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><img src="<?php echo esc_attr( SP_IMAGES . '/logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a></div>

		<?php sp_nav_menu( 'main-menu', 'main-menu', 'main-menu', 1 ); ?>

	</div><!-- #header -->

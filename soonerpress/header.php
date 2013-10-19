<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta http-equiv="Content-Type" content="<?php echo esc_attr( get_bloginfo( 'html_type' ) . '; charset=' . get_bloginfo( 'charset' ) ); ?>" />

	<meta name="format-detection" content="telephone=no" />

	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div id="all">

	<div id="header">

		<div id="logo"><a href="<?php echo esc_attr( trailingslashit( home_url() ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><img src="<?php echo esc_attr( trailingslashit( SP_IMG ) . 'logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a></div>

		<?php sp_nav_menu( 'main-menu', 'main-menu', 'main-menu', 3 ); ?>

		<?php if ( sp_module_enabled( 'multilingual' ) ) : ?>
		<nav id="languages_selector">
			<?php echo sp_lang_selector( array( 'type' => 'text' ) ); ?>
		</nav>
		<?php endif; ?>

		<?php if ( sp_module_enabled( 'breadcrumbs' ) ) : ?>
		<nav id="breadcrumbs">
			<?php sp_breadcrumbs(); ?>
		</nav>
		<?php endif; ?>

	</div><!-- #header -->

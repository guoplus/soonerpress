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

		<?php $logo_attachment_id = sp_option( 'site_logo', sp_lang() ); $logo_url = wp_get_attachment_url( $logo_attachment_id ); ?>
		<div id="logo"><a href="<?php echo esc_attr( trailingslashit( home_url() ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php if ( ! empty( $logo_url ) ) : ?><img src="<?php echo esc_attr( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /><?php endif; ?></a></div>

		<?php if ( sp_option( 'show_header_nav' ) ) : ?>
		<?php sp_nav_menu( 'main-nav', 'nav-menu', 'main-menu', 0 ); ?>
		<?php endif; ?>

		<div id="header_control">

			<?php sp_nav_menu( 'top-nav', 'nav-top', 'top-menu', 0 ); ?>

			<?php if ( sp_module_enabled( 'multilingual' ) ) : ?>
			<nav id="languages_selector">
				<?php echo sp_lang_selector( array( 'type' => 'text' ) ); ?>
			</nav>
			<?php endif; ?>

		</div>

	</div><!-- #header -->

	<div id="main">

<?php


/** Enqueue Scripts & Styles for Front-end */
function sp_enqueue_scripts_frontend() {

	wp_enqueue_style( 'global',               get_stylesheet_uri(), array(), false, 'screen' );
	wp_enqueue_style( 'global-fonts',         SP_ASSETS . '/font/stylesheet.css', array(), false, 'all' );

	// wp_enqueue_script( 'jquery' );
	sp_enqueue_jquery_own();
	wp_enqueue_script( 'jquery.migrate',      SP_ASSETS . '/jquery.migrate.min.js', array( 'jquery' ), '1.2.1', true );
	wp_enqueue_script( 'global-common',       SP_ASSETS . '/global-common.js', array( 'jquery' ), false, true );
	sp_enqueue_bootstrap_css();
	wp_enqueue_script( 'jquery.colorbox',     SP_ASSETS . '/jquery.colorbox.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'jquery.flexslider',   SP_ASSETS . '/jquery.flexslider.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'jquery.placeholder',  SP_ASSETS . '/jquery.placeholder.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'global',              SP_ASSETS . '/global.js', array( 'jquery' ), false, true );

	if ( is_singular() && comments_open() )
		wp_enqueue_script( 'comment-reply' );

	$params = array(
		'baseurl' => trailingslashit( home_url() ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'tplurl'  => trailingslashit( SP_URI ),
	);
	wp_localize_script( 'global-common', 'sp', $params );

}
add_action( 'wp_enqueue_scripts', 'sp_enqueue_scripts_frontend' );


/** Enqueue Scripts & Styles for Back-end */
function sp_enqueue_scripts_backend() {

	sp_enqueue_fontawesome();
	wp_enqueue_style( 'global-admin',         SP_ASSETS . '/css/global-admin.css', array(), false, 'all' );
	// wp_enqueue_style( 'global-fonts',         SP_ASSETS . '/font/stylesheet.css', array(), false, 'all' );
	wp_enqueue_script( 'jquery' );
	sp_enqueue_bootstrap_js();
	add_thickbox();
	wp_enqueue_script( 'global-common',       SP_ASSETS . '/js/global-common.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'global-admin',        SP_ASSETS . '/js/global-admin.js', array( 'jquery' ), false, true );

	$params = array(
		'baseurl' => trailingslashit( home_url() ),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'tplurl'  => trailingslashit( SP_URI ),
	);
	wp_localize_script( 'global-common', 'sp', $params );

}
add_action( 'admin_enqueue_scripts', 'sp_enqueue_scripts_backend' );


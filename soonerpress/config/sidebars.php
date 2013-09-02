<?php


/** Register Sidebars */
function sp_register_sidebars() {

	register_sidebar( array(
		'name' => __( 'Primary Sidebar', 'sp' ),
		'id' => 'sidebar-1',
		'description' => __( 'Sidebar 1', 'sp' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'sp' ),
		'id' => 'sidebar-2',
		'description' => __( 'Sidebar 2', 'sp' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'sp_register_sidebars' );


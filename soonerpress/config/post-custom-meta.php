<?php


/** Init Post Custom Metadata */
function sp_init_post_custom_meta() {

	add_pm_box(
		'box-post-1',
		'post',
		'Meta Box 1 Title',
		array(
			array(
				'id' => 'slug_pm0',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'text',
				'display_column' => true,
				'display_column_callback' => '__' ),
			array(
				'id' => 'slug_pm1',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'upload',
				'multiple' => true ),
			array(
				'id' => 'slug_pm2',
				'title' => 'Title',
				'desc' => 'Description',
				'multiple' => true,
				'title_single' => 'Single Title',
				'fields' => array(
						array(
							'id' => 'slug_pm2a',
							'title' => 'Title',
							'desc' => 'Description',
							'type' => 'text' ),
						array(
							'id' => 'slug_pm2b',
							'title' => 'Title',
							'desc' => 'Description',
							'type' => 'upload',
							'multiple' => true ),
				) ),
			array(
				'id' => 'slug_pm3',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'textarea' ),
			array(
				'id' => 'slug_pm4',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'date' ),
			array(
				'id' => 'slug_pm5',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'wysiwyg' ),
		)
	);
	add_pm_box(
		'box-post-1',
		'post',
		'Meta Box 2 Title',
		array(
			array(
				'id' => 'slug_pm6',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'select' ),
			array(
				'id' => 'slug_pm7',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'upload',
				'multiple' => true ),
			array(
				'id' => 'slug_pm8',
				'title' => 'Title',
				'desc' => 'Description',
				'type' => 'wysiwyg' ),
		)
	);

/*
	// using
	global $post;
	$meta = get_pm( $post->ID );
	echo $meta['slug_pm0'];
	print_r( $meta['slug_pm1'] );
	print_r( $meta['slug_pm2'] );
	foreach( $meta['slug_pm2'] as $k => $v ) {
		echo $v['slug_pm2a'];
		print_r( $v['slug_pm2b'] );
	}
	echo date( DATE_ATOM, strtotime( $meta['slug_pm4'] ) );
	echo wpautop( $meta['slug_pm5'] );
	print_r( $meta['slug_pm7'] );
*/

}
add_action( 'sp_init_post_custom_meta', 'sp_init_post_custom_meta' );


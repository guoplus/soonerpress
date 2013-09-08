<?php



if( is_admin() ) {

	global $sp_config;

	$sp_config['taxonomy-custom-meta']['boxes'][] = array(
		'taxonomy' => array( 'category' ),
		'fields' => array(
			array(
				'id' => 'title',
				'title' => __( 'Category Title', 'sp' ),
				'desc' => __( 'Enter the category title.', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'thumbnail',
				'title' => __( 'Category Thumbnail', 'sp' ),
				'desc' => __( 'Thumbnail image.', 'sp' ),
				'type' => 'image',
			),
			array(
				'id' => 'richtext',
				'title' => __( 'Category Richtext', 'sp' ),
				'desc' => __( 'Category richtext.', 'sp' ),
				'type' => 'wysiwyg',
			),
		)
	);

	$sp_config['taxonomy-custom-meta']['boxes'][] = array(
		'taxonomy' => array( 'post_tag' ),
		'ml' => false,
		'fields' => array(
			array(
				'id' => 'tag_color',
				'title' => __( 'Category Title', 'sp' ),
				'desc' => __( 'Enter the category title.', 'sp' ),
				'type' => 'colorpicker',
			),
			array(
				'id' => 'document_readme',
				'title' => __( 'Document: Readme', 'sp' ),
				'desc' => __( 'Upload a text document here.', 'sp' ),
				'type' => 'file',
			),
			array(
				'id' => 'tag_type',
				'title' => __( 'Tag Type', 'sp' ),
				'desc' => __( 'Select a type of tag.', 'sp' ),
				'type' => 'select',
				'choices' => array(
					'apple' => __( 'Apple', 'sp' ),
					'banana' => __( 'Banana', 'sp' ),
					'orange' => __( 'Orange', 'sp' ),
				),
				'std' => 'banana',
			),
		)
	);

}


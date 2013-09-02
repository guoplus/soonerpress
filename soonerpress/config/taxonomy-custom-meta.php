<?php


/** Init Taxonomy Custom Metadata */
function _sp_tm_init() {

	if( ! is_admin() )
		return;

	$sp_tax_meta = new Tax_Meta_Class( array(
		'id' => 'demo_meta_box',          // meta box id, unique per meta box
		'title' => 'Demo Meta Box',          // meta box title
		'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(),            // list of meta fields (can be added by field arrays)
		'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	) );

	//text field
	$sp_tax_meta->addText('text_field_id',array('name'=> __('My Text ','tax-meta')));
	//textarea field
	$sp_tax_meta->addTextarea('textarea_field_id',array('name'=> __('My Textarea ','tax-meta')));
	//checkbox field
	$sp_tax_meta->addCheckbox('checkbox_field_id',array('name'=> __('My Checkbox ','tax-meta')));
	//select field
	$sp_tax_meta->addSelect('select_field_id',array('selectkey1'=>'Select Value1','selectkey2'=>'Select Value2'),array('name'=> __('My select ','tax-meta'), 'std'=> array('selectkey2')));
	//radio field
	$sp_tax_meta->addRadio('radio_field_id',array('radiokey1'=>'Radio Value1','radiokey2'=>'Radio Value2'),array('name'=> __('My Radio Filed','tax-meta'), 'std'=> array('radionkey2')));
	//date field
	$sp_tax_meta->addDate('date_field_id',array('name'=> __('My Date ','tax-meta')));
	//Time field
	$sp_tax_meta->addTime('time_field_id',array('name'=> __('My Time ','tax-meta')));
	//Color field
	$sp_tax_meta->addColor('color_field_id',array('name'=> __('My Color ','tax-meta')));
	//Image field
	$sp_tax_meta->addImage('image_field_id',array('name'=> __('My Image ','tax-meta')));
	//file upload field
	$sp_tax_meta->addFile('file_field_id',array('name'=> __('My File ','tax-meta')));
	//wysiwyg field
	$sp_tax_meta->addWysiwyg('wysiwyg_field_id',array('name'=> __('My wysiwyg Editor ','tax-meta')));
	//taxonomy field
	$sp_tax_meta->addTaxonomy('taxonomy_field_id',array('taxonomy' => 'category'),array('name'=> __('My Taxonomy ','tax-meta')));
	//posts field
	$sp_tax_meta->addPosts('posts_field_id',array('args' => array('post_type' => 'page')),array('name'=> __('My Posts ','tax-meta')));

	// $repeater_fields[] = $sp_tax_meta->addText('re_text_field_id',array('name'=> __('My Text ','tax-meta')),true);
	// $repeater_fields[] = $sp_tax_meta->addTextarea('re_textarea_field_id',array('name'=> __('My Textarea ','tax-meta')),true);
	// $repeater_fields[] = $sp_tax_meta->addCheckbox('re_checkbox_field_id',array('name'=> __('My Checkbox ','tax-meta')),true);
	// $repeater_fields[] = $sp_tax_meta->addImage('image_field_id',array('name'=> __('My Image ','tax-meta')),true);

	// $sp_tax_meta->addRepeaterBlock('re_',array('inline' => true, 'name' => __('This is a Repeater Block','tax-meta'),'fields' => $repeater_fields));

	//Finish Meta Box Decleration
	$sp_tax_meta->Finish();

}
add_action( 'init', '_sp_tm_init' );


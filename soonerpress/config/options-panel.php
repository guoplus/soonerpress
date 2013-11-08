<?php
/**
 * Options Panel module configuration
 *
 * @package SoonerPress
 * @subpackage Options_Panel
 */

if ( ! defined( 'IN_SP' ) ) exit;


/* This is a sample configuration, edit or delete it, then start developing :-) */

if( is_admin() ) {

	global $sp_config;

	$sp_config['options-panel']['menu_title'] = __( 'Options Panel', 'sp' );
	$sp_config['options-panel']['page_title'] = wp_get_theme() . ' ' . __( 'Options Panel', 'sp' );
	$sp_config['options-panel']['show_header'] = true;
	$sp_config['options-panel']['show_footer'] = false;
	$sp_config['options-panel']['before_form'] = <<< EOTEXT
<h3>Welcome to options panel.</h3>
<p>This is a description test. Using options panel configuration parameter.</p>
<p>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</p>
EOTEXT;
	$sp_config['options-panel']['after_form'] = <<< EOTEXT
<p>There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...</p>
<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>
EOTEXT;

	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'General', 'sp' ), // tab name
		'icon' => sp_icon_src( 'home_page' ), // tab icon
		'fields' => array(
			array(
				'title' => __( 'General', 'sp' ),
				'type' => 'title', // tab content title
			),
			array(
				'title' => __( 'This is the general settings.', 'sp' ),
				'type' => 'info', // description info text below tab title
			),
			array(
				'id' => 'site_logo',
				'title' => __( 'Custom Logo', 'sp' ),
				'type' => 'image',
				'desc' => 'Upload a main logo image, size: 300 × 60 (pixels).',
			),
			array(
				'id' => 'site_favicon',
				'title' => __( 'Favicon Image', 'sp' ),
				'type' => 'image',
				'desc' => 'Upload a favicon image, size: 16 × 16 (pixels).',
				'ml' => false,
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Layout', 'sp' ), // tab name
		'icon' => sp_icon_src( 'layout_edit' ), // tab icon
		'fields' => array(
			array(
				'title' => __( 'Website Layout Mode', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'This is the pages layout settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'layout_home',
				'title' => __( 'Homepage Layout', 'sp' ),
				'type' => 'radio_icon',
				'choices' => array(
					'full_width'           => array( SP_IMG . '/admin/layout-1.png', __( 'Full width content', 'sp' ) ),
					'right_sidebar'        => array( SP_IMG . '/admin/layout-2.png', __( 'Sidebar on the right', 'sp' ) ),
					'left_sidebar'         => array( SP_IMG . '/admin/layout-3.png', __( 'Sidebar on the left', 'sp' ) ),
					'right_double_sidebar' => array( SP_IMG . '/admin/layout-4.png', __( 'Double sidebar on the right', 'sp' ) ),
					'left_double_sidebar'  => array( SP_IMG . '/admin/layout-5.png', __( 'Double sidebar on the left', 'sp' ) ),
					'left_right_sidebar'   => array( SP_IMG . '/admin/layout-6.png', __( 'Double sidebar on the left and right', 'sp' ) ),
				),
				'std' => 'right_sidebar',
				'desc' => __( 'Select your homepage layout mode.', 'sp' ),
				'ml' => false,
			),
			array(
				'id' => 'layout_page',
				'title' => __( 'Individual Page Layout', 'sp' ),
				'type' => 'radio_icon',
				'choices' => array(
					'full_width'           => array( SP_IMG . '/admin/layout-1.png', __( 'Full width content', 'sp' ) ),
					'right_sidebar'        => array( SP_IMG . '/admin/layout-2.png', __( 'Sidebar on the right', 'sp' ) ),
					'left_sidebar'         => array( SP_IMG . '/admin/layout-3.png', __( 'Sidebar on the left', 'sp' ) ),
					'right_double_sidebar' => array( SP_IMG . '/admin/layout-4.png', __( 'Double sidebar on the right', 'sp' ) ),
					'left_double_sidebar'  => array( SP_IMG . '/admin/layout-5.png', __( 'Double sidebar on the left', 'sp' ) ),
					'left_right_sidebar'   => array( SP_IMG . '/admin/layout-6.png', __( 'Double sidebar on the left and right', 'sp' ) ),
				),
				'std' => 'full_width',
				'desc' => __( 'Select your individual page layout mode.', 'sp' ),
				'ml' => false,
			),
			array(
				'id' => 'layout_archive',
				'title' => __( 'Archive Page Layout', 'sp' ),
				'type' => 'radio_icon',
				'choices' => array(
					'full_width'           => array( SP_IMG . '/admin/layout-1.png', __( 'Full width content', 'sp' ) ),
					'right_sidebar'        => array( SP_IMG . '/admin/layout-2.png', __( 'Sidebar on the right', 'sp' ) ),
					'left_sidebar'         => array( SP_IMG . '/admin/layout-3.png', __( 'Sidebar on the left', 'sp' ) ),
					'right_double_sidebar' => array( SP_IMG . '/admin/layout-4.png', __( 'Double sidebar on the right', 'sp' ) ),
					'left_double_sidebar'  => array( SP_IMG . '/admin/layout-5.png', __( 'Double sidebar on the left', 'sp' ) ),
					'left_right_sidebar'   => array( SP_IMG . '/admin/layout-6.png', __( 'Double sidebar on the left and right', 'sp' ) ),
				),
				'std' => 'full_width',
				'desc' => __( 'Select your archive page layout mode.', 'sp' ),
				'ml' => false,
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Color', 'sp' ), // tab name
		'icon' => sp_icon_src( 'color_wheel' ), // tab icon
		'fields' => array(
			array(
				'title' => __( 'Color Control', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( '.', 'sp' ),
				'type' => 'info',
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Typography', 'sp' ), // tab name
		'icon' => sp_icon_src( 'text_smallcaps' ), // tab icon
		'fields' => array(
			array(
				'id' => 'font_primary',
				'title' => __( 'Primary Font', 'sp' ),
				'type' => 'font',
				'field_type' => 'select',
				'choices' => array(
					'"Arial Black", "Arial Bold", Arial, sans-serif' => __( 'Arial Black', 'sp' ),
					'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif' => __( 'Calibri', 'sp' ),
					'Courier, Verdana, sans-serif' => __( 'Courier', 'sp' ),
					'"Helvetica Neue", Helvetica, Arial, sans-serif' => __( 'Helvetica', 'sp' ),
					'"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif' => __( 'Lucida Bright', 'sp' ),
					'"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif' => __( 'Lucida Grande', 'sp' ),
					'Tahoma, Geneva, Verdana, sans-serif' => __( 'Tahoma', 'sp' ),
				),
				'std' => 'helvetica',
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Header & Footer', 'sp' ),
		'icon' => sp_icon_src( 'layout_header' ),
		'fields' => array(
			array(
				'title' => __( 'Header', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'This is the header settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'branding_mode',
				'title' => __( 'Branding Type', 'sp' ),
				'type' => 'select',
				'choices' => array(
					'image' => __( 'Logo Image', 'sp' ),
					'text' => __( 'Text', 'sp' ),
				),
				'desc' => 'Once you select logo image, you have to upload a logo image in Options Panel to make effect.',
				'std' => 'image',
			),
			array(
				'id' => 'website_title',
				'title' => __( 'Website Title', 'sp' ),
				'type' => 'text',
				'show_field_when' => array(
					'branding_mode' => 'text',
				),
				'std' => get_bloginfo( 'name' ),
			),
			array(
				'id' => 'show_header_nav',
				'title' => __( 'Show Header Menu', 'sp' ),
				'type' => 'on_off',
				'std' => 1,
				'ml' => false,
			),
			array(
				'title' => __( 'Footer', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'This is the footer settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'text_copy',
				'title' => __( 'Copyright Text', 'sp' ),
				'type' => 'wysiwyg',
				'desc' => 'Enter the footer copyright text here, HTML supported.',
				'std' => 'Copyright &copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'sitename' ),
			),
			array(
				'id' => 'footer_align',
				'title' => __( 'Footer Alignment', 'sp' ),
				'type' => 'select',
				'choices' => array(
					'footer-align-left' => __( 'Left', 'sp' ),
					'footer-align-center' => __( 'Center', 'sp' ),
					'footer-align-right' => __( 'Right', 'sp' ),
				),
				'std' => 'footer-align-left',
				'ml' => false,
			),
			array(
				'id' => 'show_footer_nav',
				'title' => __( 'Show Footer Menu', 'sp' ),
				'type' => 'on_off',
				'std' => 1,
				'ml' => false,
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Social', 'sp' ),
		'icon' => sp_icon_src( 'twitter_2' ),
		'fields' => array(
			array(
				'title' => __( 'Social Network Links', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'Social Network links settings.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'social_tw',
				'title' => __( 'Twitter URL', 'sp' ),
				'desc' => __( 'Enter full Twitter link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
				'placeholder' => 'https://twitter.com/'
			),
			array(
				'id' => 'social_fb',
				'title' => __( 'Facebook URL', 'sp' ),
				'desc' => __( 'Enter full Facebook link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
				'placeholder' => 'https://facebook.com/'
			),
			array(
				'id' => 'social_gp',
				'title' => __( 'Google+ URL', 'sp' ),
				'desc' => __( 'Enter full Google+ link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'social_pi',
				'title' => __( 'Pinterest URL', 'sp' ),
				'desc' => __( 'Enter full Pinterest link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'social_li',
				'title' => __( 'LinkedIn URL', 'sp' ),
				'desc' => __( 'Enter full LinkedIn link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'social_is',
				'title' => __( 'Instagram URL', 'sp' ),
				'desc' => __( 'Enter full Instagram link URL here, including http:// or https://.', 'sp' ),
				'type' => 'text',
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'SEO', 'sp' ),
		'icon' => sp_icon_src( 'google_custom_search' ),
		'fields' => array(
			array(
				'title' => __( 'Basic SEO', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'Basic Searching Engine Optimization for website, must enabled SoonerPress SEO module.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'global_title',
				'title' => __( 'Global Title', 'sp' ),
				'desc' => __( 'HTML title for homepage', 'sp' ),
				'type' => 'text',
			),
			array(
				'id' => 'global_description',
				'title' => __( 'Global Description', 'sp' ),
				'desc' => __( 'HTML head description for homepage', 'sp' ),
				'type' => 'textarea',
			),
			array(
				'id' => 'global_keywords',
				'title' => __( 'Global Keywords', 'sp' ),
				'desc' => __( 'HTML head keywords for homepage', 'sp' ),
				'type' => 'textarea',
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Pages', 'sp' ),
		'icon' => sp_icon_src( 'page_gear' ),
		'fields' => array(
			array(
				'title' => __( 'Branches Settings', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'Settings for Branches page.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'page_branches_init_location',
				'title' => __( 'Default Location', 'sp' ),
				'desc' => __( 'Enter a full address to go.', 'sp' ),
				'type' => 'google_maps',
				'ml' => false,
			),
			array(
				'id' => 'page_branches_init_zoom',
				'title' => __( 'Default Zooming Level', 'sp' ),
				'type' => 'select',
				'choices' => array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20', ),
				'ml' => false,
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Advanced', 'sp' ),
		'icon' => sp_icon_src( 'lightbulb' ),
		'fields' => array(
			array(
				'title' => __( 'Advanced Settings', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'Advanced settings for additional uses.', 'sp' ),
				'type' => 'info',
			),
		),
	);
	$sp_config['options-panel']['tabs'][] = array(
		'title' => __( 'Test', 'sp' ),
		'icon' => sp_icon_src( 'cog' ),
		'fields' => array(
			array(
				'title' => __( 'Custom Field Test', 'sp' ),
				'type' => 'title',
			),
			array(
				'title' => __( 'SoonerPress Custom Meta Field test.', 'sp' ),
				'type' => 'info',
			),
			array(
				'id' => 'events',
				'title' => __( 'Events', 'sp' ),
				'desc' => __( 'Events list with multiple group data.', 'sp' ),
				'type' => 'group',
				'row_title' => __( 'An Event', 'sp' ),
				'row_name_refer_to' => 'event_title',
				'expanded_default' => true,
				// 'ml' => false,
				'fields' => array(
					array(
						'id' => 'event_title',
						'title' => __( 'Event Title', 'sp' ),
						'desc' => __( 'Title of event here.', 'sp' ),
						'type' => 'text',
					),
					array(
						'id' => 'event_description',
						'title' => __( 'Event Description', 'sp' ),
						'desc' => __( 'Description of event here.', 'sp' ),
						'type' => 'textarea',
					),
					array(
						'id' => 'event_sponsors',
						'title' => __( 'Event Sponsors', 'sp' ),
						'desc' => __( 'Sponsors of event here.', 'sp' ),
						'type' => 'group',
						'row_title' => __( 'A Sponsor', 'sp' ),
						'row_name_refer_to' => 'sponsor_name',
						'fields' => array(
							array(
								'id' => 'sponsor_name',
								'title' => __( 'Sponsor Name', 'sp' ),
								'desc' => __( 'Name of event sponsor here.', 'sp' ),
								'type' => 'text',
							),
							array(
								'id' => 'sponsor_features',
								'title' => __( 'Sponsor Features', 'sp' ),
								'desc' => __( 'Features of event sponsor here.', 'sp' ),
								'type' => 'group',
								'row_title' => __( 'A Feature', 'sp' ),
								'row_name_refer_to' => 'sponsor_feature_title',
								'fields' => array(
									array(
										'id' => 'sponsor_feature_title',
										'title' => __( 'Sponsor Feature Title', 'sp' ),
										'desc' => __( 'Title of feature here.', 'sp' ),
										'type' => 'text',
									),
									array(
										'id' => 'sponsor_feature_data',
										'title' => __( 'Sponsor Data', 'sp' ),
										'desc' => __( 'Data of feature here.', 'sp' ),
										'type' => 'text',
										'multiple' => true,
									),
								),
							),
						),
					),
				),
			),
		),
	);

}


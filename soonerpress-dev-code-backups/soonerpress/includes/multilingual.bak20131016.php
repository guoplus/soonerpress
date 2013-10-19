<?php
/**
 * Multilingual module API
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */


/** get current language */
function sp_lang() {
	$lang = isset( $_GET['lang'] ) ? substr( $_GET['lang'], 0, 4 ) : '';
	if ( ! in_array( $lang, sp_get_enabled_languages_ids() ) )
		$lang = sp_get_default_language();
	return $lang;
}

/** languages selector HTML output */
function sp_lang_selector( $args = array(), $echo = false ) {
	$output = '';
	$s = wp_parse_args( $args, array(
		'container_class' => 'sp-ml-lang-tabs',
		'button_class' => 'sp-ml-lang-tab',
		'type' => 'select',
		'separator' => ' | ',
	) );
	$languages = sp_get_enabled_languages();
	$output .= '<span class="'.esc_attr( $s['container_class'] ).' sp-ml-lang-tabs-'.esc_attr( $s['type'] ).'">';
	switch( $s['type'] ) {
		case 'select':
			$output .= '<select>';
			foreach( $languages as $lang_code => $l ) {
				$output .= sprintf( '<option value="%s">%s</option>',
					esc_attr( $lang_code ),
					esc_html( $l['name'] )
				);
			}
			$output .= '</select>';
			break;
		case 'text':
			foreach( $languages as $lang_code => $l ) {
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s">%s</a>',
					esc_attr( $l['name'] ),
					esc_attr( $lang_code ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $lang_code ),
					esc_html( $l['name'] )
				);
				end( $languages );
				if ( $lang_code != key( $languages ) )
					$output .= $s['separator'];
			}
			break;
		case 'img':
			foreach( $languages as $lang_code => $l ) {
				$output .= sprintf( '<a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" align="absmiddle" /></a>',
					esc_attr( $l['name'] ),
					esc_attr( $lang_code ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $lang_code ),
					esc_attr( $l['flag'] ),
					esc_attr( $lang_code )
				);
			}
			break;
	}
	$output .= '</span>';
	if ( $echo )
		echo $output;
	else
		return $output;
}

/** languages selector tabs HTML output (for dashboard) */
function _sp_lang_selector_admin() {
	return sp_lang_selector( array( 'type' => 'img' ), false );
}

/**
 * get enabled languages list. each entry includes id, name and flag url
 *
 * @uses sp_get_enabled_languages_ids() get languages ids to map
 * @return array|false languages array of false if no data retrieved
 */
function sp_get_enabled_languages() {
	if ( sizeof( sp_get_enabled_languages_ids() ) ) {
		foreach ( sp_get_enabled_languages_ids() as $lang_code ) {
			$languages[$lang_code] = sp_get_language( $lang_code );
		}
		return $languages;
	}
	return false;
}

/**
 * get enabled languages ids list
 * 
 * @return array|false languages ids array of false if no data retrieved
 */
function sp_get_enabled_languages_ids() {
	$sp_ml_opt_main = get_option( 'sp_ml_opt_main' );
	if ( isset( $sp_ml_opt_main['enabled'] ) )
		return $sp_ml_opt_main['enabled'];
	return false;
}

/**
 * get the default language id
 * 
 * @return string|false language id of false if no data retrieved
 */
function sp_get_default_language() {
	$sp_ml_opt_main = get_option( 'sp_ml_opt_main' );
	if ( isset( $sp_ml_opt_main['default'] ) )
		return $sp_ml_opt_main['default'];
	return false;
}

/**
 * get specified language data from database
 * 
 * @param  string $id language id
 * @return array|false language data or false if no data retrieved
 */
function sp_get_language( $id ) {
	$sp_ml_opt_main = get_option( 'sp_ml_opt_main' );
	if ( isset( $sp_ml_opt_main['languages'] ) && isset( $sp_ml_opt_main['languages'][$id] ) )
		return $sp_ml_opt_main['languages'][$id];
	return false;
}

/**
 * get all existing languages from database
 * 
 * @return array|false languages data or false if no data retrieved
 */
function sp_get_languages() {
	$sp_ml_opt_main = get_option( 'sp_ml_opt_main' );
	if ( isset( $sp_ml_opt_main['languages'] ) )
		return $sp_ml_opt_main['languages'];
	return false;
}

function sp_ml_ext_post_field( $post_id, $field, $lang = '' ) {
	if ( empty( $lang ) )
		$lang = sp_lang();
	$post = get_post( intval( $post_id ) );
	if ( $post && in_array( $field, array( 'post_title', 'post_content', 'post_excerpt' ) ) ) {
		return get_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang, true );
	}
	return null;
}

function sp_ml_ext_term_field( $term_id, $taxonomy, $field, $lang = '' ) {
	if ( empty( $lang ) )
		$lang = sp_lang();
	$term = get_term( intval( $term_id ), $taxonomy );
	if ( $term && in_array( $field, array( 'name', 'description' ) ) ) {
		return sp_get_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$lang );
	}
	return null;
}


$_sp_ml_locale_list = array(
	'af'     => array( 'name' => 'Afrikaans - Afrikaans' ),
	'an'     => array( 'name' => 'Aragonese - Aragonés' ),
	'ar'     => array( 'name' => 'Arabic – عربي' ),
	'as'     => array( 'name' => 'Assamese - অসমীয়া' ),
	'az'     => array( 'name' => 'Azerbaijani - Azərbaycan dili' ),
	'az_TR'  => array( 'name' => 'Azerbaijani (Turkey) - Azərbaycan Türkcəsi' ),
	'azb'    => array( 'name' => '' ),
	'bel'    => array( 'name' => '' ),
	'bg_BG'  => array( 'name' => 'Bulgarian - Български' ),
	'bn_BD'  => array( 'name' => 'Bangla - Bengali' ),
	'bo'     => array( 'name' => '' ),
	'bs_BA'  => array( 'name' => 'Bosnian - Bosanski' ),
	'ca'     => array( 'name' => 'Catalan - Català' ),
	'ckb'    => array( 'name' => '' ),
	'co'     => array( 'name' => '' ),
	'cpp'    => array( 'name' => '' ),
	'cs_CZ'  => array( 'name' => 'Czech - Čeština' ),
	'cy'     => array( 'name' => 'Welsh - Cymraeg' ),
	'da_DK'  => array( 'name' => 'Danish - Dansk' ),
	'de_DE'  => array( 'name' => 'German - Deutsch' ),
	'dv'     => array( 'name' => '' ),
	'el'     => array( 'name' => '' ),
	'en_CA'  => array( 'name' => 'Canadian English' ),
	'en_GB'  => array( 'name' => 'British English' ),
	'eo'     => array( 'name' => 'Esperanto' ),
	'es_CL'  => array( 'name' => 'Chilean - Chile' ),
	'es_ES'  => array( 'name' => 'Spanish - Español - España' ),
	'es_PE'  => array( 'name' => 'Spanish - Español - Perú' ),
	'es_VE'  => array( 'name' => '' ),
	'et'     => array( 'name' => 'Estonian - Eesti' ),
	'eu'     => array( 'name' => 'Basque - Euskara' ),
	'fa_AF'  => array( 'name' => 'Persian (Afghanistan) - (فارسی (افغانستان' ),
	'fa_IR'  => array( 'name' => 'Persian - وردپرس پارسی' ),
	'fi'     => array( 'name' => 'Finnish - Suomi' ),
	'fo'     => array( 'name' => 'Faroese - føroyskt' ),
	'fr_BE'  => array( 'name' => '' ),
	'fr_FR'  => array( 'name' => 'French - Français' ),
	'fy'     => array( 'name' => 'Frisian - Frysk' ),
	'ga'     => array( 'name' => 'Gaeilge - Irish' ),
	'gd'     => array( 'name' => 'Scottish Gaelic - Gàidhlig' ),
	'gl_ES'  => array( 'name' => 'Galician - Galego' ),
	'gsw'    => array( 'name' => '' ),
	'gu'     => array( 'name' => '' ),
	'haw_US' => array( 'name' => '' ),
	'haz'    => array( 'name' => 'Hazaragi – هزاره‌گی' ),
	'he_IL'  => array( 'name' => 'Hebrew - עברית' ),
	'hi_IN'  => array( 'name' => 'Hindi - हिन्दी' ),
	'hr'     => array( 'name' => 'Croatian - Hrvatski' ),
	'hu_HU'  => array( 'name' => 'Hungarian - Magyar' ),
	'hy'     => array( 'name' => '' ),
	'id_ID'  => array( 'name' => 'Indonesian - Bahasa Indonesia' ),
	'is_IS'  => array( 'name' => 'Icelandic - íslenska' ),
	'it_IT'  => array( 'name' => 'Italian - Italiano' ),
	'ja'     => array( 'name' => 'Japanese (日本語)' ),
	'jv_ID'  => array( 'name' => 'Javanese - Basa Jawa' ),
	'ka_GE'  => array( 'name' => '' ),
	'kea'    => array( 'name' => '' ),
	'kk'     => array( 'name' => 'Kazakh - Қазақша' ),
	'kn'     => array( 'name' => 'Kannada - ಕನ್ನಡ' ),
	'ko_KR'  => array( 'name' => 'Korean - 한국어' ),
	'ku'     => array( 'name' => 'Kurdish(Sorany) وۆردپرێس بەکوردی' ),
	'ky_KY'  => array( 'name' => 'Kyrgyz - Кыргызча' ),
	'la'     => array( 'name' => '' ),
	'li'     => array( 'name' => '' ),
	'lo'     => array( 'name' => 'Lao - ພາສາລາວ' ),
	'lv'     => array( 'name' => 'Latvian (Latviešu)' ),
	'me_ME'  => array( 'name' => 'Montenegrin - Crnogorski jezik' ),
	'mg_MG'  => array( 'name' => 'Malagasy - Malagasy' ),
	'mk_MK'  => array( 'name' => 'Macedonian - Македонски' ),
	'ml_IN'  => array( 'name' => '' ),
	'mn'     => array( 'name' => 'Mongolian - (Монгол хэл)' ),
	'mr'     => array( 'name' => '' ),
	'mri'    => array( 'name' => '' ),
	'ms_MY'  => array( 'name' => 'Malay – Bahasa Melayu' ),
	'my_MM'  => array( 'name' => 'Burmese - ဗမာစာ' ),
	'nb_NO'  => array( 'name' => 'Norwegian - Bokmål' ),
	'ne_NP'  => array( 'name' => '' ),
	'nl'     => array( 'name' => '' ),
	'nl_BE'  => array( 'name' => '' ),
	'nl_NL'  => array( 'name' => 'Dutch - Nederlands' ),
	'nn_NO'  => array( 'name' => 'Norwegian - Nynorsk' ),
	'os'     => array( 'name' => '' ),
	'pa_IN'  => array( 'name' => '' ),
	'pl_PL'  => array( 'name' => 'Polish - Polski' ),
	'pot'    => array( 'name' => '' ),
	'pt_BR'  => array( 'name' => 'Portuguese - Brazilian Portuguese' ),
	'pt_PT'  => array( 'name' => 'Portuguese - European Portuguese' ),
	'ro_RO'  => array( 'name' => 'Romanian - Română' ),
	'ru_RU'  => array( 'name' => 'Russian — Русский' ),
	'ru_UA'  => array( 'name' => '' ),
	'sa_IN'  => array( 'name' => '' ),
	'sd_PK'  => array( 'name' => '' ),
	'si_LK'  => array( 'name' => 'Sinhala - සිංහල' ),
	'sk_SK'  => array( 'name' => 'Slovak – Slovenčina' ),
	'sl_SI'  => array( 'name' => 'Slovenian - Slovenščina' ),
	'so_SO'  => array( 'name' => 'Somali - Afsoomaali' ),
	'sq'     => array( 'name' => 'Albanian - Shqip' ),
	'sr_RS'  => array( 'name' => 'Serbian - Српски' ),
	'srd'    => array( 'name' => '' ),
	'su_ID'  => array( 'name' => 'Sundanese - Basa Sunda' ),
	'sv_SE'  => array( 'name' => 'Swedish - Svenska' ),
	'sw'     => array( 'name' => '' ),
	'ta_IN'  => array( 'name' => '' ),
	'ta_LK'  => array( 'name' => 'Sri Lanka- இலங்கைத் தமிழ்' ),
	'te'     => array( 'name' => '' ),
	'tg'     => array( 'name' => 'Tajik' ),
	'th'     => array( 'name' => 'Thai - ไทย' ),
	'tl'     => array( 'name' => '' ),
	'tr_TR'  => array( 'name' => 'Turkish - Türkçe' ),
	'tuk'    => array( 'name' => '' ),
	'tzm'    => array( 'name' => '' ),
	'ug_CN'  => array( 'name' => 'Uighur - ئۇيغۇرچە' ),
	'uk'     => array( 'name' => 'Ukrainian - Українська' ),
	'ur'     => array( 'name' => 'Urdu - اردو' ),
	'uz_UZ'  => array( 'name' => 'Uzbek - O‘zbekcha' ),
	'vi'     => array( 'name' => 'Vietnamese - Tiếng Việt' ),
	'zh_CN'  => array( 'name' => 'Chinese - 中文' ),
	'zh_HK'  => array( 'name' => 'Hong Kong (香港)' ),
	'zh_TW'  => array( 'name' => 'Taiwan (台灣)' ),
);


class SP_Multilingual extends SP_Module {

	function __construct() {
		$this->dc = array(
			'enabled' => array( 'en', 'zh', 'de' ),
			'default' => 'en',
			'languages' => array(
				'ar' => array( 'flag' => $this->get_module_uri() . '/images/flags/ar.gif',
					'name' => 'العربية',
					'date_format' => '',
					'time_format' => '',
				),
				'de' => array( 'flag' => $this->get_module_uri() . '/images/flags/de.gif',
					'name' => 'Deutsch',
					'date_format' => '',
					'time_format' => '',
				),
				'en' => array( 'flag' => $this->get_module_uri() . '/images/flags/us.gif',
					'name' => 'English',
					'date_format' => '',
					'time_format' => '',
				),
				'es' => array( 'flag' => $this->get_module_uri() . '/images/flags/es.gif',
					'name' => 'Español',
					'date_format' => '',
					'time_format' => '',
				),
				'fi' => array( 'flag' => $this->get_module_uri() . '/images/flags/fi.gif',
					'name' => 'suomi',
					'date_format' => '',
					'time_format' => '',
				),
				'fr' => array( 'flag' => $this->get_module_uri() . '/images/flags/fr.gif',
					'name' => 'Français',
					'date_format' => '',
					'time_format' => '',
				),
				'gl' => array( 'flag' => $this->get_module_uri() . '/images/flags/gl.gif',
					'name' => 'galego',
					'date_format' => '',
					'time_format' => '',
				),
				'hu' => array( 'flag' => $this->get_module_uri() . '/images/flags/hu.gif',
					'name' => 'Magyar',
					'date_format' => '',
					'time_format' => '',
				),
				'it' => array( 'flag' => $this->get_module_uri() . '/images/flags/it.gif',
					'name' => 'Italiano',
					'date_format' => '',
					'time_format' => '',
				),
				'ja' => array( 'flag' => $this->get_module_uri() . '/images/flags/jp.gif',
					'name' => '日本語',
					'date_format' => '',
					'time_format' => '',
				),
				'nl' => array( 'flag' => $this->get_module_uri() . '/images/flags/nl.gif',
					'name' => 'Nederlands',
					'date_format' => '',
					'time_format' => '',
				),
				'pl' => array( 'flag' => $this->get_module_uri() . '/images/flags/pl.gif',
					'name' => 'Polski',
					'date_format' => '',
					'time_format' => '',
				),
				'pt' => array( 'flag' => $this->get_module_uri() . '/images/flags/pt.gif',
					'name' => 'Português',
					'date_format' => '',
					'time_format' => '',
				),
				'ro' => array( 'flag' => $this->get_module_uri() . '/images/flags/ro.gif',
					'name' => 'Română',
					'date_format' => '',
					'time_format' => '',
				),
				'sv' => array( 'flag' => $this->get_module_uri() . '/images/flags/sv.gif',
					'name' => 'Svenska',
					'date_format' => '',
					'time_format' => '',
				),
				'vi' => array( 'flag' => $this->get_module_uri() . '/images/flags/vi.gif',
					'name' => 'Tiếng Việt',
					'date_format' => '',
					'time_format' => '',
				),
				'zh' => array( 'flag' => $this->get_module_uri() . '/images/flags/cn.gif',
					'name' => '中文',
					'date_format' => '',
					'time_format' => '',
				),
			),
		);
		$this->init( 'multilingual' );
		// admin menu
		add_action( 'admin_menu'            , array( $this, 'add_admin_menu') );
		$this->init_settings();
		add_action( 'init'                  , array( $this, 'admin_save_user_language' ) );
		add_action( 'locale'                , array( $this, 'admin_apply_user_language' ) );
		// post edit
		add_action( 'add_meta_boxes'        , array( $this, 'pe_add_meta_boxes' ), 10, 2 );
		add_action( 'edit_form_after_editor', array( $this, 'pe_fields_do_html' ) );
		add_action( 'save_post'             , array( $this, 'pe_save_post' ) );
		// term edit
		if ( isset( $this->c['taxonomy'] ) )
			$taxonomies_ml_tmp = (array) $this->c['taxonomy'];
		else {
			global $wp_taxonomies;
			$taxonomies_ml_tmp = array_keys( $wp_taxonomies );
		}
		foreach( $taxonomies_ml_tmp as $taxonomy ) {
			add_action( $taxonomy.'_add_form' , array( $this, 'te_term_add_fields_do_html' ), 10, 1 );
			add_action( $taxonomy.'_edit_form', array( $this, 'te_term_edit_fields_do_html' ), 10, 2 );
			add_action( 'created_'.$taxonomy  , array( $this, 'te_save_term' ), 10, 2 );
			add_action( 'edited_'.$taxonomy   , array( $this, 'te_save_term' ), 10, 2 );
		}
		// hooks: general
		add_filter( 'the_title'             , array( $this, 'hook_ext_post_title' ), 0, 2 );
		add_filter( 'the_content'           , array( $this, 'hook_ext_post_content' ), 0, 1 );
		add_filter( 'the_excerpt'           , array( $this, 'hook_ext_post_excerpt' ), 0, 1 );
		add_filter( 'the_excerpt_rss'       , array( $this, 'hook_ext_post_excerpt' ), 0, 1 );
		add_filter( 'option_date_format'    , array( $this, 'hook_apply_date_format' ) );
		add_filter( 'option_time_format'    , array( $this, 'hook_apply_time_format' ) );
		// hooks: nav menus
		add_filter( 'sp_menus_config'       , array( $this, 'hook_menus_config_filter' ) );
		// hooks: options panel
		add_filter( 'sp_option_name'        , array( $this, 'hook_op_option_name_filter' ), 10, 2 );
		add_action( 'sp_op_header'          , array( $this, 'hook_op_header_footer' ) );
		add_action( 'sp_op_footer'          , array( $this, 'hook_op_header_footer' ) );
		add_filter( 'sp_op_one_name'        , array( $this, 'hook_cm_one_name_filter' ), 10, 2 );
		add_action( 'sp_op_register_setting', array( $this, 'hook_op_register_setting' ), 10, 3 );
		// hooks: post custom meta
		add_filter( 'sp_pm_meta_key'        , array( $this, 'hook_meta_key_filter' ), 10, 3 );
		add_filter( 'sp_pm_one_name'        , array( $this, 'hook_cm_one_name_filter' ), 10, 2 );
		add_action( 'sp_pm_update_postmeta' , array( $this, 'hook_pm_update_postmeta' ), 10, 4 );
		// hooks: taxonomy custom meta
		add_filter( 'sp_tm_meta_key'        , array( $this, 'hook_meta_key_filter' ), 10, 3 );
		add_filter( 'sp_tm_one_name'        , array( $this, 'hook_cm_one_name_filter' ), 10, 2 );
		add_action( 'sp_tm_update_termmeta' , array( $this, 'hook_tm_update_termmeta' ), 10, 4 );
	}

	// ==================== admin menu ====================

	function add_admin_menu() {
		register_setting( 'sp_multilingual', 'sp_ml_opt_main' );
		add_menu_page( __( 'Multilingual Settings', 'sp' ), __( 'Multilingual', 'sp' ), 'manage_options', 'multilingual', array( $this, 'admin_menu_do_html' ), false, 120 );
	}

	function admin_menu_do_html() {
		$page_title = get_admin_page_title();
		$sp_ml_opt_main = wp_parse_args( (array) get_option( 'sp_ml_opt_main' ), array(
			'query_mode' => 'cookies',
			'detect_browser_language' => '1',
		) );
		?>
		<div class="wrap sp-wrap sp-multilingual">

			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php echo esc_html( $page_title ); ?></h2>

			<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved.', 'sp' ); ?></strong></p></div>
			<?php endif; ?>

			<h3><?php _e( 'Languages', 'sp' ); ?></h3>

			<table id="sp_ml_opt_langs_list" class="widefat">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col"><?php _e( 'Flag', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Name', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Enabled?', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Edit', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Default?', 'sp' ); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col"></th>
					<th scope="col"><?php _e( 'Flag', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Name', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Enabled?', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Edit', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Default?', 'sp' ); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<tr class="lang_one sp_list_one_tpl">
					<td class="lang_flag"><img src="" /></td>
					<td class="lang_name"></td>
					<td class="lang_ctrl_enable"><a href="#" class="btn_lang_one_set_enable button"><?php _e( 'Enable', 'sp' ); ?></a>
					<a href="#" class="btn_lang_one_set_disable button"><?php _e( 'Disable', 'sp' ); ?></a></td>
					<td class="lang_ctrl_edit"><a href="#" class="btn_lang_one_edit button"><?php _e( 'Edit', 'sp' ); ?></a>
					<a href="#" class="btn_lang_one_delete button"><?php _e( 'Delete', 'sp' ); ?></a></td>
					<td class="lang_ctrl_default"><span class="sp_text_default"><?php _e( '(Default)', 'sp' ); ?></span>
					<a href="#" class="btn_lang_one_set_default button"><?php _e( 'Make Default', 'sp' ); ?></a></td>
				</tr>
			</tbody>
			</table>

			<div id="lang_edit" class="adding">
				<h3 class="lang_edit_title_edit"><?php _e( 'Edit Language', 'sp' ); ?></h3>
				<h3 class="lang_edit_title_add"><?php _e( 'Add Language', 'sp' ); ?></h3>
				<table class="form-table"><tbody>
					<tr valign="top"><th scope="row"><?php _e( 'Language Code', 'sp' ); ?></th><td><input id="lang_edit_lang_code" type="text" /><p class="description"><?php _e( 'Only lower letters and hyphen.', 'sp' ); ?></p></td></tr>
					<tr valign="top"><th scope="row"><?php _e( 'Language Name', 'sp' ); ?></th><td><input id="lang_edit_name" type="text" /><p class="description"><?php _e( 'Full language name here.', 'sp' ); ?></p></td></tr>
					<tr valign="top"><th scope="row"><?php _e( 'Language Flag URL', 'sp' ); ?></th><td><input id="lang_edit_flag" type="text" size="100" /><p class="description"><?php _e( 'Flag icon image URL.', 'sp' ); ?></p></td></tr>
					<tr valign="top"><th scope="row"><?php _e( 'Language Date Format', 'sp' ); ?></th><td><input id="lang_edit_date_format" type="text" /><p class="description"><?php _e( 'See: <a href="http://codex.wordpress.org/Formatting_Date_and_Time">Codex - Formatting Date and Time</a>.', 'sp' ); ?></p></td></tr>
					<tr valign="top"><th scope="row"><?php _e( 'Language Time Format', 'sp' ); ?></th><td><input id="lang_edit_time_format" type="text" /><p class="description"><?php _e( 'See: <a href="http://codex.wordpress.org/Formatting_Date_and_Time">Codex - Formatting Date and Time</a>.', 'sp' ); ?></p></td></tr>
				</tbody></table>
				<p class="submit"><a href="#" class="btn_lang_edit_save button"><?php _e( 'Save', 'sp' ); ?></a>
				<a href="#" class="btn_lang_edit_cancel button"><?php _e( 'Cancel', 'sp' ); ?></a>
				<a href="#" class="btn_lang_edit_add button"><?php _e( 'Add', 'sp' ); ?></a></p>
			</div>

			<h3><?php _e( 'Additional Settings', 'sp' ); ?></h3>

			<form method="post" action="options.php" class="sp-multilingual-form">
				<?php settings_fields( 'sp_multilingual' ); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Current Logged User Language', 'sp' ); ?></th>
						<td>
							<select name="user_locale">
							<?php global $_sp_ml_locale_list; foreach ( $_sp_ml_locale_list as $locale_code => $l ) : ?>
							<option value="<?php echo esc_attr( $locale_code ); ?>"<?php selected( $locale_code, get_user_meta( get_current_user_id(), 'sp_language', true ) ); ?>><?php echo esc_html( $l['name'] ); ?></option>
							<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'URL Query Mode', 'sp' ); ?></th>
						<td>
							<label><input name="sp_ml_opt_main[query_mode]" type="radio" value="parameter"<?php checked( 'parameter', $sp_ml_opt_main['query_mode'] ); ?> /> URL Parameter</label><br />
							<label><input name="sp_ml_opt_main[query_mode]" type="radio" value="rewrite"<?php checked( 'rewrite', $sp_ml_opt_main['query_mode'] ); ?> /> URL Rewrite</label><br />
							<label><input name="sp_ml_opt_main[query_mode]" type="radio" value="cookies"<?php checked( 'cookies', $sp_ml_opt_main['query_mode'] ); ?> /> Cookies</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Auto detect browser language', 'sp' ); ?></th>
						<td>
							<label><input name="sp_ml_opt_main[detect_browser_language]" type="radio" value="1"<?php checked( '1', $sp_ml_opt_main['detect_browser_language'] ); ?> /> Yes</label><br />
							<label><input name="sp_ml_opt_main[detect_browser_language]" type="radio" value="0"<?php checked( '0', $sp_ml_opt_main['detect_browser_language'] ); ?> /> No</label>
							<p class="description"><?php _e( 'Using language automatically detected from browser.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php if ( ! isset( $this->c['post_type'] ) ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Content types to enable multilingual', 'sp' ); ?></th>
						<td>
							<select name="sp_ml_opt_main[post_types]" multiple="multiple">
								<?php
									$post_types_tmp = get_post_types( array(), 'objects' );
									if ( $post_types_tmp )
										foreach ( $post_types_tmp as $post_type )
											printf( '<option value="%s">%s</option>', esc_attr( $post_type->name ), esc_html( $post_type->label ) );
								?>
							</select>
							<p class="description"><?php _e( 'Hold Ctrl to select multi options.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ( ! isset( $this->c['taxonomy'] ) ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Content categories to enable multilingual', 'sp' ); ?></th>
						<td>
							<select name="sp_ml_opt_main[taxonomies]" multiple="multiple">
								<?php
									$taxonomies_tmp = get_taxonomies( array(), 'objects' );
									if ( $taxonomies_tmp )
										foreach ( $taxonomies_tmp as $taxonomy ) {
											$object_type = sizeof( $taxonomy->object_type ) ? get_post_type_object( reset( $taxonomy->object_type ) ) : null;
											if ( ! is_null( $object_type ) )
												printf( '<option value="%s">%s</option>', esc_attr( $taxonomy->name ),
													esc_html( $taxonomy->label ) . ' (' . esc_html( $object_type->label ) . ')' );
										}
								?>
							</select>
							<p class="description"><?php _e( 'Hold Ctrl to select multi options.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
				</table>
				<?php submit_button( __( 'Save Changes', 'sp' ) ); ?>
			</form>

		</div>
		<?php
	}

	function init_settings() {
		$sp_ml_opt_main = get_option( 'sp_ml_opt_main' );
		if ( false == $sp_ml_opt_main || 0 == sizeof( $sp_ml_opt_main ) ) {
			update_option( 'sp_ml_opt_main', $this->dc );
		}
	}

	function admin_save_user_language() {
		if ( isset( $_REQUEST['action'] ) && 'update' == $_REQUEST['action'] && isset( $_REQUEST['option_page'] ) && 'sp_multilingual' == $_REQUEST['option_page'] ) {
			$locale_code = $_REQUEST['user_locale'];
			update_user_meta( get_current_user_id(), 'sp_language', $locale_code );
		}
	}

	function admin_apply_user_language( $locale ) {
		$locale_code = get_user_meta( get_current_user_id(), 'sp_language', true );
		if ( ! empty( $locale_code ) )
			return $locale_code;
		return $locale;
	}

	// ==================== post edit ====================

	function pe_add_meta_boxes( $post_type, $post ) {
		// do not show multilanguage meta box if not enabled in current post type
		if ( isset( $this->c['post_type'] ) )
			if ( ! in_array( $post_type, (array) $this->c['post_type'] ) )
				return false;
		add_meta_box( '_sp_ml_metabox', __( 'Multilingual', 'sp' ), array( $this, 'pe_do_metabox' ), $post_type,
						'side', 'default' );
	}

	function pe_do_metabox( $post ) {
		echo '<div id="sp-ml-post-edit-metabox">';
		echo '<h4>' . __( 'Languages Selector:', 'sp' ) . '</h4>';
		echo '<ul class="sp-ml-lang-tabs-custom" id="sp-pe-multilingual-selector">';
		foreach( sp_get_enabled_languages() as $lang_code => $l ) {
			printf( '<li><a href="#" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" />%s</a></li>',
				esc_attr( $l['name'] ),
				esc_attr( $lang_code ),
				'button sp-ml-lang-tab-' . $lang_code,
				esc_attr( $l['flag'] ),
				esc_attr( $lang_code ),
				'&nbsp;&nbsp;' . esc_html( $l['name'] )
			);
		}
		echo '</ul></div>';
	}

	function pe_fields_do_html() {
		global $post;
		$post_type = get_post_type( $post );
		// do not add multilanguage fields if not enabled in current post type
		if ( isset( $this->c['post_type'] ) )
			if ( ! in_array( $post_type, (array) $this->c['post_type'] ) )
				return false;
		foreach( sp_get_enabled_languages_ids() as $l ) {
			$post_title   = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_title',   $l ) : '' );
			$post_content = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_content', $l ) : '' );
			$post_excerpt = ( isset( $_GET['post'] ) ? sp_ml_ext_post_field( $_GET['post'], 'post_excerpt', $l ) : '' );
			// post title field
			if ( post_type_supports( $post_type, 'title' ) ) {
				echo '<div class="sp-pe-one-field-post_title-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
				echo '<input type="text" name="post_title'.SP_META_LANG_PREFIX.$l.'" id="post_title'.SP_META_LANG_PREFIX.$l.'" size="30" value="'.esc_attr( $post_title ).'" autocomplete="off" />';
				echo '</div>';
			}
			// post content field
			if ( post_type_supports( $post_type, 'editor' ) ) {
				echo '<div class="sp-pe-one-field-post_content-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
				wp_editor( $post_content, 'post_content'.SP_META_LANG_PREFIX.$l, array(
					'textarea_name' => 'post_content'.SP_META_LANG_PREFIX.$l,
					'dfw' => true,
					'tabfocus_elements' => 'insert-media-button,save-post',
					'editor_height' => 360,
				) );
				echo '</div>';
			}
			// post excerpt field
			if ( post_type_supports( $post_type, 'excerpt' ) ) {
				echo '<div class="sp-pe-one-field-post_excerpt-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
				echo '<textarea rows="1" cols="40" name="post_excerpt'.SP_META_LANG_PREFIX.$l.'" id="post_excerpt'.SP_META_LANG_PREFIX.$l.'">' . esc_textarea( $post_excerpt ) . '</textarea>';
				echo '</div>';
			}
		}
	}

	function pe_save_post( $post_id ) {
		$post_type = get_post_type( $post_id );
		// ignore if no-multilingual post type
		if ( isset( $this->c['post_type'] ) )
			if ( ! in_array( $post_type, (array) $this->c['post_type'] ) )
				return false;
		// write datebase
		foreach( sp_get_enabled_languages_ids() as $l ) {
			if ( isset( $_POST['post_title'.SP_META_LANG_PREFIX.$l] ) )
				update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_title'.SP_META_LANG_PREFIX.$l, $_POST['post_title'.SP_META_LANG_PREFIX.$l] );
			if ( isset( $_POST['post_content'.SP_META_LANG_PREFIX.$l] ) )
				update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_content'.SP_META_LANG_PREFIX.$l, $_POST['post_content'.SP_META_LANG_PREFIX.$l] );
			if ( isset( $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] ) )
				update_post_meta( $post_id, SP_CUSTOM_META_PRI_PREFIX.'post_excerpt'.SP_META_LANG_PREFIX.$l, $_POST['post_excerpt'.SP_META_LANG_PREFIX.$l] );
		}
		global $wpdb;
		$wpdb->update( $wpdb->posts, array(
			'post_title'   => isset( $_POST['post_title'  .SP_META_LANG_PREFIX.sp_get_default_language()] ) ?
				$_POST['post_title'  .SP_META_LANG_PREFIX.sp_get_default_language()] : null,
			'post_content' => isset( $_POST['post_content'  .SP_META_LANG_PREFIX.sp_get_default_language()] ) ?
				$_POST['post_content'  .SP_META_LANG_PREFIX.sp_get_default_language()] : null,
			'post_excerpt' => isset( $_POST['post_excerpt'  .SP_META_LANG_PREFIX.sp_get_default_language()] ) ?
				$_POST['post_excerpt'  .SP_META_LANG_PREFIX.sp_get_default_language()] : null,
		), array( 'ID' => $post_id ) );
	}

	// ==================== term edit ====================

	function te_term_add_fields_do_html( $taxonomy ) {
		foreach( sp_get_enabled_languages_ids() as $l ) {
			// term name
			echo '<div class="sp-te-one-field-name-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
			echo '<input name="name'.SP_META_LANG_PREFIX.$l.'" tyte="text" value="" size="40" aria-required="true" />';
			echo '</div>';
			// term description
			echo '<div class="sp-te-one-field-description-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
			echo '<textarea name="description'.SP_META_LANG_PREFIX.$l.'" rows="5" cols="50" class="large-text"></textarea>';
			echo '</div>';
		}
		// languages selector
		echo '<div class="sp-te-multilingual-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_lang_selector_admin() . '</div>';
	}

	function te_term_edit_fields_do_html( $term, $taxonomy ) {
		foreach( sp_get_enabled_languages_ids() as $l ) {
			// get field data
			$term_name = sp_ml_ext_term_field( $term->term_id, $taxonomy, 'name', $l );
			$term_description = sp_ml_ext_term_field( $term->term_id, $taxonomy, 'description', $l );
			// term name
			echo '<div class="sp-te-one-field-name-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
			echo '<input name="name'.SP_META_LANG_PREFIX.$l.'" tyte="text" value="'.esc_attr($term_name).'" size="40" aria-required="true" />';
			echo '</div>';
			// term description
			echo '<div class="sp-te-one-field-description-l sp-te-one-field-l sp-te-one-field-l-'.$l.'">';
			echo '<textarea name="description'.SP_META_LANG_PREFIX.$l.'" rows="5" cols="50" class="large-text">'.esc_textarea($term_description).'</textarea>';
			echo '</div>';
		}
		// languages selector
		echo '<div class="sp-te-multilingual-selector"><strong>' . __( 'Languages: ', 'sp' ) . '</strong>' . _sp_lang_selector_admin() . '</div>';
	}

	function te_save_term( $term_id, $tt_id ) {
		// write datebase
		foreach( sp_get_enabled_languages_ids() as $l ) {
			if ( isset( $_POST['name'       .SP_META_LANG_PREFIX.$l] ) )
				sp_update_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.'name'       .SP_META_LANG_PREFIX.$l, $_POST['name'       .SP_META_LANG_PREFIX.$l] );
			if ( isset( $_POST['description'.SP_META_LANG_PREFIX.$l] ) )
				sp_update_term_meta( $term_id, SP_CUSTOM_META_PRI_PREFIX.'description'.SP_META_LANG_PREFIX.$l, $_POST['description'.SP_META_LANG_PREFIX.$l] );
		}
		global $wpdb;
		$wpdb->update( $wpdb->terms,         array( 'name'        => isset( $_POST['name'       .SP_META_LANG_PREFIX.sp_get_default_language()] ) ?
			$_POST['name'       .SP_META_LANG_PREFIX.sp_get_default_language()] : null ), array( 'term_id'          => $term_id ) );
		$wpdb->update( $wpdb->term_taxonomy, array( 'description' => isset( $_POST['description'.SP_META_LANG_PREFIX.sp_get_default_language()] ) ?
			$_POST['description'.SP_META_LANG_PREFIX.sp_get_default_language()] : null ), array( 'term_taxonomy_id' => $tt_id ) );
	}

	// ==================== hooks: general ====================

	function hook_ext_post_title( $title, $post_id ) {
		$post_type = get_post_type( $post_id );
		// ignore unnecessary post types
		if ( in_array( $post_type, array( 'nav_menu_item', 'attachment' ) ) )
			return $title;
		else
			return sp_ml_ext_post_field( $post_id, 'post_title' );
	}
	function hook_ext_post_content( $content ) {
		global $post; return sp_ml_ext_post_field( $post->ID, 'post_content' );
	}
	function hook_ext_post_excerpt( $excerpt ) {
		global $post; return sp_ml_ext_post_field( $post->ID, 'post_excerpt' );
	}
	function hook_apply_date_format( $date_format_old ) {

		return $date_format_old;
	}
	function hook_apply_time_format( $time_format_old ) {

		return $time_format_old;
	}

	// ==================== hooks: nav menus ====================

	function hook_menus_config_filter( $menus ) {
		$menus_new = array();
		foreach ( sp_get_enabled_languages() as $lang_code => $l )
			foreach ( $menus as $menu_id => $menu_name )
				$menus_new[$menu_id.'-'.$lang_code] = $menu_name.' ['.$l['name'].']';
		return $menus_new;
	}

	// ==================== hooks: options panel ====================

	function hook_cm_one_name_filter( $html, $enabled_ml ) {
		if ( $enabled_ml )
			return $html . _sp_lang_selector_admin();
		else
			return $html;
	}

	function hook_op_option_name_filter( $option_name, $lang = '' ) {
		if ( ! empty( $lang ) )
			return $option_name . SP_META_LANG_PREFIX . $lang;
		return $option_name;
	}

	function hook_op_header_footer() {
		echo _sp_lang_selector_admin();
	}

	function hook_op_register_setting( $option_group, $option_name, $option ) {
		if ( ! isset( $option['ml'] ) || ( isset( $option['ml'] ) && $option['ml'] ) )
			foreach( sp_get_enabled_languages_ids() as $l ) {
				register_setting( $option_group, $option_name . SP_META_LANG_PREFIX . $l );
			}
	}

	// ==================== hooks: post custom meta ====================

	function hook_meta_key_filter( $meta_key, $post_id, $lang ) {
		if ( ! empty( $lang ) )
			return $meta_key . SP_META_LANG_PREFIX . $lang;
		return $meta_key;
	}

	function hook_pm_update_postmeta( $meta_key, $field, $post_id, $is_ml ) {
		if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
			foreach( sp_get_enabled_languages_ids() as $l ) {
				$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
					$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
				update_post_meta( $post_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
			}
	}

	// ==================== hooks: taxonomy custom meta ====================

	function hook_tm_update_termmeta( $meta_key, $field, $term_id, $is_ml ) {
		if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
			foreach( sp_get_enabled_languages_ids() as $l ) {
				$data = isset( $_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ?
					$_POST[SP_CUSTOM_META_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] : '';
				sp_update_term_meta( $term_id, $meta_key . SP_META_LANG_PREFIX . $l, $data );
			}
	}

	// ==================== enqueue scripts and stylesheets ====================

	function enqueue_assets_frontpage() {

		wp_enqueue_script( 'sp.' . $this->slug . '.frontpage', $this->get_module_uri() . '/sp.' . $this->slug . '.frontpage.js', array( 'jquery' ), false, true );

		$params = array(
			'current' => sp_lang(),
			'enabled' => sp_get_enabled_languages_ids(),
			'default' => sp_get_default_language(),
		);
		wp_localize_script( 'sp.' . $this->slug . '.frontpage', 'sp_multilingual', $params );

	}

	function enqueue_assets_dashboard() {

		wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'fontawesome-ie7' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

		$params = array(
			'current'   => sp_lang(),
			'languages' => sp_get_languages(),
			'enabled'   => sp_get_enabled_languages_ids(),
			'default'   => sp_get_default_language(),
		);
		wp_localize_script( 'sp.' . $this->slug . '.dashboard', 'sp_multilingual', $params );

	}

}

new SP_Multilingual();


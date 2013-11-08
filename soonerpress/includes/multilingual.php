<?php
/**
 * Multilingual module API
 *
 * @package SoonerPress
 * @subpackage Multilingual
 */

if ( ! defined( 'IN_SP' ) ) exit;


/** get current language */
function sp_lang() {
	$locale = get_user_meta( get_current_user_id(), '_sp_language', true );
	if ( ! in_array( $locale, sp_get_enabled_languages_locales() ) )
		$locale = sp_get_default_language();
	return $locale;
}

function sp_ml_convert_url( $url, $locale = '' ) {
	if ( empty( $locale ) )
		$locale = sp_lang();
	switch ( sp_ml_get_query_mode() ) {
		case 'parameter':
			$url = add_query_arg( 'lang', $locale, $url );
			break;
		// case 'rewrite':
		// 	$url = home_url('/') . $locale . '/' . str_replace( home_url('/'), null, $url );
		// 	break;
	}
	return $url;
}

function sp_selected_language() {
	switch ( sp_ml_get_query_mode() ) {
		case 'parameter':
			$locale = isset( $_GET['lang'] ) ? $_GET['lang'] : sp_get_default_language();
			break;
		// case 'rewrite':
		// 	$url_tmp = str_replace( home_url('/'), null, sp_current_url() );
		// 	$locale = substr( $url_tmp, 0, strpos( $url_tmp, '/' ) );
		// 	break;
		default:
			$locale = isset( $_COOKIE['lang'] ) ? $_COOKIE['lang'] : null;
	}
	if ( in_array( $locale, sp_get_enabled_languages_locales() ) ) {
		return $locale;
	}
	return false;
}

/** languages selector HTML output */
function sp_lang_selector( $args = array(), $echo = false ) {
	$output = '';
	$s = wp_parse_args( $args, array(
		'link'            => null,
		'container_class' => 'sp-ml-lang-tabs',
		'button_class'    => 'sp-ml-lang-tab',
		'type'            => 'select',
		'separator'       => ' | ',
	) );
	$languages = sp_get_enabled_languages();
	$output .= '<span class="sp_lang_selector '.esc_attr( $s['container_class'] ).' sp-ml-lang-tabs-'.esc_attr( $s['type'] ).'">';
	switch( $s['type'] ) {
		case 'select':
			$output .= '<select>';
			foreach( $languages as $locale_code => $l ) {
				$output .= sprintf( '<option value="%s">%s</option>',
					esc_attr( $locale_code ),
					esc_html( $l['name'] )
				);
			}
			$output .= '</select>';
			break;
		case 'text':
			foreach( $languages as $locale_code => $l ) {
				if ( 'cookies' == sp_ml_get_query_mode() )
					$url = '#';
				elseif ( empty( $s['link'] ) )
					$url = sp_ml_convert_url( sp_current_url(), $locale_code );
				else
					$url = $s['link'];
				$output .= sprintf( '<a href="%s" title="%s" data-lang="%s" class="%s">%s</a>',
					esc_attr( $url ),
					esc_attr( $l['name'] ),
					esc_attr( $locale_code ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $locale_code ),
					esc_html( $l['name'] )
				);
				end( $languages );
				if ( $locale_code != key( $languages ) )
					$output .= $s['separator'];
			}
			break;
		case 'img':
			foreach( $languages as $locale_code => $l ) {
				if ( 'cookies' == sp_ml_get_query_mode() )
					$url = '#';
				elseif ( empty( $s['link'] ) )
					$url = sp_ml_convert_url( sp_current_url(), $locale_code );
				else
					$url = $s['link'];
				$output .= sprintf( '<a href="%s" title="%s" data-lang="%s" class="%s"><img src="%s" alt="%s" align="absmiddle" /></a>',
					esc_attr( $url ),
					esc_attr( $l['name'] ),
					esc_attr( $locale_code ),
					esc_attr( $s['button_class'] . ' ' . $s['button_class'] . '-' . $locale_code ),
					esc_attr( $l['flag'] ),
					esc_attr( $locale_code )
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
	return sp_lang_selector( array( 'type' => 'img', 'link' => '#' ), false );
}

/**
 * get enabled languages list. each entry includes id, name and flag url
 *
 * @uses sp_get_enabled_languages_locales() get languages ids to map
 * @return array|false languages array of false if no data retrieved
 */
function sp_get_enabled_languages() {
	if ( sizeof( sp_get_enabled_languages_locales() ) ) {
		foreach ( sp_get_enabled_languages_locales() as $lang_code ) {
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
function sp_get_enabled_languages_locales() {
	$sp_ml_opt = get_option( 'sp_ml_opt' );
	if ( isset( $sp_ml_opt['enabled'] ) )
		return (array) $sp_ml_opt['enabled'];
	return array();
}

/**
 * get the default language id
 * 
 * @return string locale code
 */
function sp_get_default_language() {
	$sp_ml_opt = get_option( 'sp_ml_opt' );
	if ( isset( $sp_ml_opt['default'] ) )
		return $sp_ml_opt['default'];
	return false;
}

/**
 * get specified language data from database
 * 
 * @param  string $locale_code language id
 * @return array|false language data or false if no data retrieved
 */
function sp_get_language( $locale_code ) {
	$languages = sp_get_languages();
	if ( false !== $languages && isset( $languages[$locale_code] ) )
		return $languages[$locale_code];
	return false;
}

/**
 * get all existing languages from database
 *
 * @uses $sp_config Multilingual module configuration
 * @return array|false languages data or false if no data retrieved
 */
function sp_get_languages() {
	global $sp_config;
	if ( isset( $sp_config['multilingual']['languages'] ) )
		return $sp_config['multilingual']['languages'];
	return false;
}

function sp_ml_get_query_mode() {
	$sp_ml_opt = get_option( 'sp_ml_opt' );
	return $sp_ml_opt['query_mode'];
}

function sp_is_post_type_ml( $post_type ) {
	$sp_ml_opt = get_option( 'sp_ml_opt' );
	return in_array( $post_type, (array) $sp_ml_opt['post_type'] );
}

function sp_is_taxonomy_ml( $taxonomy ) {
	$sp_ml_opt = get_option( 'sp_ml_opt' );
	return in_array( $taxonomy, (array) $sp_ml_opt['taxonomy'] );
}

function sp_ml_ext_post_field( $post_id, $field, $locale = '' ) {
	if ( empty( $locale ) )
		$locale = sp_lang();
	$post = get_post( intval( $post_id ) );
	if ( $post && in_array( $field, array( 'post_title', 'post_content', 'post_excerpt' ) ) ) {
		return get_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$locale, true );
	}
	return null;
}

function sp_ml_ext_term_field( $term_id, $taxonomy, $field, $locale = '' ) {
	if ( empty( $locale ) )
		$locale = sp_lang();
	$term = get_term( intval( $term_id ), $taxonomy );
	if ( ! is_a( $term, 'WP_Error' ) && in_array( $field, array( 'name', 'description' ) ) ) {
		return sp_get_term_meta( $term_id, SP_CUSTOM_FIELDS_PRI_PREFIX.$field.SP_META_LANG_PREFIX.$locale );
	}
	return null;
}


class SP_Multilingual extends SP_Module {

	function __construct() {
		$this->dc = array(
			'options_main'                       => array(),
			'allow_options_menu'                 => true,
			'allow_options_query_mode'           => true,
			'allow_options_detect_browser'       => true,
			'allow_options_download_wp_messages' => true,
			'allow_options_post_type'            => true,
			'allow_options_taxonomy'             => true,
		);
		$this->init( 'multilingual' );
		$this->c['options'] = wp_parse_args( $this->c['options_main'], array(
			'enabled'                 => array( 'en_US', 'zh_CN', 'de_DE' ),
			'default'                 => 'en_US',
			'query_mode'              => 'cookies',
			'detect_browser_language' => '1',
		) );
		$this->init_settings();
		// WordPress i18n
		$this->update_user_language_instantly();
		add_action( 'locale'                       , array( $this, 'apply_user_language' ) );
		$this->sp_reload_theme_textdomain_early();
		add_action( 'after_setup_theme'            , array( $this, 'reload_default_textdomain' ) );
		// admin menu
		add_action( 'admin_menu'                   , array( $this, 'add_admin_menu') );
		add_action( 'after_setup_theme'            , array( $this, 'admin_save_settings' ) );
		add_action( 'admin_bar_menu'               , array( $this, 'admin_bar_menu_languages' ), 100 );
		// post edit
		add_action( 'add_meta_boxes'               , array( $this, 'pe_add_meta_boxes' ), 10, 2 );
		add_action( 'edit_form_after_editor'       , array( $this, 'pe_fields_do_html' ) );
		add_action( 'save_post'                    , array( $this, 'pe_save_post' ), 10, 2 );
		// term edit
		add_action( 'admin_init'                   , array( $this, 'te_admin_init' ) );
		// hooks: general
		add_filter( 'the_title'                    , array( $this, 'hook_ext_post_title' ), 0, 2 );
		add_filter( 'the_content'                  , array( $this, 'hook_ext_post_content' ), 0, 1 );
		add_filter( 'the_excerpt'                  , array( $this, 'hook_ext_post_excerpt' ), 0, 1 );
		add_filter( 'the_excerpt_rss'              , array( $this, 'hook_ext_post_excerpt' ), 0, 1 );
		add_filter( 'woocommerce_short_description', array( $this, 'hook_ext_post_excerpt' ) );
		add_filter( 'option_date_format'           , array( $this, 'hook_apply_date_format' ) );
		add_filter( 'option_time_format'           , array( $this, 'hook_apply_time_format' ) );
		add_filter( 'get_term'                     , array( $this, 'hook_get_term' ) );
		add_filter( 'get_terms'                    , array( $this, 'hook_get_terms' ) );
		add_filter( 'get_the_terms'                , array( $this, 'hook_get_terms' ) );
		// hooks: nav menus
		add_filter( 'sp_register_nav_menus'        , array( $this, 'hook_menus_config_filter' ) );
		// hooks: options panel
		add_filter( 'sp_option_name'               , array( $this, 'hook_op_option_name_filter' ), 10, 2 );
		add_action( 'sp_op_header'                 , array( $this, 'hook_op_header_footer' ) );
		add_action( 'sp_op_footer'                 , array( $this, 'hook_op_header_footer' ) );
		add_filter( 'sp_op_one_name'               , array( $this, 'hook_cf_one_name_filter' ), 10, 2 );
		add_action( 'sp_op_register_setting'       , array( $this, 'hook_op_register_setting' ), 10, 3 );
		// hooks: post custom fields
		add_filter( 'sp_pm_meta_key'               , array( $this, 'hook_meta_key_filter' ), 10, 3 );
		add_filter( 'sp_pm_one_name'               , array( $this, 'hook_cf_one_name_filter' ), 10, 2 );
		add_action( 'sp_pm_update_postmeta'        , array( $this, 'hook_pm_update_postmeta' ), 10, 4 );
		// hooks: taxonomy custom fields
		add_filter( 'sp_tm_meta_key'               , array( $this, 'hook_meta_key_filter' ), 10, 3 );
		add_filter( 'sp_tm_one_name'               , array( $this, 'hook_cf_one_name_filter' ), 10, 2 );
		add_action( 'sp_tm_update_termmeta'        , array( $this, 'hook_tm_update_termmeta' ), 10, 4 );
		// hooks: user custom fields
		add_filter( 'sp_um_meta_key'               , array( $this, 'hook_meta_key_filter' ), 10, 3 );
		add_filter( 'sp_um_one_name'               , array( $this, 'hook_cf_one_name_filter' ), 10, 2 );
		add_action( 'sp_um_update_usermeta'        , array( $this, 'hook_um_update_usermeta' ), 10, 4 );
		}

	// ==================== admin menu ====================

	function add_admin_menu() {
		if ( $this->c['allow_options_menu'] )
			add_menu_page( __( 'Languages Settings', 'sp' ), __( 'Languages', 'sp' ), 'manage_options', 'multilingual', array( $this, 'admin_menu_do_html' ), false, 120 );
	}

	function admin_menu_do_html() {
		$page_title = get_admin_page_title();
		$sp_ml_opt = get_option( 'sp_ml_opt' );
		?>
		<div class="wrap sp-wrap sp-multilingual">

			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php echo esc_html( $page_title ); ?></h2>

			<?php sp_msg( 'dashboard' ); ?>

			<h3><?php _e( 'Languages', 'sp' ); ?></h3>

			<table id="sp_ml_opt_langs_list" class="widefat">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col"><?php _e( 'Flag', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Name', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Edit', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Default?', 'sp' ); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col"></th>
					<th scope="col"><?php _e( 'Flag', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Name', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Edit', 'sp' ); ?></th>
					<th scope="col"><?php _e( 'Default?', 'sp' ); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<tr class="lang_one sp_list_one_tpl">
					<td class="lang_flag"><img src="" /></td>
					<td class="lang_name"></td>
					<td class="lang_ctrl_edit"><a href="#" class="btn_lang_one_delete button"><?php _e( 'Delete', 'sp' ); ?></a></td>
					<td class="lang_ctrl_default"><span class="sp_text_default"><?php _e( '(Default)', 'sp' ); ?></span>
					<a href="#" class="btn_lang_one_set_default button"><?php _e( 'Make Default', 'sp' ); ?></a></td>
				</tr>
			</tbody>
			</table>

			<div id="lang_add">
				<h3 class="lang_add_title"><?php _e( 'Add a Language', 'sp' ); ?></h3>
				<table class="form-table"><tbody>
					<tr><td>
						<select id="lang_add_name" type="text">
							<?php foreach ( $this->c['languages'] as $lang_code => $lang ) : ?>
							<option value="<?php echo $lang_code; ?>"><?php echo esc_html( $lang['title'] ); ?></option>
							<?php endforeach; ?>
						</select>
						<a href="#" class="btn_lang_add_add button"><?php _e( 'Add', 'sp' ); ?></a></p>
						<!-- <p class="description"><?php _e( 'Select a language here.', 'sp' ); ?></p> -->
					</td></tr>
				</tbody></table>
			</div>

			<h3><?php _e( 'Settings', 'sp' ); ?></h3>

			<form id="sp-ml-settings" method="post" action="">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Current Logged User Language', 'sp' ); ?></th>
						<td>
							<select name="user_locale">
							<?php foreach ( sp_get_enabled_languages() as $locale_code => $l ) : ?>
							<option value="<?php echo esc_attr( $locale_code ); ?>"<?php selected( $locale_code, sp_lang() ); ?>><?php echo esc_html( $l['name'] ); ?></option>
							<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<?php if ( $this->c['allow_options_query_mode'] ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'URL Query Mode', 'sp' ); ?></th>
						<td>
							<label><input name="sp_ml_opt[query_mode]" type="radio" value="parameter"<?php checked( 'parameter', $sp_ml_opt['query_mode'] ); ?> /> <?php _e( 'URL Parameter', 'sp' ); ?></label><br />
							<!-- <label><input name="sp_ml_opt[query_mode]" type="radio" value="rewrite"<?php checked( 'rewrite', $sp_ml_opt['query_mode'] ); ?> /> <?php _e( 'URL Rewrite', 'sp' ); ?></label><br /> -->
							<label><input name="sp_ml_opt[query_mode]" type="radio" value="cookies"<?php checked( 'cookies', $sp_ml_opt['query_mode'] ); ?> /> <?php _e( 'Cookies', 'sp' ); ?></label>
							<p class="description"><strong><?php _e( 'URL Parameter: ', 'sp' ); ?></strong><?php _e( 'All URLs will be added a query arg "lang", example: <code>http://www.example.com/about/?lang=en_US</code>.', 'sp' ); ?><br />
								<strong><?php _e( 'URL Rewrite: ', 'sp' ); ?></strong><?php _e( 'All URLs will be added a language name prefix, example: <code>http://www.example.com/en/about/</code>.', 'sp' ); ?><br />
								<strong><?php _e( 'Cookies: ', 'sp' ); ?></strong><?php _e( 'Using only cookies to stored language, no changes to URLs.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ( $this->c['allow_options_detect_browser'] ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Auto detect browser language', 'sp' ); ?></th>
						<td>
							<label><input name="sp_ml_opt[detect_browser_language]" type="radio" value="1"<?php checked( '1', $sp_ml_opt['detect_browser_language'] ); ?> /> <?php _e( 'Yes', 'sp' ); ?></label><br />
							<label><input name="sp_ml_opt[detect_browser_language]" type="radio" value="0"<?php checked( '0', $sp_ml_opt['detect_browser_language'] ); ?> /> <?php _e( 'No', 'sp' ); ?></label>
							<p class="description"><?php _e( 'Using language automatically detected from browser.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ( $this->c['allow_options_post_type'] ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Content types to enable multilingual', 'sp' ); ?></th>
						<td>
							<?php
								$post_types_tmp = get_post_types( array(), 'objects' );
								if ( $post_types_tmp )
									foreach ( $post_types_tmp as $post_type ) {
										if ( in_array( $post_type->name, array( 'nav_menu_item', 'attachment', 'revision' ) ) )
											continue;
										printf( '<label><input type="checkbox" name="sp_ml_opt[post_type][]" value="%s"%s> %s</label><br />', esc_attr( $post_type->name ),
											in_array( $post_type->name, $sp_ml_opt['post_type'] ) ? ' checked="checked"' : null, esc_html( $post_type->label ) );
									}
							?>
							<p class="description"><?php _e( 'Hold Ctrl to select multi options.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ( $this->c['allow_options_taxonomy'] ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'Content categories to enable multilingual', 'sp' ); ?></th>
						<td>
							<?php
								$taxonomies_tmp = get_taxonomies( array(), 'objects' );
								if ( $taxonomies_tmp )
									foreach ( $taxonomies_tmp as $taxonomy ) {
										if ( in_array( $taxonomy->name, array( 'nav_menu', 'link_category', 'post_format' ) ) )
											continue;
										$object_type = sizeof( $taxonomy->object_type ) ? get_post_type_object( reset( $taxonomy->object_type ) ) : null;
										if ( ! is_null( $object_type ) )
											printf( '<label><input type="checkbox" name="sp_ml_opt[taxonomy][]" value="%s"%s> %s</label><br />', esc_attr( $taxonomy->name ),
												in_array( $taxonomy->name, $sp_ml_opt['taxonomy'] ) ? ' checked="checked"' : null,
												esc_html( $taxonomy->label ) . ' (' . esc_html( $object_type->label ) . ')' );
									}
							?>
							<p class="description"><?php _e( 'Hold Ctrl to select multi options.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ( $this->c['allow_options_download_wp_messages'] ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e( 'WordPress Localization', 'sp' ); ?></th>
						<td>
							<?php
							foreach ( sp_get_enabled_languages_locales() as $locale_code ) {
								if ( ! $this->wordpress_i18n_exists( $locale_code ) ) {
									$i18n_download_required = true;
									$l = sp_get_language( $locale_code );
									?>
									<label><input name="sp_multilingual_i18n_download[]" type="checkbox" value="<?php echo esc_attr( $locale_code ); ?>" /> <strong><?php echo __( 'Download Language: ', 'sp' ) . esc_html( $l['title'] ); ?></strong></label><br />
									<?php
								}
							}
							if ( ! isset( $i18n_download_required ) ) {
								?>
								<?php _e( 'No downloads required.', 'sp' ); ?>
								<?php
							}
							?>
							<p class="description"><?php _e( 'The option help you to apply specified language to WordPress translations.', 'sp' ); ?></p>
						</td>
					</tr>
					<?php endif; ?>
				</table>
				<?php sp_output_url_query_vars_form(); ?>
				<input name="action" type="hidden" value="sp_ml_save_settings" />
				<?php submit_button( __( 'Save Changes', 'sp' ) ); ?>
			</form>

		</div>
		<?php
	}

	function init_settings() {
		$sp_ml_opt = get_option( 'sp_ml_opt' );
		update_option( 'sp_ml_opt', sp_merge_args( $sp_ml_opt, $this->c['options'] ) );
	}

	function admin_save_settings() {
		if ( is_admin() && isset( $_POST['action'] ) && 'sp_ml_save_settings' == $_POST['action'] ) {
			update_option( 'sp_ml_opt', $_POST['sp_ml_opt'] );
			if ( isset( $_REQUEST['user_locale'] ) )
				$this->update_user_language( $_REQUEST['user_locale'] );
			add_action( 'admin_init', array( $this, 'admin_download_wordpress_l10n_messages' ) );
			sp_msg_add( __( 'Options saved.', 'sp' ) );
		}
	}

	function admin_bar_menu_languages( $wp_admin_bar ) {
		$wp_admin_bar->add_menu( array(
			'id' => 'sp_ml_admin_bar_lang_selector',
			'parent' => false,
			'title' => __( 'Languages', 'sp' ),
			'href' => admin_url( 'admin.php?page=multilingual' ),
		) );
		$languages = sp_get_enabled_languages();
		foreach ( $languages as $locale_code => $l ) {
			$wp_admin_bar->add_menu( array(
				'id' => 'sp_ml_admin_bar_lang_selector_' . $locale_code,
				'parent' => 'sp_ml_admin_bar_lang_selector',
				'title' => $l['name'],
				'href' => sp_ml_convert_url( sp_current_url(), $locale_code ),
			) );
		}
	}

	// ==================== WordPress I18N ====================

	function update_user_language_instantly() {
		$locale = sp_selected_language();
		$this->update_user_language( $locale );
		// setcookie( 'lang', $locale, time() + 86400 * 365 );
	}

	function update_user_language( $locale ) {
		update_user_meta( get_current_user_id(), '_sp_language', $locale );
	}

	function apply_user_language( $locale ) {
		return sp_lang();
	}

	function sp_reload_theme_textdomain_early() {
		load_theme_textdomain( 'sp', SP_LANG );
	}

	function reload_default_textdomain() {
		load_default_textdomain();
	}

	function admin_download_wordpress_l10n_messages() {
		if ( is_admin() && isset( $_REQUEST['sp_multilingual_i18n_download'] ) ) {
			$locale_list = wp_parse_args( $_REQUEST['sp_multilingual_i18n_download'] );
			if ( sizeof( $locale_list ) )
				foreach ( $locale_list as $locale ) {
					$this->download_wordpress_l10n_messages( $locale );
					$l = sp_get_language( $locale );
					if ( $this->wordpress_i18n_exists( $locale ) )
						sp_msg_add( __( 'Downloaded successfully: ', 'sp' ) . '<strong>' . $l['title'] . '</strong>' );
					else
						sp_msg_add( __( 'Download failed: ', 'sp' ) . '<strong>' . $l['title'] . '</strong>', 'error' );
				}
		}
	}

	function download_wordpress_l10n_messages( $locale ) {
		$url = 'http://i18n.svn.wordpress.org/' . $locale . '/trunk/messages/';
		$matches = array();
		preg_match_all( '/href\=\"([^\"]+)\"/', file_get_contents( $url ), $matches );
		foreach ( $matches[1] as $filename ) {
			if ( '.po' == strrchr( $filename, '.po' ) || '.mo' == strrchr( $filename, '.mo' ) ) {
				$fileurl = $url . $filename;
				$filetmp = download_url( $fileurl );
				if ( ! file_exists( WP_LANG_DIR ) && ! is_dir( WP_LANG_DIR ) )
					mkdir( WP_LANG_DIR );
				$filetarget = trailingslashit( WP_LANG_DIR ) . $filename;
				if ( file_exists( $filetarget ) )
					@unlink( $filetarget );
				copy( $filetmp, $filetarget );
				unlink( $filetmp );
			}
		}
	}

	function wordpress_i18n_exists( $locale ) {
		if ( 'en_US' == $locale )
			return true;
		return file_exists( trailingslashit( WP_CONTENT_DIR ) . 'languages/' . $locale . '.mo' );
	}

	// ==================== post edit ====================

	function pe_add_meta_boxes( $post_type, $post ) {
		// do not show multilingual meta box if not enabled in current post type
		if ( ! sp_is_post_type_ml( $post_type ) )
			return false;
		add_meta_box( '_sp_ml_metabox', __( 'Multi Languages', 'sp' ), array( $this, 'pe_do_metabox' ), $post_type, 'side', 'default' );
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
		// do not add multilingual fields if not enabled in current post type
		if ( ! sp_is_post_type_ml( $post_type ) )
			return false;
		foreach( sp_get_enabled_languages_locales() as $l ) {
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
			if ( post_type_supports( $post_type, 'excerpt' ) && $post_type != 'product' ) {
				echo '<div class="sp-pe-one-field-post_excerpt-l sp-pe-one-field-l sp-pe-one-field-l-'.$l.'">';
				echo '<textarea rows="1" cols="40" name="post_excerpt'.SP_META_LANG_PREFIX.$l.'" id="post_excerpt'.SP_META_LANG_PREFIX.$l.'">' . esc_textarea( $post_excerpt ) . '</textarea>';
				echo '</div>';
			}
		}
	}

	function pe_save_post( $post_id, $post ) {
		$post_type = get_post_type( $post_id );
		// ignore no-multilingual post type
		if ( ! sp_is_post_type_ml( $post_type ) )
			return false;
		// write datebase
		foreach( sp_get_enabled_languages_locales() as $l ) {
			if ( isset( $_POST['post_title' . SP_META_LANG_PREFIX . $l] ) )
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_title' . SP_META_LANG_PREFIX . $l, $_POST['post_title' . SP_META_LANG_PREFIX . $l] );
			else
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_title' . SP_META_LANG_PREFIX . sp_get_default_language(), $post->post_title );
			if ( isset( $_POST['post_content' . SP_META_LANG_PREFIX . $l] ) )
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_content' . SP_META_LANG_PREFIX . $l, $_POST['post_content' . SP_META_LANG_PREFIX . $l] );
			else
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_content' . SP_META_LANG_PREFIX . sp_get_default_language(), $post->post_content );
			if ( isset( $_POST['post_excerpt' . SP_META_LANG_PREFIX . $l] ) )
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_excerpt' . SP_META_LANG_PREFIX . $l, $_POST['post_excerpt' . SP_META_LANG_PREFIX . $l] );
			else
				update_post_meta( $post_id, SP_CUSTOM_FIELDS_PRI_PREFIX . 'post_excerpt' . SP_META_LANG_PREFIX . sp_get_default_language(), $post->post_excerpt );
		}
	}

	// ==================== term edit ====================

	function te_admin_init() {
		global $wp_taxonomies;
		$taxonomies_ml_tmp = array_keys( $wp_taxonomies );
		foreach( $taxonomies_ml_tmp as $taxonomy ) {
			if ( ! sp_is_taxonomy_ml( $taxonomy ) )
				continue;
			add_action( $taxonomy.'_add_form' , array( $this, 'te_term_add_fields_do_html' ), 10, 1 );
			add_action( $taxonomy.'_edit_form', array( $this, 'te_term_edit_fields_do_html' ), 10, 2 );
			add_action( 'created_'.$taxonomy  , array( $this, 'te_save_term' ), 10, 2 );
			add_action( 'edited_'.$taxonomy   , array( $this, 'te_save_term' ), 10, 2 );
		}
	}

	function te_term_add_fields_do_html( $taxonomy ) {
		foreach( sp_get_enabled_languages_locales() as $l ) {
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
		foreach( sp_get_enabled_languages_locales() as $l ) {
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
		foreach( sp_get_enabled_languages_locales() as $l ) {
			if ( isset( $_POST['name'       .SP_META_LANG_PREFIX.$l] ) )
				sp_update_term_meta( $term_id, SP_CUSTOM_FIELDS_PRI_PREFIX.'name'       .SP_META_LANG_PREFIX.$l, $_POST['name'       .SP_META_LANG_PREFIX.$l] );
			if ( isset( $_POST['description'.SP_META_LANG_PREFIX.$l] ) )
				sp_update_term_meta( $term_id, SP_CUSTOM_FIELDS_PRI_PREFIX.'description'.SP_META_LANG_PREFIX.$l, $_POST['description'.SP_META_LANG_PREFIX.$l] );
		}
	}

	// ==================== hooks: general ====================

	function hook_ext_post_title( $title, $post_id ) {
		$post_type = get_post_type( $post_id );
		// ignore unnecessary post types
		if ( sp_is_post_type_ml( $post_type ) && ! in_array( $post_type, array( 'nav_menu_item', 'attachment' ) ) ) {
			$title_ext = sp_ml_ext_post_field( $post_id, 'post_title' );
			if ( ! empty( $title_ext ) )
				return $title_ext;
		}
		return $title;
	}

	function hook_ext_post_content( $content ) {
		global $post;
		if ( ! sp_is_post_type_ml( get_post_type( $post ) ) )
			return $content;
		else
			return sp_ml_ext_post_field( $post->ID, 'post_content' );
	}

	function hook_ext_post_excerpt( $excerpt ) {
		global $post;
		if ( ! sp_is_post_type_ml( get_post_type( $post ) ) )
			return $excerpt;
		else
			return sp_ml_ext_post_field( $post->ID, 'post_excerpt' );
	}

	function hook_apply_date_format( $date_format ) {
		$lang = sp_get_language( sp_lang() );
		if ( isset( $lang['date_format'] ) && ! empty( $lang['date_format'] ) )
			return $lang['date_format'];
		else
			return $date_format;
	}

	function hook_apply_time_format( $time_format ) {
		$lang = sp_get_language( sp_lang() );
		if ( isset( $lang['time_format'] ) && ! empty( $lang['time_format'] ) )
			return $lang['time_format'];
		else
			return $time_format;
	}

	function hook_get_term( $term ) {
		global $filter; // get_term() arg
		if ( 'raw' == $filter )
			if ( sp_is_taxonomy_ml( $term->taxonomy ) ) {
				$term->name        = sp_ml_ext_term_field( $term->term_id, $term->taxonomy, 'name' );
				$term->description = sp_ml_ext_term_field( $term->term_id, $term->taxonomy, 'description' );
			}
		return $term;
	}

	function hook_get_terms( $terms ) {
		foreach ( $terms as $term_id => $term )
			if ( sp_is_taxonomy_ml( $term->taxonomy ) ) {
				$terms[$term_id]->name        = sp_ml_ext_term_field( $term->term_id, $term->taxonomy, 'name' );
				$terms[$term_id]->description = sp_ml_ext_term_field( $term->term_id, $term->taxonomy, 'description' );
			}
		return $terms;
	}

	// ==================== hooks: nav menus ====================

	function hook_menus_config_filter( $menus ) {
		$menus_new = array();
		foreach ( sp_get_enabled_languages() as $locale_code => $l )
			foreach ( $menus as $menu_id => $menu_name )
				$menus_new[$menu_id.'-'.$locale_code] = $menu_name.' ['.$l['name'].']';
		return $menus_new;
	}

	// ==================== hooks: options panel ====================

	function hook_cf_one_name_filter( $html, $enabled_ml ) {
		if ( $enabled_ml )
			return $html . _sp_lang_selector_admin();
		else
			return $html;
	}

	function hook_op_option_name_filter( $option_name, $locale_code = '' ) {
		if ( ! empty( $locale_code ) )
			return $option_name . SP_META_LANG_PREFIX . $locale_code;
		return $option_name;
	}

	function hook_op_header_footer() {
		echo _sp_lang_selector_admin();
	}

	function hook_op_register_setting( $option_group, $option_name, $option ) {
		if ( ! isset( $option['ml'] ) || ( isset( $option['ml'] ) && $option['ml'] ) )
			foreach( sp_get_enabled_languages_locales() as $l ) {
				register_setting( $option_group, $option_name . SP_META_LANG_PREFIX . $l );
			}
	}

	// ==================== hooks: post custom fields ====================

	function hook_meta_key_filter( $meta_key, $post_id, $locale_code = '' ) {
		if ( ! empty( $locale_code ) )
			return $meta_key . SP_META_LANG_PREFIX . $locale_code;
		return $meta_key;
	}

	function hook_pm_update_postmeta( $meta_key, $field, $post_id, $is_ml = true ) {
		if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
			foreach( sp_get_enabled_languages_locales() as $l ) {
				if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ) {
					update_post_meta( $post_id, $meta_key . SP_META_LANG_PREFIX . $l, $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] );
				}
			}
	}

	// ==================== hooks: taxonomy custom fields ====================

	function hook_tm_update_termmeta( $meta_key, $field, $term_id, $is_ml = true ) {
		if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
			foreach( sp_get_enabled_languages_locales() as $l ) {
				if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ) {
					sp_update_term_meta( $term_id, $meta_key . SP_META_LANG_PREFIX . $l, $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] );
				}
			}
	}

	// ==================== hooks: user custom fields ====================

	function hook_um_update_usermeta( $meta_key, $field, $user_id, $is_ml = true ) {
		if ( $is_ml && ( ! isset( $field['ml'] ) || ( isset( $field['ml'] ) && $field['ml'] ) ) )
			foreach( sp_get_enabled_languages_locales() as $l ) {
				if ( isset( $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] ) ) {
					update_user_meta( $user_id, $meta_key . SP_META_LANG_PREFIX . $l, $_POST[SP_CUSTOM_FIELDS_PREFIX.$field['id'].SP_META_LANG_PREFIX.$l] );
				}
			}
	}

	// ==================== enqueue scripts and stylesheets ====================

	function enqueue_assets_frontpage() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.cookie' );
		wp_enqueue_script( 'sp.' . $this->slug . '.frontpage', $this->get_module_uri() . '/sp.' . $this->slug . '.frontpage.js', array( 'jquery' ), false, true );

		wp_localize_script( 'sp.' . $this->slug . '.frontpage', 'sp_multilingual', array(
			'current' => sp_lang(),
			'enabled' => sp_get_enabled_languages_locales(),
			'default' => sp_get_default_language(),
		) );

	}

	function enqueue_assets_dashboard() {

		wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'fontawesome-ie7' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.cookie' );
		wp_enqueue_style( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.css', array(), false, 'screen' );
		wp_enqueue_script( 'sp.' . $this->slug . '.dashboard', $this->get_module_uri() . '/sp.' . $this->slug . '.dashboard.js', array( 'jquery' ), false, true );

		wp_localize_script( 'sp.' . $this->slug . '.dashboard', 'sp_multilingual', array(
			'current'   => sp_lang(),
			'enabled'   => sp_get_enabled_languages_locales(),
			'default'   => sp_get_default_language(),
			'languages' => sp_get_languages(),
		) );

	}

}

new SP_Multilingual();


// sub-modules
foreach ( array( 'woocommerce', ) as $m ) {
	if ( file_exists( SP_INC . '/multilingual-' . $m . '.php' ) ) {
		require_once( SP_INC . '/multilingual-' . $m . '.php' );
	}
}


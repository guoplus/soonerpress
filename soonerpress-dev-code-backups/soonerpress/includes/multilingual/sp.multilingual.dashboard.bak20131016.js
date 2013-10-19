

;(function($) {

$(document).ready( function() {

	enabled_languages = sp_multilingual.enabled;
	all_languages = sp_multilingual.languages;
	current_lang = sp_multilingual.current;
	default_language = sp_multilingual.default;

	// multilingual admin menu

	function sp_ml_opt_langs_insert( lang_data ) {
		$lang_one = $( '<tr class="lang_one">' + $('#sp_ml_opt_langs_list .lang_one.sp_list_one_tpl').html() + '</tr>' );
		if ( -1 != $.inArray( lang_data['lang_code'], enabled_languages ) || lang_data['enabled'] )
			$lang_one.addClass('enabled');
		if ( default_language == lang_data['lang_code'] )
			$lang_one.addClass('default');
		$lang_one.attr( 'hash', Math.random() )
		$lang_one.data({
			'lang_code'   : lang_data['lang_code'],
			'date_format' : lang_data['date_format'],
			'time_format' : lang_data['time_format'],
		});
		$lang_one.find('.lang_flag img:first').attr( 'src', lang_data['flag'] );
		$lang_one.find('.lang_name').text( lang_data['name'] ) ;
		$lang_one.appendTo('#sp_ml_opt_langs_list');
	}
	function sp_ml_opt_langs_update( hash, lang_data ) {
		$lang_one = $('.lang_one[hash="'+hash+'"]');
		$lang_one.data({
			'lang_code'   : lang_data['lang_code'],
			'date_format' : lang_data['date_format'],
			'time_format' : lang_data['time_format'],
		});
		$lang_one.find('.lang_flag img:first').attr( 'src', lang_data['flag'] );
		$lang_one.find('.lang_name').text( lang_data['name'] );
		$('#lang_edit input').val('');
		$('#lang_edit').addClass('adding');
	}
	for ( l in all_languages ) {
		all_languages[l]['lang_code'] = l;
		sp_ml_opt_langs_insert( all_languages[l] );
	}
	$('#sp_ml_opt_langs_list .lang_one').prepend('<td class="lang_ctrl_drag"><span class="sp-drag-icon sp-ml-opt-drag"></span></td>');
	$('#sp_ml_opt_langs_list tbody').sortable( { 'handle': '.sp-ml-opt-drag:first', axis: 'y' } );
	$('#sp_ml_opt_langs_list .btn_lang_one_set_enable').live( 'click', function(e) {
		e.preventDefault();
		$(this).parents('.lang_one').addClass('enabled');
	} );
	$('#sp_ml_opt_langs_list .btn_lang_one_set_disable').live( 'click', function(e) {
		e.preventDefault();
		$(this).parents('.lang_one').removeClass('enabled default');
	} );
	$('#sp_ml_opt_langs_list .btn_lang_one_delete').live( 'click', function(e) {
		e.preventDefault();
		$(this).parents('.lang_one').remove();
	} );
	$('#sp_ml_opt_langs_list .btn_lang_one_set_default').live( 'click', function(e) {
		e.preventDefault();
		$('#sp_ml_opt_langs_list .lang_one').removeClass('default');
		$(this).parents('.lang_one').addClass('default');
	} );
	$('#sp_ml_opt_langs_list .btn_lang_one_edit').live( 'click', function(e) {
		e.preventDefault();
		$lang_one = $(this).parents('.lang_one');
		$('#lang_edit').removeClass('adding')
			.data( 'for', $lang_one.attr('hash') );
		$('#lang_edit_lang_code').val( $lang_one.data('lang_code') );
		$('#lang_edit_name').val( $lang_one.find('.lang_name').text() );
		$('#lang_edit_flag').val( $lang_one.find('.lang_flag img:first').attr('src') );
		$('#lang_edit_date_format').val( $lang_one.data('date_format') );
		$('#lang_edit_time_format').val( $lang_one.data('time_format') );
	} );
	$('#lang_edit .btn_lang_edit_save').live( 'click', function(e) {
		e.preventDefault();
		sp_ml_opt_langs_update( $('#lang_edit').data('for'), {
			'lang_code'   : $('#lang_edit_lang_code').val(),
			'date_format' : $('#lang_edit_date_format').val(),
			'time_format' : $('#lang_edit_time_format').val(),
			'flag'        : $('#lang_edit_flag').val(),
			'name'        : $('#lang_edit_name').val(),
		} );
	} );
	$('#lang_edit .btn_lang_edit_add').live( 'click', function(e) {
		e.preventDefault();
		sp_ml_opt_langs_insert( {
			'lang_code'   : $('#lang_edit_lang_code').val(),
			'date_format' : $('#lang_edit_date_format').val(),
			'time_format' : $('#lang_edit_time_format').val(),
			'flag'        : $('#lang_edit_flag').val(),
			'name'        : $('#lang_edit_name').val(),
			'enabled'     : true,
		} );
	} );
	$('#lang_edit .btn_lang_edit_cancel').live( 'click', function(e) {
		e.preventDefault();
		$('#lang_edit input').val('');
		$('#lang_edit').addClass('adding');
	} );
	$('.sp-multilingual-form').bind( 'submit', function(e) {
		// generate field data
		var field_languages = [],
			field_enabled = [],
			field_default = '';
		$('#sp_ml_opt_langs_list .lang_one').not('.sp_list_one_tpl').each( function() {
			if ( $(this).hasClass('enabled') )
				field_enabled.push( $(this).data('lang_code') );
			if ( $(this).hasClass('default') )
				field_default = $(this).data('lang_code');			
			field_languages[ $(this).data('lang_code') ] = {
				'name' : $(this).find('.lang_name').text(),
				'flag' : $(this).find('.lang_flag img:first').attr('src'),
				'date_format' : $(this).data('date_format'),
				'time_format' : $(this).data('time_format'),
			};
		} );
		// generate fields HTML and append to form
		for ( l in field_languages ) {
			for ( f in field_languages[l] )
				$(this).append('<input name="sp_ml_opt_main[languages]['+l+']['+f+']" type="hidden" value="'+field_languages[l][f]+'" />');
		}
		for ( l in field_enabled )
			$(this).append('<input name="sp_ml_opt_main[enabled][]" type="hidden" value="'+field_enabled[l]+'" />');
		$(this).append('<input name="sp_ml_opt_main[default]" type="hidden" value="'+field_default+'" />');
	} );

	// custom meta

	$('.sp-cm-one .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		sp_ml_switch_field_lang( $(this).parents('.sp-cm-one'), $(this).data('lang') );
		$field_to_focus = $(this).parents('.sp-cm-one')
			.find('.sp-cm-one-field-l-'+$(this).data('lang'))
			.find('input[type="text"], textarea');
		if ( $field_to_focus.length )
			$field_to_focus[0].focus();
	} );

	// options panel

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');
	sp_ml_switch_field_lang( $('.sp-cm-one'), current_lang );

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+$(this).data('lang')).addClass('current');
		sp_ml_switch_field_lang( $('#sp-options-panel-wrap .sp-cm-one'), $(this).data('lang') );
	} );

	// post custom meta

	;

	// post edit

	if ( $('form#post').length ) {
		$('#titlewrap').append($('.sp-pe-one-field-post_title-l'));
		$('#postdivrich').prepend($('.sp-pe-one-field-post_content-l'));
		$('#postexcerpt .inside').prepend($('.sp-pe-one-field-post_excerpt-l'));
	}

	$('form#post').find('#title, #wp-content-wrap, #excerpt').hide();
	$('#sp-pe-multilingual-selector a').click( function(e) {
		e.preventDefault();
		lang = $(this).data('lang');
		$('#sp-pe-multilingual-selector a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		$('.sp-pe-one-field-post_title-l, .sp-pe-one-field-post_content-l, .sp-pe-one-field-post_excerpt-l').hide()
			.filter('.sp-pe-one-field-l-'+lang).show();
		$('.sp-cm-one').each( function() {
			sp_ml_switch_field_lang( $(this), lang );
		} );
	} );

	$('#sp-pe-multilingual-selector .sp-ml-lang-tab-'+current_lang).trigger('click');

	// term add & term edit

	if ( $('form#addtag').length ) {
		$('#tag-name').after($('.sp-te-one-field-name-l'));
		$('#tag-description').after($('.sp-te-one-field-description-l'));
		$('form#addtag').before($('.sp-te-multilingual-selector'));
	}

	if ( $('form#edittag').length ) {
		$('#name').after($('.sp-te-one-field-name-l'));
		$('#description').after($('.sp-te-one-field-description-l'));
		$('form#edittag .form-table:first > tbody').prepend('<tr><td colspan="2"></td></tr>').find('td:first').append($('.sp-te-multilingual-selector'));
	}

	$('form#addtag, form#edittag').find('#tag-name, #tag-description, #name, #description').hide();
	$('.sp-te-multilingual-selector a').click( function(e) {
		e.preventDefault();
		lang = $(this).data('lang');
		$('.sp-te-multilingual-selector a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		$('.sp-te-one-field-name-l, .sp-te-one-field-description-l').hide()
			.filter('.sp-te-one-field-l-'+lang).show();
		$('.sp-cm-one').each( function() {
			sp_ml_switch_field_lang( $(this), lang );
		} );
	} );

	$('.sp-te-multilingual-selector .sp-ml-lang-tab-'+current_lang).trigger('click');

	$('[name="name__'+default_language+'"]').bind( 'change', function(e) {
		$('[name="tag-name"]').val( $(this).val() );
	} );

} );

$(window).load( function() {

} );

})(jQuery);


function sp_ml_switch_field_lang( $field, lang ) {
	// switch link style
	$field.find('.sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+lang).addClass('current');
	// switch field language
	$field.find('.sp-cm-one-field-l').hide()
		.filter('.sp-cm-one-field-l-'+lang).show();
}




;(function($) {

$(document).ready( function() {

	enabled_languages = sp_multilingual.enabled;
	current_lang = sp_multilingual.current;
	main_stored_language = sp_multilingual.main_stored;

	// custom meta

	$('.sp-cm-one .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		sp_ml_switch_field_lang( $(this).parents('.sp-cm-one'), $(this).data('lang') );
		$field = $(this).parents('.sp-cm-one')
			.find('.sp-cm-one-field-l-'+$(this).data('lang'))
			.find('input[type="text"], textarea');
		if ( $field.length )
			$field[0].focus();
	} );

	// options panel

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+$(this).data('lang')).addClass('current');
		sp_ml_switch_field_lang( $('#sp-options-panel-wrap .sp-cm-one'), $(this).data('lang') );
	} );

	// post custom meta

	;

	// switch to current language

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');
	sp_ml_switch_field_lang( $('.sp-cm-one'), current_lang );

	// post edit

	if ( $('form#post').length ) {
		$('#titlewrap').append($('.sp-pe-one-field-post_title-l'));
		$('#postdivrich').prepend($('.sp-pe-one-field-post_content-l'));
		$('#postexcerpt .inside').prepend($('.sp-pe-one-field-post_excerpt-l'));
	}

	$('#sp-pe-multilingual-selector a').click( function(e) {
		e.preventDefault();
		lang = $(this).data('lang');
		$('#sp-pe-multilingual-selector a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		if ( main_stored_language == lang ) {
			$('#title, #wp-content-wrap, #excerpt').show();
			$('.sp-pe-one-field-post_title-l, .sp-pe-one-field-post_content-l, .sp-pe-one-field-post_excerpt-l').hide();
		} else {
			$('#title, #wp-content-wrap, #excerpt').hide();
			$('.sp-pe-one-field-post_title-l, .sp-pe-one-field-post_content-l, .sp-pe-one-field-post_excerpt-l').hide()
				.filter('.sp-pe-one-field-l-'+lang).show();
		}
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

	$('.sp-te-multilingual-selector a').click( function(e) {
		e.preventDefault();
		lang = $(this).data('lang');
		$('.sp-te-multilingual-selector a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		if ( main_stored_language == lang ) {
			$('form#addtag, form#edittag').find('#tag-name, #tag-description, #name, #description').show();
			$('.sp-te-one-field-name-l, .sp-te-one-field-description-l').hide();
		} else {
			$('form#addtag, form#edittag').find('#tag-name, #tag-description, #name, #description').hide();
			$('.sp-te-one-field-name-l, .sp-te-one-field-description-l').hide()
				.filter('.sp-te-one-field-l-'+lang).show();
		}
		$('.sp-cm-one').each( function() {
			sp_ml_switch_field_lang( $(this), lang );
		} );
	} );

	$('.sp-te-multilingual-selector .sp-ml-lang-tab-'+current_lang).trigger('click');

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


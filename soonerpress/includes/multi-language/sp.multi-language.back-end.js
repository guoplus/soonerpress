

;(function($) {

$(document).ready( function() {

	enabled_languages = sp_multi_language.enabled;
	current_lang = sp_multi_language.current;
	main_stored_language = sp_multi_language.main_stored;

	// custom meta

	$('.sp-cm-one .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		sp_ml_switch_field_lang( $(this).parents('.sp-cm-one'), $(this).data('lang') );
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

	// common switcher

	$('.sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		$field = $(this).parents('.sp-cm-one')
			.find('.sp-cm-one-field-l-'+$(this).data('lang'))
			.find('input[type="text"], textarea');
		if( $field.length )
			$field[0].focus();
	} );

	// switch to current language

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');
	sp_ml_switch_field_lang( $('.sp-cm-one'), current_lang );

	// post edit

	if( $('form#post').length ) {
		$('#titlewrap').append($('.sp-pe-one-field-l-post-title'));
		$('#postdivrich').prepend($('.sp-pe-one-field-l-post-content'));
		$('#postexcerpt .inside').prepend($('.sp-pe-one-field-l-post-excerpt'));
		$('#edit-slug-box').append($('#sp-pe-languages-selector'));
	}

	$('#sp-pe-languages-selector .sp-ml-lang-tabs a').click( function(e) {
		e.preventDefault();
		lang = $(this).data('lang');
		$('#sp-pe-languages-selector .sp-ml-lang-tabs a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		if( main_stored_language == lang ) {
			$('#title, #wp-content-wrap, #excerpt').show();
			$('.sp-pe-one-field-l-post-title, .sp-pe-one-field-l-post-content, .sp-pe-one-field-l-post-excerpt').hide();
		} else {
			$('#title, #wp-content-wrap, #excerpt').hide();
			$('.sp-pe-one-field-l-post-title, .sp-pe-one-field-l-post-content, .sp-pe-one-field-l-post-excerpt').hide()
				.filter('.sp-pe-one-field-l-'+lang).show();
		}
		$('.sp-pm-one').each( function() {
			sp_ml_switch_field_lang( $(this), lang );
		} );
	} );

	$('#sp-pe-languages-selector .sp-ml-lang-tabs .sp-ml-lang-tab-'+current_lang).trigger('click');

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


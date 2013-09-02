

;(function($) {

$(document).ready( function() {

	// options panel

	$(this).find('.sp-op-one .sp-ml-lang-tabs a').click( function() {
		sp_ml_switch_field_lang( $(this).parents('.sp-op-one'), $(this).data('lang') );
	} );

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a').click( function() {
		$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+$(this).data('lang')).addClass('current');
		sp_ml_switch_field_lang( $('#sp-options-panel-wrap .sp-op-one'), $(this).data('lang') );
	} );

	// post custom meta

	$(this).find('.sp-pm-one .sp-ml-lang-tabs a').click( function() {
		sp_ml_switch_field_lang( $(this).parents('.sp-pm-one'), $(this).data('lang') );
	} );

	// common switcher

	$('.sp-ml-lang-tabs a').click( function() {
		$field = $(this).parents('.sp-op-one, .sp-pm-one')
			.find('.sp-op-one-field-l-'+$(this).data('lang')+', .sp-pm-one-field-l-'+$(this).data('lang'))
			.find('input[type="text"], textarea');
		if( $field.length )
			$field[0].focus();
	} );

	// switch to current language

	current_lang = sp_multi_language.current;

	$('#sp-options-panel-header .sp-ml-lang-tabs a, #sp-options-panel-footer .sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');
	sp_ml_switch_field_lang( $('.sp-op-one, .sp-pm-one'), current_lang );

	// post edit

	enabled_languages = sp_multi_language.enabled;
	main_stored_language = sp_multi_language.main_stored;

	if( $('form#post').length ) {
		$('#titlewrap').append($('.sp-pe-one-field-l-post-title'));
		$('#postdivrich').prepend($('.sp-pe-one-field-l-post-content'));
		$('#titlediv .inside').append($('#sp-pe-languages-selector'));
	}

	// if( $('form#post').length ) {
	// 	post_data = sp_multi_language.post_data;
	// 	$title = $('#title');
	// 	for( l in enabled_languages ) {
	// 		l = enabled_languages[l];
	// 		if( l == main_stored_language ) continue;
	// 		post_id = spGetUrlParam('post');
	// 		$title.after('<div class="sp-pe-one-field-l sp-pe-one-field-l-'+l+'"><input type="text" name="post_title_'+l+'" id="post_title_'+l+'" size="30" value="'+post_data['post_title'][l]+'" autocomplete="off" /></div>')
	// 	}
	// 	// $title.attr('type','hidden');
	// }

	// if( $('form#post').length ) {
	// 	$title = $('#title');
	// 	title = $.evalJSON( $title.val() );
	// 	for( l in enabled_languages ) {
	// 		l = enabled_languages[l];
	// 		$title.after('<span class="sp-pe-one-field-l sp-pe-one-field-l-'+l+'"><input type="text" id="post_title_'+l+'" size="30" value="'+title[l]+'" autocomplete="off" /></span>')
	// 	}
	// 	$title.attr('type','hidden');
	// }

	// $('form#post').bind( 'submit', function() {
	// 	var title_submit = {};
	// 	for( l in enabled_languages ) {
	// 		l = enabled_languages[l];
	// 		title_submit[l] = $('#post_title_'+l).val();
	// 	}
	// 	$('#title').val( $.toJSON( title_submit ) );
	// } );

	$('#sp-pe-languages-selector .sp-ml-lang-tabs a').click( function() {
		lang = $(this).data('lang');
		$('#sp-pe-languages-selector .sp-ml-lang-tabs a')
			.removeClass('current')
			.filter('.sp-ml-lang-tab-'+lang).addClass('current');
		if( main_stored_language == lang ) {
			$('#title, #wp-content-wrap').show();
			$('.sp-pe-one-field-l-post-title, .sp-pe-one-field-l-post-content').hide();
		} else {
			$('#title, #wp-content-wrap').hide();
			$('.sp-pe-one-field-l-post-title, .sp-pe-one-field-l-post-content').hide()
				.filter('.sp-pe-one-field-l-'+lang).show();
		}
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
	$field.find('.sp-op-one-field-l, .sp-pm-one-field-l').hide()
		.filter('.sp-op-one-field-l-'+lang+', .sp-pm-one-field-l-'+lang).show();
}


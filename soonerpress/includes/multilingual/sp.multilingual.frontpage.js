

;(function($) {

$(document).ready( function() {

	// common switcher

	$('.sp-ml-selector-text a, .sp-ml-selector-img a').click( function(e) {
		e.preventDefault();
		sp_ml_switch_to( $(this).data('lang') );
	} );
	$('.sp-ml-selector-select').change( function() {
		sp_ml_switch_to( $(this).val() );
	} );

	// switch to current language

	current_lang = sp_multilingual.current;

	$('.sp_lang_selector a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');
	$('.sp_lang_selector a').click( function(e) {
		if ( '#' == $(this).attr('href') )
			e.preventDefault();
		$.cookie( 'lang', $(this).data('lang'), { expires: 365 } );
		window.location.reload();
	} );

} );

$(window).load( function() {

} );

})(jQuery);


function sp_ml_switch_to( lang ) {
	if( location.href.indexOf('?') )
		prefix = '&';
	else
		prefix = '?';
	location.href = location.href.replace(/\#(.+?)/g,'').replace(/([\&\?]?)lang=([a-z]+)/g,'') + prefix + 'lang=' + lang;
}


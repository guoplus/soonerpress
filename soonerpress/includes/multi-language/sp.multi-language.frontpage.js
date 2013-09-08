

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

	current_lang = sp_multi_language.current;

	$('.sp-ml-lang-tabs a')
		.removeClass('current')
		.filter('.sp-ml-lang-tab-'+current_lang).addClass('current');

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


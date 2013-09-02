

;(function($) {

$(document).ready( function() {

	// common switcher

	$('.sp-ml-lang-tabs a').click( function() {
		if( location.href.indexOf('?') )
			prefix = '&';
		else
			prefix = '?';
		location.href = location.href.replace(/([\&\?]?)lang=([a-z]{2})/g,'') + prefix + 'lang=' + $(this).data('lang');
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


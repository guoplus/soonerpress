

;(function($) {

$(document).ready( function() {

	$('#sp-options-panel-tabs a').click( function() {
		$('#sp-options-panel-tabs a').removeClass('current');
		$(this).addClass('current');
		$('#sp-options-panel-boxes ul > li')
			.hide()
			.eq( $('#sp-options-panel-tabs a').index(this) )
			.fadeIn('fast');
	} ).eq(spGetUrlParam('tab')?spGetUrlParam('tab'):0).trigger('click');

} );

$(window).load( function() {

} );

})(jQuery);


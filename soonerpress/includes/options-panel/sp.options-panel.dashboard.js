

;(function($) {

$(document).ready( function() {

	$('#sp-options-panel-tabs a').click( function(e) {
		e.preventDefault();
		$('#sp-options-panel-tabs a').removeClass('current');
		$(this).addClass('current');
		$('#sp-options-panel-boxes ul > li')
			.hide()
			.eq( $('#sp-options-panel-tabs a').index(this) )
			.fadeIn('fast');
	} ).eq( spGetUrlParam('tab') ? spGetUrlParam('tab') : 0 ).trigger('click');

	$('.btn-op-reset').click( function(e) {
		if ( ! confirm( sp_options_panel.l10n['are_you_sure'] ) )
			e.preventDefault();
	} )

} );

$(window).load( function() {

} );

})(jQuery);


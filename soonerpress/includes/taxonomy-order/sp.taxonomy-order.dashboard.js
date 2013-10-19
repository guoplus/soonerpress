

;(function($) {

$(document).ready( function() {

	// $('#sp-to-reorder-warp .sp-to-reorder-item-info').prepend('<span class="sp-to-drag"></span>');
	$('#sp-to-reorder-warp > ul').nestedSortable( {
		'items': 'li',
		'handle': '.sp-to-reorder-item-info:first',
		'toleranceElement': '> .sp-to-reorder-item-info',
		'listType': 'ul',
		'placeholder': 'ui-sortable-placeholder',
	} );
	$('#sp-to-reorder-warp').disableSelection();

	$('.sp-to-reorder-item-info').prepend('<span class="sp-drag-icon sp-to-drag"></span>');

	$('form#sp-to-reorder').bind( 'submit', function() {
		$(this).find('[name="sp_to_reorder_data"]').val( $('#sp-to-reorder-warp > ul').nestedSortable('serialize') );
	} );


} );

$(window).load( function() {

} );

})(jQuery);


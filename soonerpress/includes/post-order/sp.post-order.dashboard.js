

;(function($) {

$(document).ready( function() {

	// $('#sp-po-reorder-warp .sp-po-reorder-item-info').prepend('<span class="sp-po-drag"></span>');
	$('#sp-po-reorder-warp > ul').nestedSortable( {
		'items': 'li',
		'handle': '.sp-po-reorder-item-info:first',
		'toleranceElement': '> .sp-po-reorder-item-info',
		'listType': 'ul',
		'placeholder': 'ui-sortable-placeholder',
	} );
	$('#sp-po-reorder-warp').disableSelection();

	$('.sp-po-reorder-item-info').prepend('<span class="sp-drag-icon sp-po-drag"></span>');

	$('form#sp-po-reorder').bind( 'submit', function() {
		$(this).find('[name="sp_po_reorder_data"]').val( $('#sp-po-reorder-warp > ul').nestedSortable('serialize') );
	} );


} );

$(window).load( function() {

} );

})(jQuery);


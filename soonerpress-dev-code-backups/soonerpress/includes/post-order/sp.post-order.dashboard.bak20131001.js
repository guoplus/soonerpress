

;(function($) {

$(document).ready( function() {

	// $('#sp-po-reorder-warp .sp-po-reorder-item-info').prepend('<span class="sp-po-drag"></span>');
	$('#sp-po-reorder-warp > ul').sortable({ 'items': 'li', 'handle': '.sp-po-reorder-item-info:first', 'axis': 'y' });
	sp_po_sortable_deep( $('#sp-po-reorder-warp > li') );
	$('#sp-po-reorder-warp').disableSelection();

} );

$(window).load( function() {

} );

function sp_po_sortable_deep( $parent ) {
	$parent.each( function() {
		$(this).sortable({ 'items': 'ul', 'handle': '.sp-po-reorder-item-info:first', 'axis': 'y' });
		sp_po_sortable_deep( $(this).children('li') );
	} );
}

})(jQuery);


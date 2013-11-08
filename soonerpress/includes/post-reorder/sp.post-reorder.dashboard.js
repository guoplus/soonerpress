

;(function($) {

$(document).ready( function() {

	// independent re-order

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

	// embedded re-order

	if ( $('form#posts-filter').length ) {
		post_type = spGetUrlParam( 'post_type' ) ? spGetUrlParam( 'post_type' ) : 'post';
		if ( -1 !== sp_post_reorder.embedded_post_type.indexOf( post_type ) && $('form#posts-filter .wp-list-table > tbody > tr').not('.no-items').length ) {
			$('form#posts-filter .tablenav.top .tablenav-pages').before(
				'<div class="alignleft actions sp-po-embedded-ctrl">'+
				'<a href="#" class="button sp-po-reorder-embedded">'+sp_post_reorder.l10n['re_order']+'</a>'+
				'<a href="#" class="button sp-po-reorder-embedded-cancel" style="display: none;">'+sp_post_reorder.l10n['re_order_cancel']+'</a>'+
				'<a href="#" class="button button-primary sp-po-reorder-embedded-save" style="display: none;">'+sp_post_reorder.l10n['re_order_save']+'</a>'+
				'</div>'
			);
			$('form#posts-filter .wp-list-table > tbody > tr > th').append('<span class="sp-drag-icon sp-po-drag" style="display: none;"></span>');
			$('form#posts-filter .wp-list-table > tbody').nestedSortable( { 'items': '> tr', 'handle': '.sp-po-drag:first', 'listType': 'tbody', axis: 'y' } );
			$('form#posts-filter').after(
				'<form id="sp-po-reorder-embedded-form" action="" method="post">'+
				'<input name="action" value="sp_po_save_reorder_data" type="hidden" />'+
				'<input name="post_type" value="'+post_type+'" type="hidden" />'+
				'<input name="sp_po_reorder_data" type="hidden" />'+
				'<input name="_wpnonce" value="'+$('#_wpnonce').val()+'" type="hidden" />'+
				'</form>'
			);
		}
	}

	$('.sp-po-reorder-embedded').bind( 'click', function(e) {
		e.preventDefault();
		$('form#posts-filter .wp-list-table > thead > tr > .column-cb, > tfoot > tr > .column-cb, > tbody > tr > th').children(':visible').hide();
		$('form#posts-filter .wp-list-table > tbody > tr > th > .sp-po-drag').show();
		$('.sp-po-reorder-embedded-cancel, .sp-po-reorder-embedded-save').show();
		$('.sp-po-reorder-embedded').hide();
	} );

	$('.sp-po-reorder-embedded-cancel').bind( 'click', function(e) {
		e.preventDefault();
		$('form#posts-filter .wp-list-table > thead > tr > .column-cb, > tfoot > tr > .column-cb, > tbody > tr > th').children().show();
		$('form#posts-filter .wp-list-table > tbody > tr > th > .sp-po-drag').hide();
		$('.sp-po-reorder-embedded-cancel, .sp-po-reorder-embedded-save').hide();
		$('.sp-po-reorder-embedded').show();
	} );

	$('.sp-po-reorder-embedded-save').bind( 'click', function(e) {
		e.preventDefault();
		$('form#sp-po-reorder-embedded-form').find('[name="sp_po_reorder_data"]').val( $('form#posts-filter .wp-list-table > tbody').nestedSortable('serialize') );
		$('form#sp-po-reorder-embedded-form').trigger( 'submit' );
	} );

} );

$(window).load( function() {

} );

})(jQuery);




;(function($) {

$(document).ready( function() {

	// independent re-order

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

	// embedded re-order

	if ( $('form#posts-filter').length ) {
		taxonomy = spGetUrlParam( 'taxonomy' );
		if ( -1 !== sp_taxonomy_reorder.embedded_taxonomy.indexOf( taxonomy ) && $('form#posts-filter .wp-list-table > tbody > tr').not('.no-items').length ) {
			$('form#posts-filter .tablenav.top .tablenav-pages').before(
				'<div class="alignleft actions sp-to-embedded-ctrl">'+
				'<a href="#" class="button sp-to-reorder-embedded">'+sp_taxonomy_reorder.l10n['re_order']+'</a>'+
				'<a href="#" class="button sp-to-reorder-embedded-cancel" style="display: none;">'+sp_taxonomy_reorder.l10n['re_order_cancel']+'</a>'+
				'<a href="#" class="button button-primary sp-to-reorder-embedded-save" style="display: none;">'+sp_taxonomy_reorder.l10n['re_order_save']+'</a>'+
				'</div>'
			);
			$('form#posts-filter .wp-list-table > tbody > tr > th').append('<span class="sp-drag-icon sp-to-drag" style="display: none;"></span>');
			$('form#posts-filter .wp-list-table > tbody').nestedSortable( { 'items': '> tr', 'handle': '.sp-to-drag:first', 'listType': 'tbody', axis: 'y' } );
			$('form#posts-filter').after(
				'<form id="sp-to-reorder-embedded-form" action="" method="post">'+
				'<input name="action" value="sp_to_save_reorder_data" type="hidden" />'+
				'<input name="taxonomy" value="'+taxonomy+'" type="hidden" />'+
				'<input name="sp_to_reorder_data" type="hidden" />'+
				'<input name="_wpnonce" value="'+$('#_wpnonce').val()+'" type="hidden" />'+
				'</form>'
			);
		}
	}

	$('.sp-to-reorder-embedded').bind( 'click', function(e) {
		e.preventDefault();
		$('form#posts-filter .wp-list-table > thead > tr > .column-cb, > tfoot > tr > .column-cb, > tbody > tr > th').children(':visible').hide();
		$('form#posts-filter .wp-list-table > tbody > tr > th > .sp-to-drag').show();
		$('.sp-to-reorder-embedded-cancel, .sp-to-reorder-embedded-save').show();
		$('.sp-to-reorder-embedded').hide();
	} );

	$('.sp-to-reorder-embedded-cancel').bind( 'click', function(e) {
		e.preventDefault();
		$('form#posts-filter .wp-list-table > thead > tr > .column-cb, > tfoot > tr > .column-cb, > tbody > tr > th').children().show();
		$('form#posts-filter .wp-list-table > tbody > tr > th > .sp-to-drag').hide();
		$('.sp-to-reorder-embedded-cancel, .sp-to-reorder-embedded-save').hide();
		$('.sp-to-reorder-embedded').show();
	} );

	$('.sp-to-reorder-embedded-save').bind( 'click', function(e) {
		e.preventDefault();
		$('form#sp-to-reorder-embedded-form').find('[name="sp_to_reorder_data"]').val( $('form#posts-filter .wp-list-table > tbody').nestedSortable('serialize') );
		$('form#sp-to-reorder-embedded-form').trigger( 'submit' );
	} );

} );

$(window).load( function() {

} );

})(jQuery);


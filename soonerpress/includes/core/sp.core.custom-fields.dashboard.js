

;(function($) {

$(document).ready( function() {

	// init multiple list sortable

	sortable_args = { 'items': '> .sp-cf-multi-one', 'handle': '.sp-cf-drag:first', axis: 'y' };

	$('.sp-cf-one-field-multiple, .sp-cf-nest-field-group, .sp-cf-nest-field-multiple').each( function() {
		if( $(this).children('.sp-cf-one-field-content').length ) {
			$(this).children('.sp-cf-one-field-content').each( function() {
				$(this).sortable( sortable_args );
			} );
		} else {
			$(this).sortable( sortable_args );
		}
	} );

	$('.sp-cf-one-field-nest-multiple-content').each( function() {
		$(this).sortable( sortable_args );
	} );

	// init functional fields

	$('.sp_radio_icon_choice').each( function() {
		if ( $(this).find('input[type="radio"][checked]').length )
			$(this).addClass('checked');
	} ).click( function(e) {
		$field = $(this).parent();
		$field.find('.sp_radio_icon_choice').removeClass('checked');
		$(this).addClass('checked');
	} );

	$('.sp_on_off_choice').each( function() {
		if ( $(this).find('input[type="radio"][checked]').length )
			$(this).addClass('checked');
	} ).click( function(e) {
		$field = $(this).parent();
		$field.find('.sp_on_off_choice').removeClass('checked');
		$(this).addClass('checked');
	} );

	$('.sp-cf-one-t-font').each( function() {
		$(this).find('input, select').bind( 'change', function() {
			$field = $(this).parent();
			$field.find('.sp_font_selector_preview').css({'font-family': $(this).val()})
		} );
	} );

	$('.sp-btn-media-addnew').live( 'click', function(e) {
		e.preventDefault();
		sp_cf_media_editor_current = $(this).parents('.sp-media-editor-field').removeClass('notselected');
		wp.media.editor.send.attachment = function( props, attachment ) {
			sp_media_editor_handle_attachment( attachment );
			sp_cf_media_editor_current.addClass('selected');
			wp.media.editor.send.attachment = sp_wp_media_editor_send_attachment_ori;
		}
		wp.media.editor.open();
	} );

	$('.sp-btn-media-delete').live( 'click', function(e) {
		e.preventDefault();
		sp_cf_media_editor_current = $(this).parents('.sp-media-editor-field').removeClass('selected');
		sp_media_editor_cancel_selection();
		sp_cf_media_editor_current.addClass('notselected');
	} );

	$('.sp-cf-one-t-colorpicker input[type="text"]').wpColorPicker();
	$('.sp-cf-one-t-datepicker input[type="text"]').datepicker( {
		'dateFormat': 'yy-mm-dd',
		'changeMonth': true,
		'changeYear': true,
	} );
	$('.sp-cf-one-t-timepicker input[type="text"]').timepicker( {} );
	$('.sp-cf-one-t-datetimepicker input[type="text"]').datetimepicker( {} );

	$('.sp-cf-field-google-maps').each( function() {
		$(this).find('.sp-cf-field-google-maps-address').bind( 'change', function() {
			$(this).parent().addClass('in-ajax');
			$.ajax({
				dataType: 'json',
				url: sp_core.ajaxurl,
				type: 'POST',
				data: { 'action': 'sp_google_maps_retrive', 'sp_cm_ajax_nonce': sp_core_cm.sp_cm_ajax_nonce, 'address': $(this).val() },
				success: function( data, textStatus, jqXHR ) {
					$('.sp-cf-field-google-maps.in-ajax').children('.sp-cf-field-google-maps-lat').val( data.results[0].geometry.location.lat );
					$('.sp-cf-field-google-maps.in-ajax').children('.sp-cf-field-google-maps-lng').val( data.results[0].geometry.location.lng );
				},
				complete: function( jqXHR, textStatus ) {
					$('.sp-cf-field-google-maps.in-ajax').removeClass('in-ajax');
				}
			});
		} );
	} );

	// init each multiple field

	// add buttons
	$('.sp-cf-one-t-group > .sp-cf-one-field, tr.sp-cf-one-t-group > td > .sp-cf-one-field, .sp-cf-nest-field-group').append( '<span class="ctrl">' +
		'<a href="#" class="button sp-btn-addnew">' + sp_core_cm.l10n.add_new + '</a>' +
		'<a href="#" class="button sp-btn-delall">' + sp_core_cm.l10n.delete_all + '</a>' +
		// '<a href="#" class="button sp-btn-togall">' + sp_core_cm.l10n.toggle_all + '</a>' +
		'<a href="#" class="button sp-btn-expall">' + sp_core_cm.l10n.expand_all + '</a>' +
		'<a href="#" class="button sp-btn-colall">' + sp_core_cm.l10n.collapse_all + '</a>' +
	'</span>' );
	$('.sp-cf-nest-field-multiple, .sp-cf-one-field-multiple').each( function() {
		if ( ! $(this).parent().hasClass('sp-cf-one-t-group') && ! $(this).parent('td').parent('tr').hasClass('sp-cf-one-t-group') ) // .sp-cf-one-t-group already has ctrl
			$(this).append( '<span class="ctrl">' +
				'<a href="#" class="button sp-btn-addnew">' + sp_core_cm.l10n.add_new + '</a>' +
				'<a href="#" class="button sp-btn-delall">' + sp_core_cm.l10n.delete_all + '</a>' +
			'</span>' );
	} );
	$('.sp-cf-nest-group-title').append( '<span class="ctrl">' +
		'<a href="#" class="button sp-btn-delete">' + sp_core_cm.l10n.delete + '</a>' +
		'<a href="#" class="button sp-btn-toggle">' + sp_core_cm.l10n.toggle + '</a>' +
	'</span>' );
	$('.sp-cf-one-field-multiple, .sp-cf-nest-field-multiple').each( function () {
		if ( ! $(this).parent().hasClass('sp-cf-one-t-group') && ! $(this).parent('td').parent('tr').hasClass('sp-cf-one-t-group') ) // not a group field
			$(this).find('.sp-cf-multi-one, .sp-cf-multi-one-def').append(
				'<a href="#" class="sp-btn-delete sp-iconbtn-delete">' + sp_core_cm.l10n.delete + '</a>'
			);
	} );

	// bind buttons
	$('.sp-cf-nest-group-title > .ctrl .sp-btn-delete, .sp-cf-nest-group-title > .ctrl .sp-btn-toggle'+', '+
		'.sp-cf-one-field-multiple .sp-btn-delete, .sp-cf-nest-field-multiple .sp-btn-delete'
	).live( 'click', function(e) {
		e.preventDefault();
		// delete button
		if ( $(this).hasClass('sp-btn-delete') ) {
			$(this).parent().parent().parent('.sp-cf-multi-one').remove(); // a group field
			$(this).parent('.sp-cf-multi-one').remove(); // a simple multiple field
		}
		// toggle button
		if ( $(this).hasClass('sp-btn-toggle') ) {
			$(this).parent().parent().parent('.sp-cf-multi-one').toggleClass('closed');
		}
	} );
	$('.sp-cf-one-t-group > .sp-cf-one-field > .ctrl .sp-btn-addnew, .sp-cf-one-field-multiple > .ctrl .sp-btn-addnew'+', '+
		'.sp-cf-nest-field-group > .ctrl .sp-btn-addnew, .sp-cf-nest-field-multiple > .ctrl .sp-btn-addnew'+', '+
		'.sp-cf-one-t-group > .sp-cf-one-field > .ctrl .sp-btn-delall, .sp-cf-one-field-multiple > .ctrl .sp-btn-delall'+', '+
		'.sp-cf-nest-field-group > .ctrl .sp-btn-delall, .sp-cf-nest-field-multiple > .ctrl .sp-btn-delall'+', '+
		'.sp-cf-one-t-group > .sp-cf-one-field > .ctrl .sp-btn-expall, tr.sp-cf-one-t-group > td > .sp-cf-one-field > .ctrl .sp-btn-expall, .sp-cf-nest-field-group > .ctrl .sp-btn-expall'+', '+
		'.sp-cf-one-t-group > .sp-cf-one-field > .ctrl .sp-btn-colall, tr.sp-cf-one-t-group > td > .sp-cf-one-field > .ctrl .sp-btn-colall, .sp-cf-nest-field-group > .ctrl .sp-btn-colall')
	.live( 'click', function(e) {
		e.preventDefault();
		// get current list
		if ( $(this).parent().parent().hasClass('sp-cf-one-field') ) // depth 1
			$list = $(this).parent().parent().find('.sp-cf-one-field-content:visible');
		else // depth > 1
			$list = $(this).parent().parent();
		// addnew button
		if ( $(this).hasClass('sp-btn-addnew') ) {
			$field_def = $list.children('.sp-cf-multi-one-def');
			$field_def.before( '<div class="sp-cf-multi-one">' + $field_def.html() + '</div>' );
			$field_new = $field_def.prev();
			rand = Math.random();
			$field_new.find('[name]').each( function() {
				$(this).attr( 'name', $(this).attr('name').replace( /SP_SERIAL_ID/, rand ) )
			} );
		}
		// delall button
		if ( $(this).hasClass('sp-btn-delall') ) {
			$list.children('.sp-cf-multi-one').remove();
		}
		// expall button
		if ( $(this).hasClass('sp-btn-expall') ) {
			$list.children('.sp-cf-multi-one').removeClass('closed');
		}
		// colall button
		if ( $(this).hasClass('sp-btn-colall') ) {
			$list.children('.sp-cf-multi-one').addClass('closed');
		}
	} );
	

	$('.sp-cf-nest-group-title').each( function() {
		// add, init and bind single group name referring specified field
		$(this).append('<span class="sp-cf-multi-one-refer-name"></span>');
		row_name_refer_to = $(this).data('row_name_refer_to');
		if ( row_name_refer_to ) {
			$(this).children('.sp-cf-multi-one-refer-name').text( $(this).parent().children('.sp-cf-nest-group-content').find('[name$="['+row_name_refer_to+']"]:first').val() );
			$('[name$="['+row_name_refer_to+']"]').live( 'change', function() {
				$(this).parent().parent().parent('.sp-cf-multi-one').children('.sp-cf-nest-group-title').children('.sp-cf-multi-one-refer-name').text( $(this).val() );
			} );
		}
		// apply default expanding
		expanded_default = $(this).data('expanded_default');
		if ( '0' == expanded_default ) {
			$(this).parent().addClass('closed');
		}
	} );

	// add drag icon
	$('.sp-cf-multi-one, .sp-cf-multi-one-def').each( function() {
		if ( $(this).children('.sp-cf-nest-group-title').length ) {
			$(this).children('.sp-cf-nest-group-title').prepend('<span class="sp-drag-icon sp-cf-drag"></span>');
		} else {
			$(this).prepend('<span class="sp-drag-icon sp-cf-drag"></span>');
		}
	} );

	// remove all "default field content" (for multiple entry) HTML to prevent storing redundant data
	$('form#sp-options-panel-form, form#post, form#edittag, form#addtag').bind( 'submit', function() {
		$('.sp-cf-multi-one-def').remove();
	} );

} );

$(window).load( function() {

} );

})(jQuery);


var sp_cf_media_editor_current;
if( 'undefined' != typeof wp.media && 'undefined' != typeof wp.media.editor )
	var sp_wp_media_editor_send_attachment_ori = wp.media.editor.send.attachment;

function sp_media_editor_handle_attachment( attachment ) {
	sp_cf_media_editor_current.find('.sp-media-editor-filename').text(attachment.filename);
	sp_cf_media_editor_current.find('.sp-media-editor-preview-image').attr('src',attachment.url);
	sp_cf_media_editor_current.find('.sp-media-editor-typeicon').attr('src',attachment.icon);
	sp_cf_media_editor_current.find('.sp-media-editor-input').val(attachment.id);
}

function sp_media_editor_cancel_selection() {
	sp_cf_media_editor_current.find('.sp-media-editor-filename').text('');
	sp_cf_media_editor_current.find('.sp-media-editor-input').val('0');
}


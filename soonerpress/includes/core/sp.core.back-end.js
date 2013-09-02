

;(function($) {

$(document).ready( function() {

	// init multiple list sortable

	$('.sp-cm-one-field-multiple').each( function() {
		if( $(this).children('.sp-cm-one-field-l').length ) {
			$(this).children('.sp-cm-one-field-l').each( function() {
				$(this).sortable();
			} );
		} else {
			$(this).sortable();
		}
	} );

	// init functional fields

	$('.sp-btn-media-addnew').live( 'click', function(e) {
		e.preventDefault();
		sp_cm_media_editor_current = $(this).parents('.sp-media-editor-field').removeClass('notselected');
		wp.media.editor.send.attachment = function( props, attachment ) {
			sp_media_editor_handle_attachment( attachment );
			sp_cm_media_editor_current.addClass('selected');
			wp.media.editor.send.attachment = sp_wp_media_editor_send_attachment_ori;
		}
		wp.media.editor.open();
	} );

	$('.sp-btn-media-delete').live( 'click', function(e) {
		e.preventDefault();
		sp_cm_media_editor_current = $(this).parents('.sp-media-editor-field').removeClass('selected');
		sp_media_editor_cancel_selection();
		sp_cm_media_editor_current.addClass('notselected');
	} );

	$('.sp-cm-one-t-datepicker input[type="text"]').datepicker( {
		'dateFormat': 'yy-mm-dd',
		'changeMonth': true,
		'changeYear': true,
	} );
	$('.sp-cm-one-t-colorpicker input[type="text"]').wpColorPicker();


	// init each multiple list

	$('.sp-cm-one-field-multiple, .sp-cm-one-field-nest-multiple')
		.append('<a href="#" class="button sp-btn-addnew">' + sp_core_text.add_new + '</a>')

	$('.sp-btn-addnew').live( 'click', function() {
		if( $(this).parent('.sp-cm-one-field-nest-multiple').length ) { // a nested-field add-new button
			$list = $(this).parent();
			$field_def = $list.children('.sp-cm-multi-one-def');
			field_def_html = $field_def.html();
			$field_def.before(
				( ( 'sp-cm-one-field-nest-multiple' == $list.attr('class') ) ?
					'<span class="sp-cm-multi-one">' :
				( $list.parents('.sp-cm-one-t-group').length ?
					'<span class="sp-cm-multi-one-group">' :
					'<span class="sp-cm-multi-one">' ) ) +
				field_def_html +
				'<a href="#" class="sp-btn-delete" title="' + sp_core_text.delete + '"></a>' +
				'</span>'
			);
		} else if( $(this).parent('.sp-cm-one-field-multiple').length && $(this).parents('.sp-cm-one-t-group').length ) { // a field-group add-new button
			$list = $(this).parent().find('.sp-cm-one-field-l:visible:first');
			if( ! $list.length ) // multi-language was not enabled
				$list = $(this).parent('.sp-cm-one-field-multiple');
			$field_def = $list.children('.sp-cm-multi-one-def');
			$field_def.before(
				'<div class="sp-cm-multi-one-group">' +
				$field_def.html().replace( /SP_SERIAL_ID/g, Math.random() ) +
				'<a href="#" class="sp-btn-delete" title="' + sp_core_text.delete + '"></a>' +
				'</div>'
			);
		} else {
			$list = $(this).parent().find('.sp-cm-one-field-l:visible:first');
			if( ! $list.length ) // multi-language was not enabled
				$list = $(this).parent('.sp-cm-one-field-multiple');
			$field_def = $list.children('.sp-cm-multi-one-def');
			$field_def.before(
				'<div class="sp-cm-multi-one">' +
				$field_def.html() +
				'<a href="#" class="sp-btn-delete" title="' + sp_core_text.delete + '"></a>' +
				'</div>'
			);
		}
	} );

	$('.sp-cm-multi-one, .sp-cm-multi-one-group').append('<a href="#" class="sp-btn-delete" title="' + sp_core_text.delete + '"></a>');
	$('.sp-btn-delete').live( 'click', function(e) {
		e.preventDefault();
		if( $(this).parent('.sp-cm-multi-one').length ) // a nested-field delete button
			$(this).parent().remove();
		else // a field-group delete button
			$(this).parents('.sp-cm-multi-one-group').remove();
	} );

	$('#sp-options-panel-form, #post').bind( 'submit', function() {
		$('.sp-cm-multi-one-def').remove();
	} );

} );

$(window).load( function() {

} );

})(jQuery);


var sp_cm_media_editor_current;
var sp_wp_media_editor_send_attachment_ori = wp.media.editor.send.attachment;

function sp_media_editor_handle_attachment( attachment ) {
	sp_cm_media_editor_current.find('.sp-media-editor-filename').text(attachment.filename);
	sp_cm_media_editor_current.find('.sp-media-editor-preview-image').attr('src',attachment.url);
	sp_cm_media_editor_current.find('.sp-media-editor-typeicon').attr('src',attachment.icon);
	sp_cm_media_editor_current.find('.sp-media-editor-input').val(attachment.id);
}

function sp_media_editor_cancel_selection() {
	sp_cm_media_editor_current.find('.sp-media-editor-filename').text('');
	sp_cm_media_editor_current.find('.sp-media-editor-input').val('0');
}


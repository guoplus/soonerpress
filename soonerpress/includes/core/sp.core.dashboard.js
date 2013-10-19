

;(function($) {

$(document).ready( function() {

	// init multiple list sortable

	sortable_args = { 'handle': '.sp-cm-drag:first', axis: 'y' };

	$('.sp-cm-one-field-multiple').each( function() {
		if( $(this).children('.sp-cm-one-field-l').length ) {
			$(this).children('.sp-cm-one-field-l').each( function() {
				$(this).sortable( sortable_args );
			} );
		} else if( $(this).children('.sp-cm-one-field-content').length ) {
			$(this).children('.sp-cm-one-field-content').each( function() {
				$(this).sortable( sortable_args );
			} );
		} else {
			$(this).sortable( sortable_args );
		}
	} );

	$('.sp-cm-one-field-nest-multiple-content').each( function() {
		$(this).sortable( sortable_args );
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

	$('.sp-cm-one-t-colorpicker input[type="text"]').wpColorPicker();
	$('.sp-cm-one-t-datepicker input[type="text"]').datepicker( {
		'dateFormat': 'yy-mm-dd',
		'changeMonth': true,
		'changeYear': true,
	} );
	$('.sp-cm-one-t-timepicker input[type="text"]').timepicker( {} );
	$('.sp-cm-one-t-datetimepicker input[type="text"]').datetimepicker( {} );

	// init each multiple list

	// add add-new button
	$('.sp-cm-one-field-multiple, .sp-cm-one-field-nest-multiple')
		.append('<a href="#" class="button sp-btn-addnew">' + sp_core_l10n.add_new + '</a>')
	// bind add-new button event
	$('.sp-btn-addnew').live( 'click', function(e) {
		e.preventDefault();
		// a nested-field add-new button
		if( $(this).parent('.sp-cm-one-field-nest-multiple').length ) {
			$list = $(this).parent().children('.sp-cm-one-field-nest-multiple-content');
			$field_def = $list.children('.sp-cm-multi-one-def');
			field_def_html = $field_def.html();
			$field_def.before(
				'<div class="sp-cm-multi-one">' +
				field_def_html +
				'<a href="#" class="sp-btn-delete" title="' + sp_core_l10n.delete + '"></a>' +
				'</div>'
			);
		// a field-group add-new button
		} else if( $(this).parent('.sp-cm-one-field-multiple').length && $(this).parents('.sp-cm-one-t-group').length ) {
			$list = $(this).parent().find('.sp-cm-one-field-l:visible:first');
			if( ! $list.length ) // multi-language was not enabled
				$list = $(this).parent('.sp-cm-one-field-multiple').find('.sp-cm-one-field-content');
			$field_def = $list.children('.sp-cm-multi-one-def');
			$field_def.before(
				'<div class="sp-cm-multi-one-group' + ( $field_def.data('expanded_default') ? '' : ' closed' ) + '">' +
				$field_def.html().replace( /SP_SERIAL_ID/g, Math.random() ) +
				'</div>'
			);
		} else {
			$list = $(this).parent().find('.sp-cm-one-field-l:visible:first');
			if( ! $list.length ) // multi-language was not enabled
				$list = $(this).parent().find('.sp-cm-one-field-content');
			$field_def = $list.children('.sp-cm-multi-one-def');
			$field_def.before(
				'<div class="sp-cm-multi-one">' +
				$field_def.html() +
				'<a href="#" class="sp-btn-delete" title="' + sp_core_l10n.delete + '"></a>' +
				'</div>'
			);
		}
	} );

	// add delete button
	$('.sp-cm-multi-one').append('<a href="#" class="sp-btn-delete" title="' + sp_core_l10n.delete + '"></a>');

	// bind delete button event
	$('.sp-btn-delete, .sp-btn-delete-text').live( 'click', function(e) {
		e.preventDefault();
		if( $(this).parent('.sp-cm-multi-one').length ) // a nested-field delete button
			$(this).parent().remove();
		else // a field-group delete button
			$(this).parents('.sp-cm-multi-one-group').remove();
	} );

	// add drag icon to multiple fields
	$('.sp-cm-one-field-multiple .sp-cm-multi-one, .sp-cm-one-field-multiple .sp-cm-multi-one-def')
		.not('.sp-cm-one-t-group > .sp-cm-one-field-multiple > .sp-cm-one-field-content > .sp-cm-multi-one-def')
		.not('.sp-cm-one-t-group > .sp-cm-one-field-multiple > .sp-cm-one-field-l > .sp-cm-multi-one-def')
		.prepend('<span class="sp-drag-icon sp-cm-drag"></span>');

	// add drag icon, refer name wrap, expand (collapse) switcher and delete button to nested fields group
	$('.sp-cm-multi-one-singletitle')
		.prepend('<span class="sp-drag-icon sp-cm-drag sp-cm-group-drag"></span>')
		.append('<span class="sp-cm-multi-one-refer-name"></span>')
		.append('<div class="ctrl"><a class="button sp-btn-delete-text">' + sp_core_l10n.delete + '</a>' +
			'<a class="button sp-btn-exco">' + sp_core_l10n.toggle + '</a></div>');

	// add fields group "expand all" ("collapse all") switcher
	$('.sp-cm-one-t-group .sp-cm-one-field')
		.append('<span class="ctrl"><a class="button sp-btn-exco-all">' + sp_core_l10n.collapse_all + '</a></span>');

	// init and bind single group name referring specified field
	$('.sp-cm-multi-one-group').each( function() {
		row_name_refer_to = $(this).data('row_name_refer_to');
		if ( row_name_refer_to ) {
			$(this).find('.sp-cm-multi-one-refer-name').text($(this).find('[name$="['+row_name_refer_to+']"]').val());
			$('[name$="['+row_name_refer_to+']"]').live( 'change', function() {
				$(this).parents('.sp-cm-multi-one-group').find('.sp-cm-multi-one-refer-name').text($(this).val());
			} );
		}
	} );

	// bind group expand (collapse) switcher click event
	$('.sp-cm-multi-one-group .sp-btn-exco').live( 'click', function(e) {
		e.preventDefault();
		$(this).parents('.sp-cm-multi-one-group').toggleClass('closed');
	} );

	// bind fields group "expand all" ("collapse all") switcher click event
	$('.sp-cm-one-t-group .sp-btn-exco-all').live( 'click', function(e) {
		e.preventDefault();
		$(this).parents('.sp-cm-one-t-group').find('.sp-cm-multi-one-group').addClass('closed');
	} );

	// collapse nested fields group
	$('.sp-cm-multi-one-group').each( function() {
		if ( ! $(this).data('expanded_default') )
			$(this).addClass('closed');
	} );

	// remove all "default field content" (for multiple entry) HTML to prevent storing redundant data
	$('#sp-options-panel-form, #post').bind( 'submit', function() {
		$('.sp-cm-multi-one-def').remove();
	} );

} );

$(window).load( function() {

} );

})(jQuery);


var sp_cm_media_editor_current;
if( 'undefined' != typeof wp.media && 'undefined' != typeof wp.media.editor )
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


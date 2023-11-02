(function( $ ) {
	'use strict';
	$(function() {
		/*var field, upload, remove, imgPreview;
		field = $('[data-id="url-file"]');
		remove = $('.remove-image');
		upload = $('.upload-image');
		imgPreview = $('.img-preview')*/
		//Opens the Media Library, assigns chosen file URL to input field, switches links
		$('.upload-image').on( 'click', function( e ) {
			var $this = $(this);
			//var $parent = $this.closest('td');
			var $parent = $this.parent().parent();
			var field, upload, remove, imgPreview;
			field = $parent.find('.url-file');
			remove = $parent.find('.remove-image');
			upload = $parent.find('.upload-image');
			imgPreview = $parent.find('.img-preview');
			
			e.preventDefault();
			var file_frame, json;
			if ( undefined !== file_frame ) {
				file_frame.open();
				return;
			}
			file_frame = wp.media.frames.file_frame = wp.media({
				button: {
					text: 'Choose File',
				},
				frame: 'select',
				multiple: false,
				title: 'Choose File'
			});
			file_frame.on( 'select', function() {
				json = file_frame.state().get( 'selection' ).first().toJSON();
				if ( 0 > $.trim( json.url.length ) ) {
					return;
				}
				/*
				View all the properties in the console available from the returned JSON object
				for ( var property in json ) {
					console.log( property + ': ' + json[ property ] );
				}*/
				
				field.val( json.id );
				imgPreview.append('<img src="'+json.url+'" style="max-width:100%;"/>');
				upload.toggleClass('hide');
				remove.toggleClass('hide');
			});
			file_frame.open();
		});
		//Remove value from input, switch links
		$('.remove-image').on( 'click', function( e ) {
			var $this = $(this);
			//var $parent = $this.closest('td');
			var $parent = $this.parent().parent();
			var field, upload, remove, imgPreview;
			field = $parent.find('.url-file');
			remove = $parent.find('.remove-image');
			upload = $parent.find('.upload-image');
			imgPreview = $parent.find('.img-preview');
			// Stop the anchor's default behavior
			e.preventDefault();
			// clear the value from the input
			field.val('');
			imgPreview.html('');
			// change the link message
			upload.toggleClass( 'hide' );
			remove.toggleClass( 'hide' );
		});
	});
})( jQuery );
// File Uploader
!function($){"use strict";$(function(){var e,t,l;e=$('[data-id="url-file"]'),l=$("#remove-file"),t=$("#upload-file"),t.on("click",function(i){i.preventDefault();var o,n;return void 0!==o?void o.open():(o=wp.media.frames.file_frame=wp.media({button:{text:"Choose File"},frame:"select",multiple:!1,title:"Choose File"}),o.on("select",function(){n=o.state().get("selection").first().toJSON(),0>$.trim(n.url.length)||(e.val(n.url),t.toggleClass("hide"),l.toggleClass("hide"))}),void o.open())}),l.on("click",function(i){i.preventDefault(),e.val(""),t.toggleClass("hide"),l.toggleClass("hide")})})}(jQuery);
// Date Picker
//!function($){"use strict";$(function(){$(".datepicker").datepicker({dateFormat:"D, m/d/yy"})})}(jQuery);
// Editor Label
//!function($){"use strict";$(function(){$('<h3 class="label-editor">'+Editor_Label.label+"</h3>").insertBefore("#postdivrich")})}(jQuery);
// Image Uploader
!function(e){"use strict";e(function(){e(".upload-image").on("click",function(i){var t,l,n,a,o,r,f=e(this).parent().parent();t=f.find(".url-file"),n=f.find(".remove-image"),l=f.find(".upload-image"),a=f.find(".img-preview"),i.preventDefault(),void 0===o?((o=wp.media.frames.file_frame=wp.media({button:{text:"Choose File"},frame:"select",multiple:!1,title:"Choose File"})).on("select",function(){r=o.state().get("selection").first().toJSON(),0>e.trim(r.url.length)||(t.val(r.id),a.append('<img src="'+r.url+'" style="max-width:100%;"/>'),l.toggleClass("hide"),n.toggleClass("hide"))}),o.open()):o.open()}),e(".remove-image").on("click",function(i){var t,l,n,a,o=e(this).parent().parent();t=o.find(".url-file"),n=o.find(".remove-image"),l=o.find(".upload-image"),a=o.find(".img-preview"),i.preventDefault(),t.val(""),a.html(""),l.toggleClass("hide"),n.toggleClass("hide")})})}(jQuery);
// Repeater
//!function($){"use strict";$("#add-repeater").on("click",function(e){e.preventDefault();var t=$(".repeater.hidden").clone(!0);return t.removeClass("hidden"),t.insertBefore(".repeater.hidden"),!1}),$(".link-remove").on("click",function(){var e=$(this).parents(".repeater");return e.hasClass("first")||e.remove(),!1}),$(".btn-edit").on("click",function(){var e=$(this).parents(".repeater");e.children(".repeater-content").slideToggle("150"),$(this).children(".toggle-arrow").toggleClass("closed"),$(this).parents(".handle").toggleClass("closed")}),$(function(){$(".repeater-title").on("keyup",function(){var e=$(this).parents(".repeater"),t=$(this).val();t.length>0?e.find(".title-repeater").text(t):e.find(".title-repeater").text(nhdata.repeatertitle)})}),$(function(){$(".repeaters").sortable({cursor:"move",handle:".handle",items:".repeater",opacity:.6})})}(jQuery);
  
/**
 * Repeaters
 */
(function( $ ) {
	'use strict';
	/**
	 * Clones the hidden field to add another repeater.
	 */
	$('#add-repeater').on( 'click', function( e ) {
		e.preventDefault();
		var clone = $('.repeater.hidden').clone(true);
		clone.removeClass('hidden');
		clone.insertBefore('.repeater.hidden');
		return false;
	});
	/**
	 * Removes the selected repeater.
	 */
	$('.link-remove').on('click', function() {
		console.log('REMOVE');
		
		var parents = $(this).parents('.repeater');
		if ( ! parents.hasClass( 'first' ) ) {
			parents.remove();
			
			
		}
		return false;
	});
	/**
	 * Shows/hides the selected repeater.
	 */
	$( '.btn-edit' ).on( 'click', function() {
		var repeater = $(this).parents( '.repeater' );
		repeater.children( '.repeater-content' ).slideToggle( '150' );
		$(this).children( '.toggle-arrow' ).toggleClass( 'closed' );
		$(this).parents( '.handle' ).toggleClass( 'closed' );
	});
	/**
	 * Changes the title of the repeater header as you type
	 */
	$(function(){
		$( '.repeater-title' ).on( 'keyup', function(){
			var repeater = $(this).parents( '.repeater' );
			var fieldval = $(this).val();
			if ( fieldval.length > 0 ) {
				repeater.find( '.title-repeater' ).text( fieldval );
			} else {
				repeater.find( '.title-repeater' ).text( nhdata.repeatertitle );
			}
		});
	});
	/**
	 * Makes the repeaters sortable.
	 */
	$(function() {
		$( '.repeaters' ).sortable({
			cursor: 'move',
			handle: '.handle',
			items: '.repeater',
			opacity: 0.6,
		});
	});
})( jQuery );
// Color Picker
!function($){"use strict";$(function(){$(".colorpicker").wpColorPicker()})}(jQuery);
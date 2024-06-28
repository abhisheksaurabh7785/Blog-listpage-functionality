(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {	
		// fetching post based on category selection 
		$('#category-dropdown').change(function() {
			var categorySlug = $(this).val();
			if (categorySlug) {
				var data = {
					'action': 'filter_posts_by_category',
					'cat_slug': categorySlug
				};
				$.ajax({
					url: abhi_blog_param.ajax_url,
					type: "POST",
					data: data,
					success: function(response) {
						$('.abhi-blog-area').html(response);
					}
				});
			}
		});
		// fetching post based on category selection and pagiation
		$(document).on('click', '.page-numbers', function (e) {
			e.preventDefault();
			var categorySlug = $('#category-dropdown').val();
			var href = $(this).attr('href');
			console.log(categorySlug);
			// Check if href is empty or not
			if (href) {
				var abhi_val_search = href.replace("?current_page=", '');
				var page_no = $.trim(abhi_val_search);
			} else {
				var page_no = 1;
			}
			var data = {
				action: 'abhi_blog_pagination',
				page_no: page_no,
				cat_slug: categorySlug,
			};
			$.ajax({
				url: abhi_blog_param.ajax_url,
				type: "POST",
				data: data,
				success: function(response) {
					$('.abhi-blog-area').html(response);
				}
			});
		})
	});
	

})( jQuery );

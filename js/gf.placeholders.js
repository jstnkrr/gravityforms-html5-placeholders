(function($){

	var gf_placeholder = function() {

		var gf_placeholders = window.gfPlaceholders.placeholders;

		if (!$.isArray(gf_placeholders)) {
			return;
		}

		$.each(gf_placeholders, function(i, placeholders) {
			$.each(placeholders, function(selector, placeholder) {
				$(selector).attr('placeholder', placeholder);
			});
		});
	};

	$(document).ready(function(){
		gf_placeholder();
		$(document).bind('gform_post_render', gf_placeholder);
	});

	var support = (!('placeholder' in document.createElement('input'))); // borrowed from Modernizr.com
	if ( support && window.gfPlaceholders.polyfill ) {
		$.ajax({
			cache: true,
			dataType: 'script',
			url: window.gfPlaceholders.polyfill,
			success: function() {
				$('input[placeholder], textarea[placeholder]').placeholder({
					blankSubmit: true
				});
			},
			type: 'get'
		});
	}

})(jQuery);

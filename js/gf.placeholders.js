(function($){

	var gf_placeholder = function() {

		if (typeof gf_placeholders == 'undefined') return;

		$.each(gf_placeholders, function(selector, placeholder) {
			$(selector).attr('placeholder', placeholder);
		});

		var support = (!('placeholder' in document.createElement('input'))); // borrowed from Modernizr.com
		if ( support && jquery_placeholder_url ) {
			$.ajax({
				cache: true,
				dataType: 'script',
				url: jquery_placeholder_url,
				success: function() {
					$('input[placeholder], textarea[placeholder]').placeholder({
						blankSubmit: true
					});
				},
				type: 'get'
			});
		}
	};

	$(document).ready(function(){
		gf_placeholder();
		$(document).bind('gform_post_render', gf_placeholder);
	});

})(jQuery);

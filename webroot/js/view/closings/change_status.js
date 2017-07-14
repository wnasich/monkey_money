;(function($) {
	$(document).ready(function() {
		var contentByAjax = $('.js-content-by-ajax');

		contentByAjax.each(function (index, element) {
			var targetUrl = $(element).data('content-url');
			$(element).load(targetUrl);
		});

	});
})(jQuery);

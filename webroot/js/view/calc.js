var currentVirtualKeyboardTarget = null;

(function($) {
	$(document).ready(function() {
		var calcBoard = $('#calc-board');

		calcBoard.on('click', '.btn', function(e) {
			e.preventDefault();

			var $currentTarget = $('#' + currentVirtualKeyboardTarget);

			if ($(this).data('method')) {
				switch ($(this).data('method')) {
					case 'reset':
						$currentTarget.val('');
						$currentTarget.trigger('change');
					break;
					case 'pageDown':
						$('html, body').animate({
							scrollTop: $(window).scrollTop() + ($(window).height() * 0.8)
						}, 600);
					break;
					case 'pageUp':
						$('html, body').animate({
							scrollTop: $(window).scrollTop() - ($(window).height() * 0.8)
						}, 600);
					break;
				}
			} else {
				var currentValue;

				if ($currentTarget.attr('disabled')) {
					return;
				}

				if ($currentTarget.prop('valueAsNumber')) {
					currentValue = $currentTarget.prop('valueAsNumber');
				} else {
					currentValue = $currentTarget.val();
				}

				currentValue += $(this).text();
				$currentTarget.val(currentValue);
				$currentTarget.trigger('change');
			}
		});

	});
})(jQuery);

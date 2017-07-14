;(function($) {
	$(document).ready(function() {
		var currentMovements = $('#current-movements-container'),
			newOutputMovementContainer = $('#new-output-movement-container'),
			newInputMovementContainer = $('#new-input-movement-container'),
			newClosingContainer = $('#new-closing-container'),
			contentByAjax = $('.js-content-by-ajax');

		contentByAjax.each(function (index, element) {
			var targetUrl = $(element).data('content-url');
			$(element).load(targetUrl);
		});

		contentByAjax.on('submit', 'form', function(e) {
			e.preventDefault();
			var thisForm = $(this),
				formContainer = thisForm.closest('.js-content-by-ajax');

			thisForm.find('.js-stateful-button').button('saving');

			$.post(thisForm.attr('action'), thisForm.serializeArray(), function(html) {
				formContainer.html(html);
				currentMovements.load(currentMovements.data('content-url'));

				var withErrors = formContainer.find('.form-group.has-error');
				if (withErrors.length > 0) {
					$('html, body').animate({
						scrollTop: withErrors.first().offset().top
					}, 600);
				}

			});
		});

		$('#new-movement-accordion').on('click', '.js-load-ajax-content', function(e) {
			e.preventDefault();
			var formContainer = $(this).closest('.js-content-by-ajax');
			formContainer.load($(this).attr('href'));
		});

		$('#new-movement-accordion').on('shown.bs.collapse', 'div.panel', function(e) {
			$(this).find('input[type="text"], input[type="number"]').first().focus().trigger('click');
		});

		newClosingContainer.on('change', '#change-bills-box input', function (e) {
			var changeAmountValue = 0.0;

			$('#change-bills-box input').each(function (index, element) {
				var quantity = parseInt($(element).val()),
					billCode = $(element).data('bill-code');

				if (!isNaN(quantity) && billCode && (typeof billRatios[billCode] !== 'undefined')) {
					changeAmountValue += billRatios[billCode] * quantity;
				}
			});

			$('#change-amount').val(changeAmountValue);
		});

		$('#new-movement-accordion').on('click', 'div.text, div.number', function(e) {
			e.stopPropagation();
			var clickedInput = $(this).find('input[type="text"]:not([readonly]), input[type="number"]:not([readonly])');

			if (clickedInput.length > 0) {
				$('#new-movement-accordion').find('div.text, div.number').removeClass('has-success');

				currentVirtualKeyboardTarget = clickedInput.attr('id');
				clickedInput.focus();
				$(this).addClass('has-success');
			}
		});

		newClosingContainer.on('click', '.js-ask-confirmation', function (e) {
			return confirm($(this).data('message'));
		});

		newClosingContainer.on('click', '#allow-empty-amount', function (e) {
			if ($(this).filter(':checked').length > 0) {
				$('#closing-amount').attr('disabled', true);
			} else {
				$('#closing-amount').removeAttr('disabled');
			}
		});

		$('#header-new-output-movement, #header-new-input-movement, #header-new-closing').click(function (e) {
			e.stopPropagation();

			$(this).siblings('div.panel-collapse').collapse('toggle');
		});

		$('#new-output-movement-container, #new-input-movement-container, #new-closing-container').on('click', 'div.checkbox', function (e) {
			$(this).find('input:visible').trigger('click');
		});

		$('#new-output-movement-container, #new-input-movement-container, #new-closing-container').on('click', 'div.checkbox input', function (e) {
			e.stopPropagation();
		});
		$('#new-output-movement-container, #new-input-movement-container, #new-closing-container').on('click', 'div.checkbox label', function (e) {
			e.stopPropagation();
		});

	});
})(jQuery);

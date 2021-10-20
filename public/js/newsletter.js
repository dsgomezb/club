(function () {
	$('#newsletter-form').on('submit', function (e) {
		e.preventDefault();

		$form = $(this);
		$('button', $form).text('Espere...');

		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $form.serialize(),
			success: function () {
				iziToast.show({
				    title: 'Gracias',
				    message: 'El correo se agregó con éxito',
				    color: 'green',
				});
				$('button', $form).poro('disabled', true);
			},
			error: function(xhr) {
				iziToast.show({
				    title: 'Error',
				    message: getAjaxError(xhr),
				    color: 'red',
				    timeout: false
				});
			},
			complete: function () {
				$('input', $form).val('');
				$('button', $form).text('Suscribirse');
			}
		})
	});

	function getAjaxError(xhr) {
		var message = 'Ocurrió un error, vuelva a intentar';
		if (xhr.status == 422) {
			for (var i  in xhr.responseJSON.errors) {
				message = xhr.responseJSON.errors[i][0];
				break;
			}
		}
		return message;
	}
})();
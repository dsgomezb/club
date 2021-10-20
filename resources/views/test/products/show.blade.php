<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-2">
				<form>
					<h2>Formulario</h2>
					@php
						$options = [];
					@endphp
					@foreach ($product->atributos() as $atributo)
						<div class="form-group">
							<label>{{ $atributo->value }} <span style="display: none" class="fa fa-spin fa-spinner"></span></label>
							<select autocomplete="off" data-options="{{ $loop->iteration }}" name="{{ $atributo->value }}">
								@foreach ($product->variantes($atributo->value, $options) as $variante)
									<option data-atributo="{{ $atributo->value }}" value="{{ $variante->value }}">{{ $variante->value }}</option>
									@if($loop->first)
										@php
											$options[$atributo->value] = $variante->value;
										@endphp
									@endif
								@endforeach
							</select>
						</div>
					@endforeach
				</form>
			</div>
		</div>
	</div>
	<script
		src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous">
	</script>

	<script>
		var id = {{ $product->id }};
		$('[data-options]').on('change', function () {
			var index = $(this).data('options'), options = {};
			$('[data-options]').each(function () {
				if ($(this).data('options') > index) {
					$(this).prop('disabled', true).siblings('label').find('span').show();
				} else {
					options[$(this).attr('name')] = $(this).val();
				}
			});

			$.ajax({
				url: '/test/products/' + id + '/variants',
				method: 'get',
				data: {
					index: index,
					options: options
				},
				success: function (response) {
					for (var i in response) {
						$('[data-options="'+ i +'"]').html(response[i])
							.prop('disabled', false)
							.siblings('label')
							.find('span')
							.hide()
						;
					}
				}
			})
		});

		//
	</script>
</body>
</html>
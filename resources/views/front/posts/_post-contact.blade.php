<form action="/business-contact/{{ $post->id }}" class="form row" method="post">
	@csrf
	
	<div class="col-md-12 mb-4">
		<textarea name="message" class="form-control form-control-square text-muted" id="textarea-input" rows="5" placeholder="Comentario"></textarea>
	</div>

	{{--
	<div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="E-mail"></div>
	<div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="Nombre"></div>
	<div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="Teléfono"></div>
	--}}

	<div class="col-md-12">
		<button class="btn btn-white btn-square btn-md w-100 m-0" type="submit">Enviar</button>
	</div>
</form>
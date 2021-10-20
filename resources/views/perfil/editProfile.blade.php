@extends("front.layouts.app")

@section("content")
  	<!-- Perfil -->


    <section class="container-fluid pt-3 padding-bottom-3x">
		<div class="row">
			<div class="col-md-12 mb-3">
    			@include('front.partials.errors')
    		</div>
			<div class="col-md-9 mb-3">
				<div class="bg-dark">
					<div class="row">
						<div class="col-md-12 pl-5 pr-5 pt-5 pb-0">
							<h2 class="color-gold mb-0">Mi perfil</h2>
						</div>
						<div class="col-md-12 pt-0">
							<form action="{{ route('profile.update') }}" method="post" class="form row p-4" enctype="multipart/form-data">
                                @csrf
			              		<div class="col-md-3 mb-4">
			              			@include("perfil.partials.upload-preview",[
			              				'resource'=>'users',
			              				'prop'=>'image',
			              				'label'=>'Imagen',
			              				'model'=> $user,
			              				'extraClass'=>'profile-upload'
			              			])
			              		</div>

			              		<div class="col-md-9 mb-4">
			              			<div class="row">
			              				<div class="col-md-6 mb-6">
			              					<label for="">Nombre de Usuario</label>
											<p>{{$user->username}}</p>
										</div>
										<div class="col-md-6 mb-6">
			              					<label for="">Email</label>
											<p>{{$user->email}}</p>
										</div>
			              				<div class="col-md-12 mb-4">
			              					<label for="">Acerca de mí</label>
											<textarea name="about" class="form-control form-control-square text-muted" id="textarea-input2" rows="5" >{{$user->about}}</textarea>
										</div>
			              			</div>
			              		</div>

			              		<div class="col-md-12">
			              			<hr>
			              			<h5 class="color-gold mt-2">Cambiar contraseña</h5>

			              			<div class="row">
			              				<div class="col-md-6 mb-4">
											<input name="password" autocomplete="off" type="password" class="form-control form-control-square" placeholder="Nueva contraseña">
										</div>
			              				<div class="col-md-6 mb-4">
											<input name="password_confirmation" autocomplete="off" type="password" class="form-control form-control-square" placeholder="Reingrese la nueva contraseña">
										</div>
			              			</div>
			              		</div>

								<div class="col-md-12">
									<button class="btn btn-white btn-square btn-sm w-100 m-0" type="submit">Actualizar perfil</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			@include("perfil.partials._sidebar")
		</div>
    </section>

@endsection

@section("scripts")
	<script src="/backend/js/formplugins/uploadPreview/jquery.uploadPreview.min.js"></script>
	{{-- <script src="/summernote/summernote.min.js"></script>
	<script>
		$('#textarea-input, #textarea-input2').summernote({
			height: 300,
			minHeight: null,
			maxHeight: null,
			focus: true,
			height: 200,
            tabsize: 2,
            dialogsFade: true,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
		});
		$('input[name="minimum_investment"]').on('keypress', function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) return false;
        });
	</script> --}}
@endsection
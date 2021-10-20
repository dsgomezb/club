@extends("front.layouts.app")


@section("content")
	
    <section class="container-fluid padding-top-1x padding-top-md-3x padding-bottom-3x">
		<div class="row">
			<div class="col-md-9 ">
				<div class="w-100 bg-dark p-3 ">
					<div class="row align-items-center">
						<h1 class="col-md-6 col-sm-12 mb-3 mb-md-0 text-white">Contactanos</h1>
						<div class="col-md-6 col-sm-12 ">
							<div class="d-flex align-items-center"><i style="font-size: 25px;" class="material-icons mr-2 color-gold text-md">mail_outline</i> <span>info@clubdecaballeros.com.ar</span></div>
							<div class="d-flex align-items-center mt-2 mb-2"><i style="font-size: 25px;" class="material-icons mr-2 color-gold text-md">phone</i> <span>(011) 5959-1555</span></div>
							<a href="" target="_blank" class="social-button shape-circle sb-facebook sb-light-skin"><i class="socicon-facebook color-gold"></i></a>
							<a href="" target="_blank" class="social-button shape-circle sb-twitter sb-light-skin"><i class="socicon-twitter color-gold"></i></a>
						</div>
					</div>
				</div>

				<div class="w-100 bg-dark p-3 mt-3 mb-3">
					<h4>¿Tenés alguna duda?</h4>
					<p>Completá el siguiente formulario y contactate con nosotros</p>
					<form method="post" action="/contact" class="form row">
                        @csrf
			
						<div class="col-md-12 mb-4">
							@include('front.partials.errors')
						</div>
				
						<div class="col-md-12 mb-4">
							<textarea name="message" class="form-control form-control-square text-muted" id="textarea-input2" rows="5" placeholder="Mensaje"></textarea>
						</div>

						<div class="col-md-12 pb-3">
							<button class="btn btn-white btn-square btn-sm w-100 m-0" type="submit">Enviar</button>
						</div>
					</form>
				</div>
			</div>
			@include("front.partials._sidebar")
		</div>
    </section>
@endsection
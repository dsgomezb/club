@extends("front.layouts.app")

@section("content")
  	<!-- Perfil -->
    <section class="container-fluid pt-3 padding-bottom-3x">
		<div class="row">
			<div class="col-md-12 mb-3">
				@include("perfil._profile")
			</div>

			<div class="col-md-12 mb-3">
				@include('front.partials.errors')
			</div>

			{{-- Ultimas entradas del usuario --}}
			<div class="col-md-9 mb-3">
				<div class="bg-dark">
					<div class="row">
						<div class="col-md-12 pt-5">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item w-50"><a class="text-center nav-link active" href="#publicaciones" data-toggle="tab" role="tab">Publicaciones</a></li>
								<li class="nav-item w-50"><a class="text-center nav-link" href="#calificaciones" data-toggle="tab" role="tab">Calificaciones</a></li>
							</ul>

							<div class="tab-content">
					            <div class="tab-pane transition fade left show active" id="publicaciones" role="tabpanel">
					            	<div class="row p-4">
					            		<div class="col-md-12">
											<div class="isotope-grid cols-3">
												<div class="gutter-sizer"></div>
							            		<div class="grid-sizer"></div>

							            		@forelse ($posts as $post)
							            			@include('front.home._card', ['profile' => $user->id == \Auth("user")->id()])
							            		@empty
							            			<div class="grid-item">
			            								<h4 class=" pl-3 color-gold">Aún no tiene publicaciones</h4>
							            			</div>
							            		@endforelse
			            					</div>
		            					</div>
					            	</div>
		            			</div>
		            			<div class="tab-pane transition fade left" id="calificaciones" role="tabpanel">
									@forelse($user->califications as $calification)
			            				@include('perfil._calification',compact("calification"))
			            			@empty
			            				<div class="row">
			            					<div class="col-md-12">
			            						<h4 class=" pl-3 color-gold">Aún no tiene calificaciones</h4>
			            					</div>
			            				</div>
		            				@endforelse
		            			</div>
		            		</div>
		            	</div>
		            </div>
				</div>
			</div>

			@include("perfil.partials._sidebar")
		</div>
    </section>

@endsection

@section('scripts')
	<script>
		$('.delete').on('click', function (e) {
			e.preventDefault();
			var result = confirm('¿Está seguro que desea borrar esta publicación?');
			if (result) {
				$(this).next().submit();
			}
		})
	</script>
@endsection
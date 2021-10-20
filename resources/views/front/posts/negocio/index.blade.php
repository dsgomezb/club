@extends("front.layouts.app")

@section("content")
  	<!-- Entradas-->
    <section class="container-fluid pt-3 pb-3 post">
		<div class="row">
			<div class="col-md-9">
				@include("front.posts.negocio._post-content")
			</div>

			@include("front.partials._sidebar")
		</div>
    </section>

@endsection
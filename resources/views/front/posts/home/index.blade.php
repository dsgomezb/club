@extends("front.layouts.app")

@section("content")
  	<!-- Entradas-->
    <section class="container-fluid pt-3 pb-3 padding-bottom-3x post">
		<div class="row post-content">
			<div class="col-md-9">
				@include("front.posts.home._post-content")
				
				{{-- @include("front.posts.home._post-comments") --}}

				<div class="bg-dark mt-3 py-5 mb-3">
					<div class="row pl-3 pr-3">
						<div class="col-md-10 offset-md-1 text-center">
							<p class="text-uppercase">{{ $post->comments->count() }} respuestas</p>

							<div class="comments mt-5">
								@comments(['model' => $post])
							</div>
						</div>
					</div>
				</div>
			</div>

			@include("front.partials._sidebar")
		</div>
    </section>

@endsection
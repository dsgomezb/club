<div class="bg-dark mt-3 py-5 mb-3">
	<div class="row pl-3 pr-3">
		<div class="col-md-10 offset-md-1 text-center">
			<p class="text-uppercase">{{ $post->comments->count() }} respuestas</p>

			<div class="comments my-5">
				@each("front.posts.home._post-comment", $post->comments, 'comment')
			</div>

			<p class="text-uppercase  pb-5 mb-0">Dejá tu comentario</p>
			@include('front.posts._post-contact')
		</div>
	</div>
</div>
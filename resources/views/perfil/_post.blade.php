<div class="col-md-12 mb-3">
	<div class="bg-dark">
		<img style="object-fit: cover;width: 100%;height: 100%;" src="/content/posts/show/{{ $post->thumb }}" alt="{{ $post->title }}" class="image">
		<div class="d-flex justify-content-start  align-items-start align-items-md-center">
			<div class="category-card-date bg-darker">
				<span>{{ $post->published_at->formatLocalized('%b') }}</span>
                <span>{{ $post->published_at->day }}</span>
                <span  class="color-gold">{{ $post->published_at->year }}</span>
			</div>
			<div class="d-none d-md-flex flex-column flex-md-row mt-2 mt-md-0">
				<span class="ml-3 text-white"><i class="material-icons person_outline mr-1 color-gold"></i>por {{ $post->author->full_name }}</span>
				<span class="ml-3 text-white mt-2 mt-md-0"><i class="material-icons chat_bubble_outline mr-1 color-gold"></i>{{ $post->comments->count() }} comentarios</span>
				<span class="ml-3 text-white mt-2 mt-md-0"><i class="material-icons bookmark_border mr-1 color-gold"></i>{{ $post->category->value }}</span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10 offset-md-1 mt-4 text-justify post-content">
				<div class="pl-3 pr-3">
					<h2 class="text-center col-sm-12 col-md-8 ml-auto mr-auto mt-0 mb-0 mb-md-4 mt-md-4 text-white">{{ $post->title }}</h2>
					{{-- Post content --}}
					<p class="d-none d-md-block">
						{!! \Str::limit($post->content, 140) !!}
					</p>
				</div>
			</div>

			<div class="col-md-12 justify-content-between d-flex">
				<a href="{{ route('post.edit', $post->slug) }}" class="color-gold navi-link p-4">Editar</a>
                <a href="{{ route('post.delete', $post->slug) }}" class="delete color-gold navi-link p-4 text-right w-100">Borrar</a>
                <form action="{{ route('post.delete', $post->slug) }}" method="post">
                	@method('DELETE')
                	@csrf
                </form>
			</div>
		</div>
	</div>
</div>
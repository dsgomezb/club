<div class="grid-item gallery-item mb-sm-30 mb-3">
	<a class="category-card flex-wrap text-center p-0 bg-dark" href="/{{ $post->category->slug }}/{{ $post->slug }}">
    	<div class="category-card-thumb position-relative w-100">
    		<img src="/content/posts/index/{{ $post->thumb }}" alt="{{ $post->title }}">
    		<div class="category-card-date bg-dark">
    			<span>{{ $post->published_at->formatLocalized('%b') }}</span>
    			<span>{{ $post->published_at->day }}</span>
    			<span  class="color-green">{{ $post->published_at->year }}</span>
    		</div>
    	</div>
      <div class="category-card-info w-100 p-3 text-left">
        <h4 class="text-white pr-4 font-weight-bold">{{ $post->title }}</h4>
        <p class="category-card-subtitle text-muted pr-4 text-justify">{{ \Str::limit(strip_tags($post->content), 80) }}</p>

        <div class="d-flex justify-content-between mt-4">
          @if (isset($profile) && auth('user')->id() == $post->user_id)
            <sapn data-link="{{ route('post.edit', $post->slug) }}" class="edit color-green navi-link p-4">Editar</sapn>
            <sapn class="delete color-green navi-link p-4">Borrar</sapn>
            <form action="{{ route('post.delete', $post->slug) }}" method="post">
              @method('DELETE')
              @csrf
            </form>
          @else
        	 <span class="color-green"><small>{{ $post->category->value }}</small></span>
          @endif
        </div>
      </div>
    </a>
</div>

@section('scripts')
  <script>
    $('.edit').on('click', function (e) {
      e.preventDefault();
      window.location = $(this).data('link');
    });

    $('.delete').on('click', function (e) {
      e.preventDefault();
      var result = confirm('¿Está seguro que desea borrar esta publicación?');
      if (result) {
        $(this).next().submit();
      }
    })
  </script>
@endsection
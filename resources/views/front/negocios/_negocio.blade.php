<div class="grid-item mb-30">
	<div class="card card-negocio position-relative flex-wrap text-center p-0 bg-darker border border-white">
		<div class="image">
			<img src="/content/posts/mini/{{ $post->thumb }}" alt="{{ $post->title }}">
		</div>
    <div class="card-info w-100 p-3 text-left d-flex flex-column justify-content-between position-relative" style="z-index: 1">
      <div class="text-center mt-3 mt-sm-0">
      	<h4 class="text-white text-center mt-4 mt-sm-5 pl-4 pr-4">{{ $post->title }}</h4>
        <div class="d-inline-block">
      	 <a href="/{{ $post->category->slug }}/{{ $post->slug }}" class="text-center btn btn-outline-light btn-square btn-md mt-0 d-none d-md-block">Ver más</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="{{$col ?? 'col-md-3'}}">
	<div class=" bg-dark p-3">
		<div class="mb-5 mt-4">
            @if ($latestBusinesses->count())
			 <h5 class="color-gold mb-2">Publicaciones de negocios</h5>
             @foreach ($latestBusinesses as $latestBusines)
                 <div class="mb-5">
                    <img src="/content/posts/mini/{{ $latestBusines->thumb }}" alt="{{ $latestBusines->title }}">
                    <div>
                        <p class="mb-0 mt-1">{{ $latestBusines->title }}</p>
                        <a href="/{{ $latestBusines->category->slug }}/{{ $latestBusines->slug }}" class="navi-link color-gold">Leer más</a>
                    </div>
                </div>
             @endforeach
            @endif
		</div>
	</div>
</div>
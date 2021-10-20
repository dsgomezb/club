@inject('calendar', 'App\Classes\Calendar')

<div class="{{$col ?? 'col-md-3'}}">
	<div class=" bg-dark p-3">
		<div class="mb-5 mt-4">
			<h5 class="color-gold">Publicaciones</h5>
			<ul class="text-white list-unstyled">
                @foreach ($months as $month)
				    <li><a href="/publicaciones/{{ strtolower($calendar->numberToMonth($month->month)) }}/{{ $month->year }}" class="navi-link text-white">{{ $calendar->numberToMonth($month->month) }} ({{ $month->total }})</a></li>
                @endforeach
			</ul>
		</div>

		<div class="mb-5">
			<h5 class="color-gold">Más populares</h5>
			<div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;margin&quot;: 0, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;630&quot;:{&quot;items&quot;:1},&quot;991&quot;:{&quot;items&quot;:1},&quot;1200&quot;:{&quot;items&quot;:1}} }">
                @foreach ($populars as $popular)
				    <a href="/{{ $popular->category->slug }}/{{ $popular->slug }}" class="navi-link text-white mt-1"><img src="/content/posts/index/{{ $popular->thumb }}" alt="{{ $popular->title }}">
                        <h5 class="text-white mt-1">{{ $popular->title }}</h5>
                    </a>
                @endforeach
			</div>
		</div>

		<div class="mb-5">
			<h5 class="color-gold">Newsletter</h5>
			<form id="newsletter-form" action="/newsletter" method="post" class="form">
				<div class="form-group">
					<input name="email" class="form-control form-control-square newsletter" type="email" id="normal-square-input" placeholder="E-mail">
				</div>

				<div class="form-group">
					<button class="btn btn-white btn-square w-100 btn-md" type="submit">Suscribirse</button>
				</div>
			</form>
		</div>

		<div class="mb-5">
			<h5 class="color-gold">Archivo</h5>
			<div id="calendar"></div>
			
			<script>
				var calendarData = {!! $calendarData !!};
			</script>
		</div>
	</div>
</div>
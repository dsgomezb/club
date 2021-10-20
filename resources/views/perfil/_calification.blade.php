<div class="row border-bottom border-primary">
	<div class="col-md-3 pt-0 pt-2 p-md-4 pl-5 pr-5 text-center position-relative">
		<div class="d-inline-block position-relative profile-picture">
			<img class="rounded-circle border border-white" style="width: 130px;" src="/content/users/sm/{{ $calification->author->thumb }}" alt="">
		</div>
	</div>
	<div class="col-md-9 text-center text-md-left position-relative">
		<div class=" pb-0 pt-2 p-md-4 pl-5 pr-5">
			<small style="font-size: 0.75em">{{ $calification->created_at->format('d/m/Y') }}</small>
			<h2 class="color-gold mb-0">{{ $calification->author->fullname }}</h2>
			<p class="mb-0">Entrada: <a class="navi-link" href="/{{ $calification->post->category->slug }}/{{ $calification->post->slug }}">{{$calification->post->title}}</a></p>

			@include('perfil._rate', [
				'calification'=>$calification,
				'stars'=>$calification->stars,
				'post'=>$calification->post
			])

			<p class="mt-2"> {{$calification->comment}} </p>
		</div>
	</div>
</div>
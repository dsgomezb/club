@include('front.partials.errors')

<div class="bg-dark ">
	<div class="row">
		<div class="col-md-10 offset-md-1 post-content padding-top-4x padding-bottom-4x" >
			<div class="pl-3 pr-3">
				<h2 class="text-white col-9 col-md-12 p-0">{{ $post->title }}</h2>
				<div class="d-flex pb-5">
					<a href="{{$post->author->profilePath}}" class="navi-link text-white"><i class="material-icons person_outline mr-1 color-gold"></i>Por {{ $post->author->full_name }}</a>
					<span class="ml-3 text-white">{{ $post->published_at->format('d/m/Y') }}</span>
				</div>
			</div>
			<img src="/content/posts/show/{{ $post->thumb }}" class="image" alt="{{ $post->title }}">

			<div class="row py-5 pl-3 pr-3">
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Locación</small>
					<p>{{ $post->location }}</p>
				</div>
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Publicado</small>
					<p>Hace 1 mes</p>
				</div>
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Área</small>
					<p>{{ $post->zone }}</p>
				</div>
				<div class="col-md-3 mb-2 mb-md-0"></div>
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Inversión mínima</small>
					{{-- <p>${{ number_format(($post->minimum_investment), 0, '', '.') }}</p> --}}
					<p>${{ $post->minimum_investment}}</p>
				</div>
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Empresa</small>
					<p>{{ $post->company }}</p>
				</div>
				<div class="col-md-3 mb-2 mb-md-0">
					<small class="color-gold">Comienzo</small>
					<p>{{ $post->start }}</p>
				</div>
			</div>

			<div class="pl-3 pr-3">
				<p class="text-justify">
					{!! $post->content !!}
				</p>
			</div>

			<div class="row">
				@if($post->canQualify())
					<div class="col-md-10 offset-md-1 mt-50 justify-content-center text-center margin-bottom-2x margin-top-1x">
						<h5 class="color-gold">Calificar entrada</h5>
						@php 
							$stars = $post->getAuthQualification()
						@endphp
						@include('perfil._rate',[
							'canQualify'=>($stars == 0), 
							'post'=>$post,
							'star'=>$stars
						])
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@if ($post->author->id != \Auth::guard('user')->id())	
	<div class="bg-dark my-3">
		<div class="row">
			<div class="col-md-10 offset-md-1 post-content padding-top-2x padding-bottom-4x text-center ">
				<p class="text-uppercase padding-bottom-2x mb-0">Contactar</p>
				<div class="pl-3 pr-3">
					@include("front.posts._post-contact")
				</div>
			</div>
		</div>
	</div>
@endif
	
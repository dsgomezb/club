<div class="bg-dark">
	
	<div class="row">
		<div class="col-md-12">
			<div class="post-content mt-5 row pl-3 pr-3">
				<h2 class="text-center col-sm-12 col-md-6 m-auto">{{ $post->title }}</h2>

				<div class="col-md-10 offset-md-1 mt-4 text-justify">
					{!! $post->content !!}
				</div>

				<div class="col-md-10 offset-md-1 mt-50 justify-content-center text-center margin-top-3x margin-bottom-1x">
					<img class="rounded-circle border border-white" style="width: 100px;" src="/content/users/thumb/{{ $post->author->thumb }}" alt="{{ $post->author->full_name }}">
					<div>
						<p class="color-gold mb-0">{{ $post->author->full_name }}</p>
						@if(!$post->authIsAuthor())<a href="{{$post->author->profilePath}}" class="navi-link">Ver perfil</a> @endif
					</div>
					<p class="ml-auto mr-auto mt-4 col-sm-12 col-md-6">{{ $post->author->about }}</p>
				</div>

				@if($post->canQualify())
					<div class="col-md-10 offset-md-1 mt-50 justify-content-center text-center margin-bottom-2x">
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
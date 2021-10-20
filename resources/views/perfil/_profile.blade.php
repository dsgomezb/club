<div class="bg-dark">
	<div class="row align-items-center profile">
		<div class="col-md-3 pt-0 pt-2 p-md-4 pl-5 pr-5 text-center position-relative">
			<div class="d-inline-block position-relative profile-picture">
				<img class="rounded-circle border border-white" style="width: 130px;" src="/content/users/sm/{{ $user->thumb }}" alt="">
			</div>
		</div>
		<div class="col-md-9 text-center text-md-left position-relative">
			<div class=" pb-0 pt-2 p-md-4 pl-5 pr-5">
				<h2 class="color-gold mb-0">{{ $user->full_name }}</h2>
				@include('perfil._rate', [
					'stars' => $user->stars,
					'user'=>$user
				])
				
				<p class="mt-2">{{ $user->about}}</p>

				@if($user->id == \Auth("user")->id())
					<a href="/perfil/edit" class="navi-link position-absolute bottom-0 right-0 mr-5"><small class="">Editar Perfil</small></a>
				@endif
			</div>
		</div>
	</div>
</div>
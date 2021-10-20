@extends("front.layouts.app")

@section("content")
  	<!-- Perfil -->

    @include('front.partials.errors')

    <section class="container-fluid pt-3 padding-bottom-3x">
		<div class="row">
			{{-- Crear entradas --}}
			<div class="col-md-9 mb-3">
				<div class="bg-dark">
					<div class="row">
						<div class="col-md-12 pt-5">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item w-50"><a class="text-center nav-link active" href="#expieriencia" data-toggle="tab" role="tab">Edición</a></li>
							</ul>

							<div class="tab-content">
                                @if ($post->category_id != \App\Category::BUSINESSES)
                                    <div class="tab-pane show active" id="expieriencia" role="tabpanel">
                                        <form action="{{ route('post.edit', $post->slug) }}" method="post" class="form row p-4" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="col-md-4 mb-4">
                                                @include("perfil.partials.upload-preview",['resource'=>'posts','prop'=>'image1','label'=>'Imagen','model'=> $post])
                                            </div>

                                            <div class="col-md-8"></div>

                                            <div class="col-md-6 mb-4">
                                                <input name="title" type="text" class="form-control form-control-square" placeholder="Título" value="{{ old('title', $post->title) }}">
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <select name="category_id" class="form-control form-control-square" id="select-input">
                                                    @foreach ($categories as $category)
                                                        @php
                                                            $selected = $post->category_id == $category->id ? 'selected' : ''
                                                        @endphp
                                                        <option {{ $selected }} value="{{ $category->id }}">{{ $category->value }}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                            
                                            <div class="col-md-12 mb-4">
                                                <textarea name="content" class="form-control form-control-square text-muted" id="textarea-input" rows="5" placeholder="Cuerpo">{{ old('content', $post->content) }}</textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <button class="btn btn-white btn-square btn-sm w-100 m-0" type="submit">Enviar</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="tab-pane show active" id="negocio" role="tabpanel">
                                       <form action="{{ route('businesses.edit', $post->slug) }}" method="post" class="form row p-4" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="col-md-4 mb-4">
                                                @include("perfil.partials.upload-preview",['resource'=>'posts','prop'=>'image1','label'=>'Imagen','model'=> $post])
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                @include("perfil.partials.upload-preview",['resource'=>'posts','prop'=>'image2','label'=>'Imagen','model'=> $post])
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                @include("perfil.partials.upload-preview",['resource'=>'posts','prop'=>'image3','label'=>'Imagen','model'=> $post])
                                            </div>

                                            <div class="col-md-12 mb-4">
                                                <input name="title" type="text" class="form-control form-control-square" placeholder="Título" value="{{ old('title', $post->title) }}">
                                            </div>
                                            
                                            <div class="col-md-12 mb-4">
                                                <textarea name="content" class="form-control form-control-square text-muted" id="textarea-input2" rows="5" placeholder="Cuerpo">{{ old('content', $post->content) }}</textarea>
                                            </div>

                                            <div class="col-md-4 mb-4">
                                                <input name="location" type="text" class="form-control form-control-square" placeholder="Locación" value="{{ old('location', $post->location) }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <input name="zone" type="text" class="form-control form-control-square" placeholder="Zona" value="{{ old('zone', $post->zone) }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <input name="minimum_investment" type="text" class="form-control form-control-square" placeholder="Inversión mínima" value="{{ old('minimum_investment', $post->minimum_investment) }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <input name="company" type="text" class="form-control form-control-square" placeholder="Empresa" value="{{ old('company', $post->company) }}">
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <input name="start" type="text" class="form-control form-control-square" placeholder="Comienzo" value="{{ old('start', $post->start) }}">
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-white btn-square btn-sm w-100 m-0" type="submit">Enviar</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
    					            
    
					        </div>
						</div>
					</div>
				</div>
			</div>

			@include("perfil.partials._sidebar")
		</div>
    </section>

@endsection

@section("scripts")
	<script src="/backend/js/formplugins/uploadPreview/jquery.uploadPreview.min.js"></script>
    <script src="/summernote/summernote.min.js"></script>
    <script>
        $('#textarea-input, #textarea-input2').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
            height: 200,
            tabsize: 2,
            dialogsFade: true,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
        });

        $('input[name="minimum_investment"]').on('keypress', function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) return false;
        });
    </script>
@endsection
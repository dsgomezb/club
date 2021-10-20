{{-- <div class="card" style="background: trans"> --}}
    {{-- <div class="card-body p-0"> --}}
        @if($errors->has('commentable_type'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->get('commentable_type') }}
            </div>
        @endif
        @if($errors->has('commentable_id'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->get('commentable_id') }}
            </div>
        @endif
        <form method="POST" class="form" action="{{ url('comments') }}">
            @csrf
            @honeypot
            <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->id }}" />

            {{-- Guest commenting --}}
            @if(isset($guest_commenting) and $guest_commenting == true)
                <div class="form-group">
                    <label for="message">DEJA TU COMENTARIO</label>
                    <input type="text" class="form-control form-control-square text-muted @if($errors->has('guest_name')) is-invalid @endif" name="guest_name" />
                    @error('guest_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">Mail:</label>
                    <input type="email" class="form-control form-control-square text-muted @if($errors->has('guest_email')) is-invalid @endif" name="guest_email" />
                    @error('guest_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="form-group mt-5">
                <label for="message">DEJA TU COMENTARIO</label>
                <textarea id="textarea-input" rows="5" placeholder="Comentario" class="mt-5 form-control form-control-square text-muted @if($errors->has('message')) is-invalid @endif" name="message"></textarea>
                <div class="invalid-feedback">
                    Your message is required.
                </div>
                {{-- <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> --}}
            </div>
    
            {{-- TODO: Maxi, asumo que estos campos ya no van? Lo dejo por las dudas --}}
            {{-- <div class="form-group row">
                <div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="E-mail"></div>
                <div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="Nombre"></div>
                <div class="col-md-4 mb-4"><input type="text" class="form-control form-control-square" placeholder="Teléfono"></div>
            </div> --}}
            <button class="btn btn-white btn-square btn-md w-100 m-0" type="submit">Enviar</button>
        </form>
    {{-- </div> --}}
{{-- </div> --}}
<br />
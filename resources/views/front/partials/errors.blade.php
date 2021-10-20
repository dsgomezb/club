@if ($errors->any())
    <div class="alert alert-danger border-0">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

@if (session()->has('message'))
    <div class="alert alert-{{ session()->get('message.type') }} border-0">
        {{ session()->get('message.content') }}
    </div>
@endif
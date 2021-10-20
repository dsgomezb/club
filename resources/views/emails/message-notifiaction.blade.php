@component('mail::message')
Nuevo contacto
<br><br>

<p><strong>Nombre: </strong>{{$data['name']}}</p>
<p><strong>Email: </strong>{{$data['email']}}</p>
<p><strong>Asunto: </strong>{{$data['subject']}}</p>
<p><strong>Mensaje: </strong>{{$data['message']}}</p>

{{ config('app.name') }}
@endcomponent

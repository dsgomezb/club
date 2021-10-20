@component('mail::message')
#{{ $sender->full_name }} envía el siguiente mensaje de contacto

{{ $contactMessage }}

@component('mail::button', ['url' => 'mailto:' . $sender->email])
Responder
@endcomponent

{{ config('app.name') }}
@endcomponent

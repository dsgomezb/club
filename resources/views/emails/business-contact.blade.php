@component('mail::message')
#{{ $sender->full_name }} te envía el siguiente mensaje en relación a tu publicación "{{ $post->title }}"

{{ $contactMessage }}

@component('mail::button', ['url' => 'mailto:' . $sender->email])
Responder
@endcomponent

{{ config('app.name') }}
@endcomponent

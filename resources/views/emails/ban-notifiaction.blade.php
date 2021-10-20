@component('mail::message')
#Su usuario ha sido bloqueado

{{ $info }}

{{ config('app.name') }}
@endcomponent

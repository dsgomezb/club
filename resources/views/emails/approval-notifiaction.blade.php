@component('mail::message')
#Bienvenido a **{{ config('app.name') }}**

Su usario se registro de manera exitosa.

Por favor realice el pago de la membresía para comenzar a formar parte de la comunidad de  **{{ config('app.name') }}**.

@component('mail::button', ['url' => $url])
Abonar membresía
@endcomponent

*Si no puede hacer click en el botón copie y pegue esta url en su navegador <a href="{{ $url }}">{{ $url }}</a>*


{{ config('app.name') }}
@endcomponent

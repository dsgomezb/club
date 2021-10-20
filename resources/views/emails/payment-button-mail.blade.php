@component('mail::message')
#Suscripción a **{{ config('app.name') }}**

Su próximo pago vence el día {{ $payment->date->day }} de {{ $payment->date->localeMonth }}

@component('mail::button', ['url' => $payment->payment_url])
Abonar membresía
@endcomponent

*Si no puede hacer click en el botón copie y pegue esta url en su navegador <a href="{{ $payment->payment_url }}">{{ $payment->payment_url }}</a>*


{{ config('app.name') }}
@endcomponent

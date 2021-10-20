@component('mail::message')
#Su pago está próximo a vencer.

Tiene tiempo para cancelarlo hasta el día {{ $payment->date->day }} de {{ $payment->date->localeMonth }}.

Una vez pasado el plazo su usuario ya no será válido ingresar en el portal **{{ config('app.name') }}**

@component('mail::button', ['url' => $payment->payment_url])
Abonar membresía
@endcomponent

*Si no puede hacer click en el botón copie y pegue esta url en su navegador <a href="{{ $payment->payment_url }}">{{ $payment->payment_url }}</a>*


{{ config('app.name') }}
@endcomponent

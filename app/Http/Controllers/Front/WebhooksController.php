<?php

namespace App\Http\Controllers\Front;

use App\Classes\MercadoPago;
use App\Http\Controllers\Controller;

class WebhooksController extends Controller
{
    public function mercadopago()
    {
        MercadoPago::webhook();
        return response('ok');
    }
}

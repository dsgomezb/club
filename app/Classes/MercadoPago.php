<?php

namespace App\Classes;

class MercadoPago extends \MP
{
    private $preference;

    public function __construct($payment)
    {
        $this->preference = $this->create($payment);
    }

    public function getId()
    {
        return $this->preference['response']['id'];
    }

    public function getInitPoint()
    {
        return (env('MP_SANDBOX')) ? $this->preference['response']['sandbox_init_point'] : $this->preference['response']['init_point'];
    }

    private function create($payment)
    {
        $mpItems = [
            [
                'id' => $payment->id,
                'title' => 'Club de Caballeros',
                'description' => 'Pago del mes de ' . $payment->date->localeMonth,
                'quantity' => 1,
                'currency_id' => 'ARS',
                'unit_price' => $payment->price * 1
            ]
        ];

        //MP: preferencia de pago
        $preferenceData = [
            'order' => [
                'type' => 'mercadopago',
                'id' => $payment->id
            ],
            'items' => $mpItems,
            'payer' => [
                'name' => $payment->user->firstname,
                'surname' => $payment->user->lastname,
                'email' => $payment->user->email
            ],
            'auto_return' => 'approved',
            'back_urls' => [
                'success' => url('payments/success'),
                'pending' => url('payments/pending'),
                'failure' => url('payments/failure')
            ],
            'external_reference' => $payment->id,
            'notification_url' => url('webhooks/mercadopago'),
            'id' => uniqid()
        ];

        return self::create_preference($preferenceData);
    }

    public static function webhook()
    {
        if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
            http_response_code(400);
            return;
        }

        if($_GET["topic"] == 'payment'){
            $payment_info = \MP::get("/collections/notifications/" . $_GET["id"]);
            $merchant_order_info = \MP::get("/merchant_orders/" . $payment_info["response"]["collection"]["merchant_order_id"]);
        } else if($_GET["topic"] == 'merchant_order'){
            $merchant_order_info = \MP::get("/merchant_orders/" . $_GET["id"]);
        }

        if ($merchant_order_info && $merchant_order_info["status"] == 200) {
            $paid_amount = 0;

            foreach ($merchant_order_info["response"]["payments"] as  $payment) {
                if ($payment['status'] == 'approved'){
                    $paid_amount += $payment['transaction_amount'];
                }   
            }

            if ($paid_amount >= $merchant_order_info["response"]["total_amount"]) {
                $id = $merchant_order_info["response"]["external_reference"];
                $payment = \App\Payment::find($id);
                $payment->payment_status_id = \App\PaymentStatus::PAID;
                $payment->save();
            }
        }
    }
}

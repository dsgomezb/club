<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use App\Payment;

class PaymentController extends AppController
{
    protected $class = Payment::class;
    protected $viewFolder = 'admin.payments';
    protected $needAuthorization = false;

    public function index($state=false)
    {
        $options = [
            'paid' => [
                'title' => 'Pagos Realizados',
                'icon' => 'credit-card',
            ],
            'pending' => [
                'title' => 'Pagos Pendientes',
                'icon' => 'calendar-alt',
            ],
            'overdue' => [
                'title' => 'Pagos Vencidos',
                'icon' => 'exclamation-triangle',
            ],
        ];

        return parent::index()->with('pageTitle', $options[$state]['title'])->with('pageIcon', $options[$state]['icon']);
    }

    protected function jsonQuery($query)
    {
    	$method = 'jsonQuery' . ucfirst(request()->route('state'));

    	return $this->$method($query);
    }

    private function jsonQueryPaid($query)
    {
    	return $query->where('payment_status_id', \App\PaymentStatus::PAID);
    }

    private function jsonQueryPending($query)
    {
    	return $query->where('payment_status_id', \App\PaymentStatus::PENDING)->where('date', '>=', date('Y-m-d'));
    }

    private function jsonQueryOverdue($query)
    {
    	return $query->where('payment_status_id', \App\PaymentStatus::PENDING)->where('date', '<', date('Y-m-d'));
    }
}

<?php

namespace App;

use App\Classes\Tabulate;
use App\Classes\ToForm;
use App\Jobs\CreatePaymentLink;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Tabulate, ToForm;

    protected $fillable = [
        'date',
        'price',
        'payment_response',
        'payment_id',
        'payment_url',
        'user_id',
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function createPaymentLink()
    {
        CreatePaymentLink::dispatch($this);

        return $this;
    }

    // Tabulate
    public function scopeTabulateQuery($query)
    {
        return $query->with('user');
    }

    private function getOrderBy()
    {
        return ['updated_at', 'desc'];
    }
}


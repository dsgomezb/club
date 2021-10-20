<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['value'];

    const PENDING = 1;
    const PAID = 2;
    const CANCELLED = 3;
    const PARTIAL = 4;
}

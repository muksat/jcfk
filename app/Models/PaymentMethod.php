<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    const CREDIT_CARD = 1;
    const CASH = 2;

    protected $table = 'payment_method';

    public $timestamps = false;

    public $primaryKey = 'payment_method_id';

    public function getPaymentMethodId()
    {
        return $this->payment_method_id;
    }

    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
}
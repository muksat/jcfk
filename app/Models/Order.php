<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;
use Rhumsaa\Uuid\Uuid;

class Order extends Model
{
    const PREFIX = 'ORDJCFK';

    protected $table = 'order';

    public $timestamps = true;

    public $primaryKey = 'order_id';

    public static function createOrderWithAmount($amount, $paymentMethod)
    {
        $order = new Order();

        $order->total             = $amount;
        $order->order_status_id   = OrderStatus::INITIAL;
        $order->payment_method_id = $paymentMethod;

        $order->save();

        return $order;
    }

    public function setOrderStatusId($orderStatusId)
    {
        $this->order_status_id = $orderStatusId;
    }

    public function getOrderUuid()
    {
        return self::PREFIX . $this->order_id;
    }
}
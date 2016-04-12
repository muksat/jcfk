<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const INITIAL = 1;
    const PENDING = 2;
    const FAILED = 3;
    const SUCCESSFUL = 4;

    protected $table = 'order_status';

    public $timestamps = false;

    public $primaryKey = 'order_status_id';
}
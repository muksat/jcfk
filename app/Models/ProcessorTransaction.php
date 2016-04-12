<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessorTransaction extends Model
{
    protected $table = 'processor_transaction';

    public $timestamps = false;

    public $primaryKey = 'order_id';
}
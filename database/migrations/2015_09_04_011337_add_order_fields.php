<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderFields extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('012', 'add_order_fields');
    }
}

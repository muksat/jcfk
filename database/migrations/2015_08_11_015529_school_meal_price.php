<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SchoolMealPrice extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('005', 'school_meal_price');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoColumns extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('004', 'add_geo_columns_to_school_and_parent');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoTablesAndColumns extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('003', 'add_geo_tables');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInitialDatabaseTables extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('001', 'add_initial_tables');
    }
}

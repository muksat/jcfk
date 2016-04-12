<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoles extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('002', 'add_roles');
    }
}

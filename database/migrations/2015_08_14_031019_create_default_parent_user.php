<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultParentUser extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('006', 'default_user_and_parent');
    }
}

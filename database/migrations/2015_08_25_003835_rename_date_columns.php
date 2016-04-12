<?php

class RenameDateColumns extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('011', 'rename_date_columns');
    }
}

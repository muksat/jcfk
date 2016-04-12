<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

abstract class RawMigration extends Migration
{
    const UP = 'up';
    const DOWN = 'down';

    public function __construct()
    {
        $this->addMigrations();
    }

    /**
     * @var array
     */
    private $migrations = [];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = $this->loadSql(self::UP);

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = $this->loadSql(self::DOWN);

        DB::connection()->getPdo()->exec($sql);
    }

    protected function addMigration($migrationId, $name)
    {
        $this->migrations[] = $migrationId . '.' . $name;
    }

    abstract protected function addMigrations();

    private function loadSql($direction)
    {
        $sql = array_map(function ($migration) use ($direction) {
            $file = sprintf('%s/../sql/%s.%s.sql', __DIR__, $migration, $direction);

            return file_get_contents($file);
        }, $this->migrations);

        return implode(' ', $sql);
    }
}

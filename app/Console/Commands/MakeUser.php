<?php

namespace Jcfk\Console\Commands;

use Illuminate\Console\Command;
use Jcfk\Models\Role;
use Jcfk\Models\User;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {

        if ($user->whereIsActive(1)->count() != 0) {
            $this->error('This command available only on a fresh install.');
            return;
        }

        $user           = new User();
        $user->email    = $this->argument('email');
        $user->password = \Hash::make($this->secret('New Password'));
        $user->role_id  = Role::ADMIN;

        $user->save();

        $this->info('User created.');
    }
}

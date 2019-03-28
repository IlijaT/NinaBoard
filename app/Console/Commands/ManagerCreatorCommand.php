<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ManagerCreatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rapidly create a new user with role of manager';

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
    public function handle()
    {
        $manager = new Role();
        $manager->name = 'manager';
        $manager->label = 'Manager of company';
        $manager->save();

        $operator = new Role();
        $operator->name = 'operator';
        $operator->label = 'Company operator';
        $operator->save();

        $deletePermison =  new Permission();
        $deletePermison->name = 'delete-project';
        $deletePermison->label = 'Permission to delete a project';
        $deletePermison->save();

        $manager->givePermissionTo($deletePermison);

        $name = $this->ask('First and last name');
        $email = $this->ask('Email');
        $password = $this->secret('Password (6 characters min.)');

        $firstUser = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'remember_token'    => str_random(10),
        ]);

        $firstUser->assignRole('manager');

        $this->info('A manager has been successfully created!');
    }
}

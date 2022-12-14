<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'firstname' => 'Osama',
            'lastname' => 'Roshdi',
            'username' => 'admin11231',
            'email' => 'admin@admin.com',
            'password' => bcrypt(123456),
        ]);

        $admin->roles()->sync([1]);

        $employee =  User::create([
            'firstname' => 'Osama',
            'lastname' => 'Roshdi',
            'username' => 'employee11231',
            'email' => 'employee@employee.com',
            'password' => bcrypt(123456),
        ]);

        $employee->roles()->sync([2]);


    }
}

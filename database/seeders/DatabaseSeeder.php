<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $data = array(
            [
                'nik' => '000',
                'name' => 'ROOT',
                'email' => 'root@example.com',
                'username' => 'root',
                'password' => 'root',
                'status' => 'active',
                'level' => 'admin',
            ],
            [
                'nik' => '123',
                'name' => 'User',
                'email' => 'user@example.com',
                'username' => 'user',
                'password' => 'user',
                'status' => 'active',
                'level' => 'user',
            ]
        );
        foreach($data as $user){
            User::create($user);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => Role::ADMIN,
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::COUNTER,
            'counter_id' => '01KFM0C8X2PH0G1Q9NDQ3MDG51',
            'username' => 'counter',
            'name' => 'Counter Member',
            'email' => 'counter@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::ASSISTANT,
            'counter_id' => '01KFM0C8X2PH0G1Q9NDQ3MDG51',
            'username' => 'asisten',
            'name' => 'Asisten Member',
            'email' => 'asisten@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::DISPLAY,
            'username' => 'display',
            'name' => 'Display Member',
            'email' => 'display@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::KIOSK,
            'username' => 'kiosk',
            'name' => 'Kiosk Member',
            'email' => 'kiosk@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::factory()->count(50)->create();
    }
}

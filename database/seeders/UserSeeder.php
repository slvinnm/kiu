<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::COUNTER,
            'counter_id' => '01KFQ29GGX80S41P7WDP91QNQA',
            'username' => 'loket1',
            'name' => 'Loket1',
            'email' => 'loket1@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::SERVICE,
            'service_id' => '01KFM08MA4VRFXZGZTSTFN7787',
            'username' => 'service1',
            'name' => 'Service1',
            'email' => 'service1@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);

        User::create([
            'role_id' => Role::KIOSK,
            'username' => 'kiosk',
            'name' => 'Kiosk',
            'email' => 'kiosk@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => uniqid(),
        ]);
    }
}

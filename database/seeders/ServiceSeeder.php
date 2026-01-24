<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'id' => '01KFM08MA4VRFXZGZTSTFN7787',
            'name' => 'Ruang 1',
            'code' => 'Ruang 1',
            'opening_time' => '08:00:00',
            'closing_time' => '17:00:00',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('counters')->insert([
            'id' => '01KFQ29GGX80S41P7WDP91QNQA',
            'name' => 'Loket 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regulations')->insert([
            ['name' => 'work duration', 'points' => 20],
            ['name' => 'absent days', 'points' => 20],
            ['name' => 'sick leave', 'points' => 20],
            ['name' => 'evaluation', 'points' => 20],
            ['name' => 'late days', 'points' => 20]
        ]);
    }
}

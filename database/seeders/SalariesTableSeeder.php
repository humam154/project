<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salaries')->insert([
            ['salary' => 2500000, 'grade_id' => 1],
            ['salary' => 1750000, 'grade_id' => 1],
            ['salary' => 1500000, 'grade_id' => 1],
            ['salary' => 500000, 'grade_id' => 4],
        ]);
    }
}

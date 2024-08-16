<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncentiveSharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incentive_shares')->insert([
            ['name' => 'manager', 'amount_of_share' => 150,],
            ['name' => 'Employee', 'amount_of_share' => 100,],
            ['name' => 'most employee of the month', 'amount_of_share' => 125,],
        ]);
    }
}

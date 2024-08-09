<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('complains')->insert([
            'complain' => 'I do not like this company at all.',
            'date' => Carbon::now()->format('Y-m-d'),
            'employee_id' => 4,
        ]);
    }
}

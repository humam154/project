<?php

namespace Database\Seeders;

use App\Models\SalaryGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryGradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salary_grades')->insert([
            ['letter' => 'A', 'description' => 'Manager', 'basic_salary' => 1500000],
            ['letter' => 'B', 'description' => 'Deputy', 'basic_salary' => 1000000],
            ['letter' => 'C', 'description' => 'Supervisor', 'basic_salary' => 750000],
            ['letter' => 'D', 'description' => 'Employee', 'basic_salary' => 500000],
        ]);
    }
}

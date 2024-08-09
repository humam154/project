<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert([
            'text' => 'At [Your Company Name], we believe in fostering a work environment that is both fair and motivating for all our employees. We understand that our team\'s dedication and hard work are the driving forces behind our success. That is why we strive to ensure that every employee feels valued and appreciated.We are committed to promoting fairness in everything we do. One of the ways we demonstrate this is through our incentive program, which rewards those who go above and beyond in their roles. Our Employee of the Month program is a testament to this commitment, offering not just recognition but also tangible rewards. The employee who earns this title receives more incentive money than their coworkers, reflecting our belief that outstanding performance deserves exceptional rewards.At [Your Company Name], we encourage our employees to reach their full potential. We provide opportunities for growth and ensure that every team member has the tools and support they need to succeed. We believe that when our employees thrive, so does our company.Join us at [Your Company Name], where your efforts are recognized, your hard work is rewarded, and your success is our priority.',
            'employee_id' => 1
        ]);
    }
}





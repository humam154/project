<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            SalaryGradesTableSeeder::class
        ]);

        $this->call([
            SalariesTableSeeder::class
        ]);

        $this->call([
            RolesPermissionSeeder::class
        ]);

        $this->call([
            IncentiveSharesTableSeeder::class
        ]);

        $this->call([
            RegulationsTableSeeder::class
        ]);

        $this->call([
            AboutUsTableSeeder::class
        ]);

        $this->call([
            ComplainsTableSeeder::class
        ]);
    }
}

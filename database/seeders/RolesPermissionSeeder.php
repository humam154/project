<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hrRole = Role::create(['name' => 'HR']);
        $gmRole = Role::create(['name' => 'GM']);
        $fmRole = Role::create(['name' => 'FM']);

        $permissions = [
            'employees.create', 'employees.update', 'employees.delete', 'employees.get',
            'aboutUs.edit',
            'complains.get',
            'files.download',
            'salaries.increment',
            'grades.create', 'grades.update', 'grades.delete', 'grades.get',
            'incentive.calculate'
        ];

        foreach ($permissions as $permissionName){
            Permission::findOrCreate($permissionName);
        }

        $hrRole->givePermissionTo([
            'employees.create', 'employees.update', 'employees.delete', 'employees.get',
            'aboutUs.edit',
            'complains.get',
            'files.download',
            ]);

        $fmRole->givePermissionTo([
            'salaries.increment',
            'grades.create', 'grades.update', 'grades.delete', 'grades.get',
        ]);

        $gmRole->syncPermissions($permissions);


        $hrUser = User::factory()->create([
            'name' => 'HR manager',
            'email' => 'hr@example.com',
            'password' => bcrypt('password')
        ]);

        $hrUser->assignRole($hrRole);
        $permissions = $hrRole->permissions()->pluck('name')->toArray();
        $hrUser->givePermissionTo($permissions);


        $fmUser = User::factory()->create([
            'name' => 'FM manager',
            'email' => 'fm@example.com',
            'password' => bcrypt('password')
        ]);

        $fmUser->assignRole($fmRole);
        $permissions = $fmRole->permissions()->pluck('name')->toArray();
        $fmUser->givePermissionTo($permissions);

        $gmUser = User::factory()->create([
            'name' => 'GM manager',
            'email' => 'gm@example.com',
            'password' => bcrypt('password')
        ]);

        $gmUser->assignRole($gmRole);
        $permissions = $gmRole->permissions()->pluck('name')->toArray();
        $gmUser->givePermissionTo($permissions);
   }
}

<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            'incentive.calculate',
            'regulations.create', 'regulations.update', 'regulations.delete', 'regulations.get',
        ];

        foreach ($permissions as $permissionName){
            Permission::findOrCreate($permissionName, 'web');
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

        $gmUser = User::factory()->create([
            'name' => 'GM manager',
            'email' => 'gm@example.com',
            'password' => bcrypt('password')
        ]);

        $gmUser->assignRole($gmRole);
        $permissions = $gmRole->permissions()->pluck('name')->toArray();
        $gmUser->givePermissionTo($permissions);


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




        $gmEmployee = Employee::create([
            'first_name' => 'general',
            'last_name' => 'manager',
            'email' => $gmUser->email,
            'phone' => '0949623988',
            'salary_id' => 1,
            'user_id' => $gmUser->id
        ]);

        $hrEmployee = Employee::create([
            'first_name' => 'HR',
            'last_name' => 'manager',
            'email' => $hrUser->email,
            'phone' => '0930610494',
            'salary_id' => 2,
            'user_id' => $hrUser->id
        ]);

        $fmEmployee = Employee::create([
            'first_name' => 'FM',
            'last_name' => 'manager',
            'email' => $fmUser->email,
            'phone' => '0949243710',
            'salary_id' => 3,
            'user_id' => $fmUser->id
        ]);


        $user = User::factory()->create([
            'name' => 'humam allawi',
            'email' => 'humam@allawi.com',
            'password' => Hash::make('password'),
        ]);

        $userEmployee = Employee::create([
            'first_name' => 'humam',
            'last_name' => 'allawi',
            'email' => $user->email,
            'phone' => '0969876543',
            'salary_id' => 4,
            'user_id' => $user->id
        ]);
   }
}

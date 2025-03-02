<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleHR = Role::create(['name' => 'HR']);
        $roleManager = Role::create(['name' => 'Manager']);
        $roleEmployee = Role::create(['name' => 'Employee']);

        $permissionManageUsers = Permission::create(['name' => 'manage users']);
        $permissionManageDepartments = Permission::create(['name' => 'Manage Departments']);
        $permissionsManageContracts = Permission::create(['name' => 'Manage Contracts']);
        $permissionManageFormations = Permission::create(['name' => 'Manage Formations']);
        $permissionManageEmployees = Permission::create(['name' => 'Manage Employees']);
        $permissionManageJobs = Permission::create(['name' => 'Manage Jobs']);

        $roleAdmin->givePermissionTo($permissionManageUsers);
        $roleAdmin->givePermissionTo($permissionManageDepartments);
        $roleAdmin->givePermissionTo($permissionsManageContracts);
        $roleAdmin->givePermissionTo($permissionManageFormations);
        $roleAdmin->givePermissionTo($permissionManageFormations);
        $roleAdmin->givePermissionTo($permissionManageJobs);

        $user = User::find(1);
        $user->assignRole($roleAdmin);
    }
}

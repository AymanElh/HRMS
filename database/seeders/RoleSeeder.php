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
        $permissionMakeVacationRequest = Permission::create(['name' => 'make vacation request']);
        $permissionApproveVacationRequest = Permission::create(['name' => 'approve vacation request']);
        $permissionRecoverDayRequest = Permission::create(['name' => 'make recover day request']);
        $permissionApproveRecoverDays = Permission::create(['name' => 'approve recover days']);
        $permissionSeeProfile = Permission::create(['name' => 'see profile']);



        $roleAdmin->givePermissionTo($permissionManageUsers);
        $roleAdmin->givePermissionTo($permissionManageDepartments);
        $roleAdmin->givePermissionTo($permissionsManageContracts);
        $roleAdmin->givePermissionTo($permissionManageFormations);
        $roleAdmin->givePermissionTo($permissionManageFormations);
        $roleAdmin->givePermissionTo($permissionManageJobs);
        $roleAdmin->givePermissionTo($permissionManageEmployees);
        $roleHR = Role::findByName('HR');
        $roleManager = Role::findByName('Manager');
        $roleEmployee = Role::findByName('Employee');
        $roleHR->givePermissionTo([
            $permissionManageEmployees,
            $permissionsManageContracts,
            $permissionManageFormations,
            $permissionApproveVacationRequest,
            $permissionApproveRecoverDays,
            $permissionMakeVacationRequest,
            $permissionRecoverDayRequest,
            $permissionSeeProfile
        ]);

        $roleManager->givePermissionTo([
            $permissionApproveVacationRequest,
            $permissionMakeVacationRequest,
            $permissionRecoverDayRequest,
            $permissionSeeProfile
        ]);

        $roleEmployee->givePermissionTo([
            $permissionMakeVacationRequest,
            $permissionRecoverDayRequest,
            $permissionSeeProfile
        ]);
        

        $user = User::find(1);
        $user->assignRole($roleAdmin);
    }
}

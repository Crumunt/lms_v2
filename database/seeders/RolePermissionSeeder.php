<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create courses',
            'edit courses',
            'delete courses',
            'publish courses',
            'view courses',
            'enroll in courses',     // for students
            'manage enrollments',    // for instructors/admins
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $student = Role::firstOrCreate(['name' => 'student']);

        $admin->givePermissionTo(Permission::all());

        $instructor->givePermissionTo([
            'create courses',
            'edit courses',
            'view courses',
            'publish courses',
            'manage enrollments'
        ]);

        $student->givePermissionTo([
            'view courses',
            'enroll in courses',
        ]);
    }
}

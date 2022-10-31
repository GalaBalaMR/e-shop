<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating roles and permissions with Spatie pacpage
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'delete-categories']);

        Permission::create(['name' => 'create-subcategories']);
        Permission::create(['name' => 'edit-subcategories']);
        Permission::create(['name' => 'delete-subcategories']);

        Permission::create(['name' => 'create-items']);
        Permission::create(['name' => 'edit-items']);
        Permission::create(['name' => 'delete-items']);

        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);
        $serviceRole = Role::create(['name' => 'Service']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-categories',
            'edit-categories',
            'delete-categories',
            'create-subcategories',
            'edit-subcategories',
            'delete-subcategories',
            'create-items',
            'edit-items',
            'delete-items'
            
        ]);

        $managerRole->givePermissionTo([
            'create-categories',
            'edit-categories',
            'delete-categories',
            'create-subcategories',
            'edit-subcategories',
            'delete-subcategories',
            'create-items',
            'edit-items',
            'delete-items' 
        ]);

        $serviceRole->givePermissionTo([
            'create-categories',
            'edit-categories',
            'delete-categories',
            'create-subcategories',
            'edit-subcategories',
            'delete-subcategories',
            'create-items',
            'edit-items',
            'delete-items'
        ]);

        // Give roles to users, which made in DatabaseSeeder
        $user = User::firstWhere('name', 'Admin');
        $user->assignRole('Admin');

        $manager = User::firstWhere('name', 'Manager');
        $manager->assignRole('Manager');

        $waiter = User::firstWhere('name', 'Service');
        $waiter->assignRole('Service');
    }
}

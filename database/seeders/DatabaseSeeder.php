<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Category::factory(7)->create();
        
        // Create subcategory with sequence for category_id
        SubCategory::factory(7)
        ->state(new Sequence(
            ['category_id' => 1],
            ['category_id' => 2],
        ))->create();

        // Create items with sequence for category_id and sub_category_id
        Item::factory(25)
        ->state(new Sequence(
            ['category_id' => 1],
            ['category_id' => 3],
            ['sub_category_id' => 2],
        ))
        ->create();

        // Create basic users(Admin, Manager, Service) and then give them roles in RolePermissionSeeder
        User::create([
            'name' => 'Admin',
            'email' => 'admin@e-shop.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Manager',
            'email' => 'manager@e-shop.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Service',
            'email' => 'service@e-shop.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::factory(10)->create();

        Address::factory(5)->create();



        $this->call([
            RolePermissionSeeder::class
        ]);


    }
}

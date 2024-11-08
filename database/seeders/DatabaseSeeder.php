<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Kedai',
            'email' => 'kedai@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // $this->call(ProductSeeder::class);
        $this->call(RoleSeeder::class);
    }
}

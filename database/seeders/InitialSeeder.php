<?php

namespace Database\Seeders;


use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create an admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', // Add 'role' column to distinguish roles
        ]);


        // Create a customer
        $customer1 = User::create([
            'name' => 'Customer 1',
            'email' => 'customer1@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer', // Add 'role' column to distinguish roles

        ]);


        // Create a customer
        $customer2 = User::create([
            'name' => 'Customer 2',
            'email' => 'customer2@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer', // Add 'role' column to distinguish roles

        ]);



        $category1 = Category::create([
            'name' => 'Tech',

        ]);

        $category2 = Category::create([
            'name' => 'Tools',

        ]);



        // Create products
        Product::create([
            'name' => 'Labtop',
            'stock' => 10,
            'price' => 250,
            'category_id' => $category1->id,
        ]);

        Product::create([
            'name' => 'paper',
            'stock' => 20,
            'price' => 500,
            'category_id' => $category2->id,
        ]);


    }
}

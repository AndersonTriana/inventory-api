<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create categories
        $electronics = Category::create([
            'name' => 'Electrónicos',
            'description' => 'Productos electrónicos y tecnológicos',
        ]);

        $clothing = Category::create([
            'name' => 'Ropa',
            'description' => 'Ropa y accesorios',
        ]);

        $books = Category::create([
            'name' => 'Libros',
            'description' => 'Libros y material educativo',
        ]);

        // Create products
        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Smartphone Samsung Galaxy',
            'description' => 'Smartphone con pantalla de 6.5 pulgadas',
            'price' => 599.99,
            'stock' => 25,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'Laptop HP Pavilion',
            'description' => 'Laptop para uso profesional',
            'price' => 899.99,
            'stock' => 15,
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Camiseta Casual',
            'description' => 'Camiseta de algodón 100%',
            'price' => 19.99,
            'stock' => 50,
        ]);

        Product::create([
            'category_id' => $books->id,
            'name' => 'Laravel: Up and Running',
            'description' => 'Guía completa para desarrollar con Laravel',
            'price' => 49.99,
            'stock' => 30,
        ]);
    }
}

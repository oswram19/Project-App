<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Electrónica',
            'description' => 'Productos electrónicos y tecnología',
        ]);

        Category::create([
            'name' => 'Ropa',
            'description' => 'Ropa y accesorios',
        ]);

        Category::create([
            'name' => 'Hogar',
            'description' => 'Artículos para el hogar',
        ]);

        Category::create([
            'name' => 'Deportes',
            'description' => 'Artículos deportivos y fitness',
        ]);

        Category::create([
            'name' => 'Libros',
            'description' => 'Libros y material de lectura',
        ]);
    }
}

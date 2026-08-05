<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronica',
            'Computación',
            'Papelería',
            'Ferretería',
            'Limpieza',
            'Oficina',
            'Alimentos',
            'Bebidas',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => null,
                'is_active' => true,
            ]);
        }
    }
}

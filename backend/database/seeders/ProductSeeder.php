<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id')->all();

        if (empty($categoryIds)) {
            $categoryIds = [Category::factory()->create()->id];
        }

        Product::factory(100)->create([
            'category_id' => fn () => $categoryIds[array_rand($categoryIds)],
        ]);
    }
}

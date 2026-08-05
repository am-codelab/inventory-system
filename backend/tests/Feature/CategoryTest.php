<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_is_generated_from_name(): void
    {
        $category = Category::create([
            'name' => 'Electrónica',
            'description' => null,
            'is_active' => true,
        ]);

        $this->assertSame('electronica', $category->slug);
    }
}

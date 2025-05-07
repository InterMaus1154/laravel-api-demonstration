<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Home Appliances',
            'Books',
            'Toys & Games',
            'Fashion',
            'Beauty & Personal Care',
            'Automotive',
            'Sports & Outdoors',
            'Health & Wellness',
            'Grocery',
            'Pet Supplies',
            'Office Supplies',
            'Tools & Home Improvement',
            'Garden & Outdoor',
            'Baby Products',
            'Music & Instruments',
            'Furniture',
            'Jewelry',
            'Footwear',
            'Mobile Accessories',
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category
            ]);
        }

        User::factory()->create([
            'username' => 'johndoe',
            'password' => 'password'
        ]);

        User::factory()
            ->has(Product::factory()->count(15))
            ->count(10)->create();
    }
}

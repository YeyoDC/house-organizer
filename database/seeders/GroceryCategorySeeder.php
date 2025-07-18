<?php

namespace Database\Seeders;

use App\Models\GroceryCategory;
use Illuminate\Database\Seeder;

class GroceryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fruits', 'icon' => '🍎'],
            ['name' => 'Vegetables', 'icon' => '🥦'],
            ['name' => 'Dairy', 'icon' => '🧀'],
            ['name' => 'Bakery', 'icon' => '🥖'],
            ['name' => 'Meat', 'icon' => '🥩'],
            ['name' => 'Seafood', 'icon' => '🦐'],
            ['name' => 'Frozen Foods', 'icon' => '❄️'],
            ['name' => 'Snacks', 'icon' => '🍿'],
            ['name' => 'Beverages', 'icon' => '🥤'],
            ['name' => 'Condiments', 'icon' => '🧂'],
            ['name' => 'Spices & Herbs', 'icon' => '🌿'],
            ['name' => 'Pantry Staples', 'icon' => '📦'],
            ['name' => 'Canned Goods', 'icon' => '🥫'],
            ['name' => 'Grains & Pasta', 'icon' => '🍝'],
            ['name' => 'Baking Supplies', 'icon' => '🧁'],
            ['name' => 'Breakfast & Cereal', 'icon' => '🥣'],
            ['name' => 'Personal Care', 'icon' => '🪒'],
            ['name' => 'Household Supplies', 'icon' => '🧻'],
            ['name' => 'Cleaning Products', 'icon' => '🧼'],
            ['name' => 'Pet Supplies', 'icon' => '🐾'],
            ['name' => 'Baby Products', 'icon' => '🍼'],
            ['name' => 'Health & Wellness', 'icon' => '💊'],
            ['name' => 'Coffee & Tea', 'icon' => '☕'],
            ['name' => 'Sauces', 'icon' => '🥫'],
            ['name' => 'Nuts & Seeds', 'icon' => '🥜'],
            ['name' => 'Oils & Vinegars', 'icon' => '🫒'],
            ['name' => 'Prepared Meals', 'icon' => '🍱'],
            ['name' => 'Deli', 'icon' => '🥪'],
            ['name' => 'Toiletries', 'icon' => '🪥'],
            ['name' => 'Paper Goods', 'icon' => '📄'],
            ['name' => 'International Foods', 'icon' => '🌍'],
            ['name' => 'Gluten-Free', 'icon' => '🚫🌾'],
            ['name' => 'Organic', 'icon' => '🍃'],
            ['name' => 'Vegan', 'icon' => '🌱'],
            ['name' => 'Low-Carb/Keto', 'icon' => '🥓'],
            ['name' => 'Dips & Spreads', 'icon' => '🥫'],
            ['name' => 'Cheese', 'icon' => '🧀'],
            ['name' => 'Eggs', 'icon' => '🥚'],
            ['name' => 'Juices', 'icon' => '🧃'],
            ['name' => 'Energy Drinks', 'icon' => '⚡'],
            ['name' => 'Water', 'icon' => '💧'],
            ['name' => 'Alcohol', 'icon' => '🍷'],

            // Optional extra categories
            ['name' => 'Seasonal Items', 'icon' => '🎄'],
            ['name' => 'Supplements', 'icon' => '🧬'],
            ['name' => 'Party Supplies', 'icon' => '🎉'],
            ['name' => 'Ice Cream & Desserts', 'icon' => '🍨'],
            ['name' => 'Cooking Essentials', 'icon' => '🍳'],
            ['name' => 'Specialty Foods', 'icon' => '🥟'],
        ];

        foreach ($categories as $category) {
            GroceryCategory::create($category);
        }
    }
}


<?php

namespace Database\Seeders;

use App\Models\GroceryItem;
use App\Models\GroceryCategory;
use Illuminate\Database\Seeder;

class GroceryItemSeeder extends Seeder
{
    public function run(): void
    {
        $itemsByCategory = [
            'Fruits' => [
                'Bananas', 'Apples', 'Oranges', 'Strawberries', 'Blueberries',
            ],
            'Vegetables' => [
                'Spinach', 'Broccoli', 'Carrots', 'Tomatoes', 'Lettuce',
            ],
            'Dairy' => [
                'Milk', 'Cheddar Cheese', 'Yogurt', 'Butter', 'Cream', 'Mozzarella', 'Greek Yogurt', 'Vegan Cheese',
            ],
            'Bakery' => [
                'White Bread', 'Whole Wheat Bread', 'Bagels', 'Croissants', 'Tortillas', 'Pita Bread', 'Gluten-Free Bread',
            ],
            'Meat' => [
                'Ground Beef', 'Chicken Breasts', 'Pork Chops', 'Rotisserie Chicken',
            ],
            'Seafood' => [
                'Salmon Fillet', 'Shrimp',
            ],
            'Frozen Foods' => [
                'Frozen Pizza', 'Frozen Vegetables', 'Ice Cream',
            ],
            'Snacks' => [
                'Potato Chips', 'Granola Bars', 'Crackers', 'Cookies', 'Trail Mix', 'Nachos',
            ],
            'Beverages' => [
                'Coke', 'Pepsi', 'Energy Drink', 'Bottled Water', 'Sparkling Water', 'Beer', 'Wine',
            ],
            'Juices' => [
                'Orange Juice', 'Apple Juice',
            ],
            'Coffee & Tea' => [
                'Coffee Beans', 'Instant Coffee', 'Green Tea',
            ],
            'Oils & Vinegars' => [
                'Olive Oil', 'Vegetable Oil', 'Vinegar',
            ],
            'Condiments' => [
                'Ketchup', 'Mayonnaise', 'Peanut Butter', 'Jam',
            ],
            'Spices & Herbs' => [
                'Salt', 'Pepper', 'Paprika', 'Garlic Powder', 'Onion Powder', 'Basil', 'Oregano',
            ],
            'Canned Goods' => [
                'Canned Beans', 'Canned Tomatoes', 'Tuna Can',
            ],
            'Grains & Pasta' => [
                'Spaghetti', 'Macaroni', 'Rice', 'Couscous', 'Quinoa',
            ],
            'Baking Supplies' => [
                'Flour', 'Sugar', 'Baking Powder',
            ],
            'Breakfast & Cereal' => [
                'Oatmeal', 'Cereal', 'Eggs',
            ],
            'Personal Care' => [
                'Toothpaste', 'Shampoo', 'Body Wash',
            ],
            'Household Supplies' => [
                'Toilet Paper', 'Laundry Detergent', 'Dish Soap',
            ],
            'Pet Supplies' => [
                'Dog Food', 'Cat Food',
            ],
            'Baby Products' => [
                'Baby Wipes', 'Diapers',
            ],
            'Health & Wellness' => [
                'Multivitamins', 'Pain Reliever',
            ],
            'Nuts & Seeds' => [
                'Almonds', 'Peanuts',
            ],
            'Prepared Meals' => [
                'Ready Meals',
            ],
            'Deli' => [
                'Sliced Deli Turkey', 'Cheese Slices',
            ],
            'Dips & Spreads' => [
                'Guacamole', 'Hummus', 'Salsa',
            ],
            'Vegan' => [
                'Tofu', 'Tempeh',
            ],
        ];

        foreach ($itemsByCategory as $categoryName => $products) {
            $category = GroceryCategory::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($products as $product) {
                GroceryItem::create([
                    'name' => $product,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChoreActionSeeder extends Seeder
{
    public function run(): void
    {
        $actions = [
            // Floors & surfaces
            'Sweep',
            'Mop',
            'Vacuum',
            'Dust',
            'Polish Furniture',
            'Wipe Counters',
            'Wipe Windows',
            'Clean Mirrors',
            'Disinfect Surfaces',

            // Bathroom-specific
            'Scrub Toilet',
            'Scrub Shower',
            'Clean Bathtub',
            'Clean Sink',
            'Replace Towels',
            'Refill Toilet Paper',
            'Empty Bathroom Trash',

            // Kitchen-specific
            'Wash Dishes',
            'Unload Dishwasher',
            'Clean Stovetop',
            'Clean Oven',
            'Wipe Fridge',
            'Take Out Trash',
            'Empty Recycling',
            'Restock Pantry',

            // Bedroom-specific
            'Make Bed',
            'Change Sheets',
            'Fold Clothes',
            'Organize Closet',
            'Put Away Laundry',

            // General organization
            'Declutter Room',
            'Organize Drawers',
            'Disinfect Doorknobs',

            // Plants & pets
            'Water Plants',
            'Feed Pets',
            'Clean Litter Box',
            'Brush Pet',

            // Outdoor
            'Mow Lawn',
            'Rake Leaves',
            'Shovel Snow',
            'Sweep Patio',
            'Clean Grill',
            'Trim Hedges',
            'Weed Garden',

            // Other
            'Wash Windows',
            'Clean Walls',
            'Clean Baseboards',
            'Vacuum Sofa',
            'Wash Laundry',
            'Dry Laundry',
            'Take Out Compost',
            'Refill Soap Dispensers',
            'Replace Lightbulbs',
            'Clean Ceiling Fans',
        ];

        foreach ($actions as $action) {
            DB::table('chore_actions')->insert([
                'name' => $action,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}


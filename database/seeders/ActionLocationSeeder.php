<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ChoreAction;
use App\Models\ChoreLocation;

class ActionLocationSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping: action name => valid locations
        $map = [

            // Floors & surfaces
            'Sweep' => ['Kitchen', 'Bathroom', 'Living Room', 'Bedroom', 'Hallway', 'Garage', 'Dining Room'],
            'Mop' => ['Kitchen', 'Bathroom', 'Living Room', 'Hallway', 'Dining Room'],
            'Vacuum' => ['Living Room', 'Bedroom', 'Hallway'],
            'Dust' => ['Living Room', 'Bedroom', 'Dining Room', 'Office'],
            'Polish Furniture' => ['Living Room', 'Bedroom', 'Dining Room'],
            'Wipe Counters' => ['Kitchen', 'Bathroom'],
            'Wipe Windows' => ['Living Room', 'Bedroom', 'Bathroom'],
            'Clean Mirrors' => ['Bathroom', 'Bedroom'],
            'Disinfect Surfaces' => ['Kitchen', 'Bathroom', 'Living Room'],

            // Bathroom-specific
            'Scrub Toilet' => ['Bathroom'],
            'Scrub Shower' => ['Bathroom'],
            'Clean Bathtub' => ['Bathroom'],
            'Clean Sink' => ['Bathroom', 'Kitchen'],
            'Replace Towels' => ['Bathroom'],
            'Refill Toilet Paper' => ['Bathroom'],
            'Empty Bathroom Trash' => ['Bathroom'],

            // Kitchen-specific
            'Wash Dishes' => ['Kitchen'],
            'Unload Dishwasher' => ['Kitchen'],
            'Clean Stovetop' => ['Kitchen'],
            'Clean Oven' => ['Kitchen'],
            'Wipe Fridge' => ['Kitchen'],
            'Take Out Trash' => ['Kitchen', 'Bathroom', 'Garage'],
            'Empty Recycling' => ['Kitchen', 'Garage'],
            'Restock Pantry' => ['Kitchen'],

            // Bedroom-specific
            'Make Bed' => ['Bedroom'],
            'Change Sheets' => ['Bedroom'],
            'Fold Clothes' => ['Bedroom', 'Laundry Room'],
            'Organize Closet' => ['Bedroom', 'Closet'],
            'Put Away Laundry' => ['Bedroom', 'Laundry Room'],

            // General organization
            'Declutter Room' => ['Living Room', 'Bedroom', 'Office'],
            'Organize Drawers' => ['Kitchen', 'Bedroom', 'Bathroom'],
            'Disinfect Doorknobs' => ['Hallway', 'Entryway', 'Living Room', 'Bedroom'],

            // Plants & pets
            'Water Plants' => ['Living Room', 'Porch', 'Garden'],
            'Feed Pets' => ['Kitchen', 'Laundry Room'],
            'Clean Litter Box' => ['Bathroom', 'Laundry Room'],
            'Brush Pet' => ['Living Room', 'Yard'],

            // Outdoor
            'Mow Lawn' => ['Front Lawn', 'Backyard', 'Yard'],
            'Rake Leaves' => ['Yard', 'Front Lawn', 'Backyard'],
            'Shovel Snow' => ['Driveway', 'Front Lawn'],
            'Sweep Patio' => ['Patio', 'Porch'],
            'Clean Grill' => ['Backyard', 'Patio'],
            'Trim Hedges' => ['Front Lawn', 'Backyard'],
            'Weed Garden' => ['Garden'],

            // Other
            'Wash Windows' => ['Living Room', 'Bedroom', 'Dining Room'],
            'Clean Walls' => ['Living Room', 'Bedroom', 'Hallway'],
            'Clean Baseboards' => ['Living Room', 'Bedroom', 'Hallway'],
            'Vacuum Sofa' => ['Living Room'],
            'Wash Laundry' => ['Laundry Room'],
            'Dry Laundry' => ['Laundry Room'],
            'Take Out Compost' => ['Kitchen', 'Backyard'],
            'Refill Soap Dispensers' => ['Kitchen', 'Bathroom'],
            'Replace Lightbulbs' => ['All'],
            'Clean Ceiling Fans' => ['Living Room', 'Bedroom', 'Dining Room'],
        ];

        foreach ($map as $actionName => $locationNames) {
            $action = ChoreAction::where('name', $actionName)->first();
            if (!$action) continue;

            // Special case: "All" applies to every location
            if ($locationNames === ['All']) {
                $allLocations = ChoreLocation::all();
                foreach ($allLocations as $location) {
                    DB::table('action_location')->insertOrIgnore([
                        'action_id' => $action->id,
                        'location_id' => $location->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                foreach ($locationNames as $locationName) {
                    $location = ChoreLocation::where('name', $locationName)->first();
                    if ($location) {
                        DB::table('action_location')->insertOrIgnore([
                            'action_id' => $action->id,
                            'location_id' => $location->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}

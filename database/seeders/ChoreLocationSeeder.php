<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChoreLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Indoors
            'Kitchen',
            'Bathroom',
            'Living Room',
            'Bedroom',
            'Laundry Room',
            'Hallway',
            'Garage',
            'Dining Room',
            'Office',
            'Pantry',
            'Staircase',
            'Entryway',
            'Basement',
            'Attic',
            'Closet',
            'Mudroom',

            // Outdoors
            'Yard',
            'Backyard',
            'Front Lawn',
            'Porch',
            'Patio',
            'Balcony',
            'Driveway',
            'Garden',
            'Shed',
        ];

        foreach ($locations as $location) {
            DB::table('chore_locations')->insert([
                'name' => $location,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}


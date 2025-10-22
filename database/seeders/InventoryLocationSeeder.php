<?php

namespace Database\Seeders;

use App\Models\Inventory\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InventoryLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Main Kitchen Pantry',
                'location_type' => 'pantry',
                'area' => 'Kitchen',
                'description' => 'Primary dry storage for grains, canned goods, and ambient ingredients.',
            ],
            [
                'name' => 'Cold Storage Freezer',
                'location_type' => 'cold_storage',
                'area' => 'Kitchen',
                'description' => 'Frozen goods including meats, seafood, and desserts.',
            ],
            [
                'name' => 'Beverage Cellar',
                'location_type' => 'cellar',
                'area' => 'Food & Beverage',
                'description' => 'Wine, spirits, mixers, and bar consumables.',
            ],
            [
                'name' => 'Housekeeping Amenities Closet',
                'location_type' => 'housekeeping',
                'area' => 'Guest Services',
                'description' => 'Guest toiletries, towels, linens, and in-room amenities.',
            ],
            [
                'name' => 'Laundry Room Supply',
                'location_type' => 'laundry',
                'area' => 'Back of House',
                'description' => 'Laundry detergents, fabric softeners, and spare linens.',
            ],
            [
                'name' => 'Maintenance Workshop',
                'location_type' => 'maintenance',
                'area' => 'Engineering',
                'description' => 'Tools, hardware, bulbs, HVAC filters, and repair parts.',
            ],
            [
                'name' => 'Front Office Supply Closet',
                'location_type' => 'office',
                'area' => 'Front Office',
                'description' => 'Stationery, keycards, printers, and desk supplies.',
            ],
            [
                'name' => 'Spa & Wellness Storage',
                'location_type' => 'spa',
                'area' => 'Spa & Wellness',
                'description' => 'Essential oils, massage linens, and spa consumables.',
            ],
            [
                'name' => 'Pool & Recreation Equipment Room',
                'location_type' => 'recreation',
                'area' => 'Recreation',
                'description' => 'Pool chemicals, towels, and recreational gear.',
            ],
            [
                'name' => 'Central Stores Warehouse',
                'location_type' => 'general_storage',
                'area' => 'Back of House',
                'description' => 'Bulk storage for overflow and general-purpose supplies.',
            ],
            [
                'name' => 'Emergency & Safety Storage',
                'location_type' => 'safety',
                'area' => 'Security',
                'description' => 'Fire extinguishers, first aid kits, and emergency supplies.',
            ],
        ];

        foreach ($locations as $location) {
            $slug = Str::slug($location['name']);
            Location::query()->updateOrCreate(
                ['slug' => $slug],
                array_merge($location, ['slug' => $slug])
            );
        }
    }
}

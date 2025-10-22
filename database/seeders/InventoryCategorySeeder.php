<?php

namespace Database\Seeders;

use App\Models\Inventory\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InventoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Food Ingredients', 'category_type' => 'consumable', 'description' => 'Dry goods, produce, meats, and culinary staples.'],
            ['name' => 'Beverages & Bar Supplies', 'category_type' => 'consumable', 'description' => 'Wine, spirits, mixers, and non-alcoholic beverages.'],
            ['name' => 'Guest Room Amenities', 'category_type' => 'consumable', 'description' => 'In-room toiletries, towels, pillows, and minibars.'],
            ['name' => 'Housekeeping Supplies', 'category_type' => 'consumable', 'description' => 'Cleaning chemicals, gloves, mops, vacuums, and carts.'],
            ['name' => 'Laundry Supplies', 'category_type' => 'consumable', 'description' => 'Detergents, softeners, stain removers, and laundry bags.'],
            ['name' => 'Maintenance & Engineering', 'category_type' => 'asset', 'description' => 'Tools, hardware, electrical and HVAC components.'],
            ['name' => 'Office & IT Supplies', 'category_type' => 'asset', 'description' => 'Stationery, printers, keycards, batteries, and peripherals.'],
            ['name' => 'Spa & Wellness Supplies', 'category_type' => 'consumable', 'description' => 'Essential oils, massage products, robes, and slippers.'],
            ['name' => 'Pool & Recreation Supplies', 'category_type' => 'consumable', 'description' => 'Pool chemicals, towels, fitness equipment, and games.'],
            ['name' => 'Emergency & Safety Equipment', 'category_type' => 'asset', 'description' => 'Fire extinguishers, first aid kits, flashlights, and PPE.'],
            ['name' => 'Kitchen Equipment & Smallwares', 'category_type' => 'asset', 'description' => 'Cookware, utensils, prep tools, and small appliances.'],
            ['name' => 'General Utilities & Replacements', 'category_type' => 'asset', 'description' => 'General-purpose replacements and utility items.'],
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            Category::query()->updateOrCreate(
                ['slug' => $slug],
                array_merge($category, ['slug' => $slug])
            );
        }
    }
}

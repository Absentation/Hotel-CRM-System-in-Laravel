<?php

namespace Database\Seeders;

use App\Models\Inventory\Category;
use App\Models\Inventory\Item;
use App\Models\Inventory\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id', 'slug');
        $locationIds = Location::query()->pluck('id', 'slug');

        $items = [
            [
                'name' => 'Basmati Rice 25kg Bag',
                'sku' => 'FD-RICE-25KG',
                'unit' => 'bag',
                'unit_cost' => 32.50,
                'reorder_level' => 4,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'food-ingredients',
                'location_slug' => 'main-kitchen-pantry',
                'description' => 'Long-grain basmati rice used for banquets and staff meals.',
            ],
            [
                'name' => 'Frozen Salmon Fillets 5kg',
                'sku' => 'FD-SALMON-5KG',
                'unit' => 'case',
                'unit_cost' => 68.00,
                'reorder_level' => 3,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'food-ingredients',
                'location_slug' => 'cold-storage-freezer',
                'description' => 'Individually vacuum-packed salmon fillets.',
            ],
            [
                'name' => 'House Red Wine Bottle 750ml',
                'sku' => 'BV-RED-750',
                'unit' => 'bottle',
                'unit_cost' => 11.20,
                'reorder_level' => 48,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'beverages-bar-supplies',
                'location_slug' => 'beverage-cellar',
                'description' => 'Signature house red wine served in restaurant and bar.',
            ],
            [
                'name' => 'Premium Bath Towel',
                'sku' => 'GA-TOWEL-BATH',
                'unit' => 'each',
                'unit_cost' => 9.50,
                'reorder_level' => 60,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'guest-room-amenities',
                'location_slug' => 'housekeeping-amenities-closet',
                'description' => 'Hotel-branded plush bath towels for guestrooms.',
            ],
            [
                'name' => 'Guest Shampoo 50ml',
                'sku' => 'GA-SHAMPOO-50',
                'unit' => 'case',
                'unit_cost' => 24.00,
                'reorder_level' => 20,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'guest-room-amenities',
                'location_slug' => 'housekeeping-amenities-closet',
                'description' => 'Individual guest shampoo amenity bottles (case of 100).',
            ],
            [
                'name' => 'Commercial Laundry Detergent 10L',
                'sku' => 'LS-DETERGENT-10L',
                'unit' => 'jug',
                'unit_cost' => 18.75,
                'reorder_level' => 10,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'laundry-supplies',
                'location_slug' => 'laundry-room-supply',
                'description' => 'High-efficiency liquid detergent for on-premise laundry.',
            ],
            [
                'name' => 'All-Purpose Cleaner Concentrate',
                'sku' => 'HS-CLEANER-APC',
                'unit' => 'bottle',
                'unit_cost' => 7.80,
                'reorder_level' => 24,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'housekeeping-supplies',
                'location_slug' => 'housekeeping-amenities-closet',
                'description' => 'Neutral pH cleaner concentrate for general housekeeping.',
            ],
            [
                'name' => 'LED Light Bulb 12W Warm White',
                'sku' => 'ME-BULB-12W',
                'unit' => 'box',
                'unit_cost' => 15.90,
                'reorder_level' => 12,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'maintenance-engineering',
                'location_slug' => 'maintenance-workshop',
                'description' => 'Replacement LED bulbs for guestrooms and public areas (box of 10).',
            ],
            [
                'name' => 'Printer Paper A4 80gsm',
                'sku' => 'OF-PAPER-A4',
                'unit' => 'ream',
                'unit_cost' => 4.20,
                'reorder_level' => 40,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'office-it-supplies',
                'location_slug' => 'front-office-supply-closet',
                'description' => 'Standard A4 copy paper for office and front desk printers.',
            ],
            [
                'name' => 'Lavender Essential Oil Blend',
                'sku' => 'SP-OIL-LAV',
                'unit' => 'bottle',
                'unit_cost' => 12.95,
                'reorder_level' => 16,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'spa-wellness-supplies',
                'location_slug' => 'spa-wellness-storage',
                'description' => 'Therapeutic-grade essential oil used in spa treatments.',
            ],
            [
                'name' => 'Pool Chlorine Tablets',
                'sku' => 'PR-CHLORINE',
                'unit' => 'bucket',
                'unit_cost' => 42.00,
                'reorder_level' => 6,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'pool-recreation-supplies',
                'location_slug' => 'pool-recreation-equipment-room',
                'description' => 'Stabilized chlorine tablets for pool water treatment.',
            ],
            [
                'name' => 'ABC Dry Chemical Fire Extinguisher 5lb',
                'sku' => 'ES-FIREEXT-5',
                'unit' => 'each',
                'unit_cost' => 58.00,
                'reorder_level' => 8,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'emergency-safety-equipment',
                'location_slug' => 'emergency-safety-storage',
                'description' => 'Multipurpose fire extinguisher for guest floors and back-of-house.',
            ],
            [
                'name' => 'Universal TV Remote Replacement',
                'sku' => 'GU-TV-REMOTE',
                'unit' => 'each',
                'unit_cost' => 14.50,
                'reorder_level' => 15,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'general-utilities-replacements',
                'location_slug' => 'central-stores-warehouse',
                'description' => 'Replacement remote controls for guestroom televisions.',
            ],
            [
                'name' => 'Stainless Steel Saucepan 3qt',
                'sku' => 'KE-SAUCEPAN-3QT',
                'unit' => 'each',
                'unit_cost' => 36.00,
                'reorder_level' => 6,
                'track_quantity' => true,
                'is_active' => true,
                'category_slug' => 'kitchen-equipment-smallwares',
                'location_slug' => 'central-stores-warehouse',
                'description' => 'Professional-grade saucepan for kitchen line replacements.',
            ],
        ];

        foreach ($items as $item) {
            $categoryId = Arr::get($categoryIds, $item['category_slug']);
            $locationId = Arr::get($locationIds, $item['location_slug']);

            if (! $categoryId || ! $locationId) {
                continue;
            }

            Item::query()->updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'sku' => $item['sku'],
                    'unit' => $item['unit'],
                    'unit_cost' => $item['unit_cost'],
                    'reorder_level' => $item['reorder_level'],
                    'track_quantity' => $item['track_quantity'],
                    'is_active' => $item['is_active'],
                    'category_id' => $categoryId,
                    'location_id' => $locationId,
                    'description' => $item['description'],
                ]
            );
        }
    }
}

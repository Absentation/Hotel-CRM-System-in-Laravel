<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            EmployeeSeeder::class,
            RoomTypeSeeder::class,
            AdditionalServiceSeeder::class,
            MealSeeder::class,
            CustomerSeeder::class,
            BookingSeeder::class,
            InventoryLocationSeeder::class,
            InventoryCategorySeeder::class,
            InventoryItemSeeder::class,
        ]);
    }
}

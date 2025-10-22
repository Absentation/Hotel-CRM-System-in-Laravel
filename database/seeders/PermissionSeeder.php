<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage_employees', 'display_name' => 'Manage Employees'],
            ['name' => 'manage_rooms', 'display_name' => 'Manage Rooms'],
            ['name' => 'manage_room_types', 'display_name' => 'Manage Room Types'],
            ['name' => 'manage_customers', 'display_name' => 'Manage Customers'],
            ['name' => 'manage_bookings', 'display_name' => 'Manage Bookings'],
            ['name' => 'manage_services', 'display_name' => 'Manage Services'],
            ['name' => 'manage_meals', 'display_name' => 'Manage Meals'],
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
            ['name' => 'manage_inventory', 'display_name' => 'Manage Inventory'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}

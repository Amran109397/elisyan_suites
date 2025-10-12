<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'super_admin',
                'description' => 'System administrator with full access',
                'permissions' => ['full_access']
            ],
            [
                'name' => 'property_manager',
                'description' => 'Manages specific properties and staff',
                'permissions' => ['manage_properties', 'manage_staff', 'view_reports']
            ],
            [
                'name' => 'receptionist',
                'description' => 'Handles check-ins, check-outs, and reservations',
                'permissions' => ['manage_bookings', 'manage_guests', 'process_payments']
            ],
            [
                'name' => 'housekeeping',
                'description' => 'Manages cleaning tasks and room status',
                'permissions' => ['manage_tasks', 'update_room_status']
            ],
            [
                'name' => 'pos_staff',
                'description' => 'Handles restaurant and POS operations',
                'permissions' => ['manage_orders', 'process_payments']
            ],
            [
                'name' => 'maintenance',
                'description' => 'Handles maintenance issues and repairs',
                'permissions' => ['report_issues', 'update_maintenance_status']
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
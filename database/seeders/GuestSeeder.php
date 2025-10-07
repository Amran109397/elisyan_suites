// database/seeders/GuestSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guest;
use App\Models\User;

class GuestSeeder extends Seeder
{
    public function run()
    {
        $guests = [
            [
                'user_id' => null,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-1234567',
                'date_of_birth' => '1980-05-15',
                'id_type' => 'passport',
                'id_number' => 'AB123456',
                'nationality' => 'American',
                'address' => '123 Main St, New York, NY 10001, USA',
                'vip_status' => true,
            ],
            [
                'user_id' => null,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+44-20-12345678',
                'date_of_birth' => '1985-08-22',
                'id_type' => 'passport',
                'id_number' => 'CD789012',
                'nationality' => 'British',
                'address' => '456 Park Ave, London, SW1A 1AA, UK',
                'vip_status' => false,
            ],
            [
                'user_id' => null,
                'first_name' => 'Ahmed',
                'last_name' => 'Khan',
                'email' => 'ahmed.khan@example.com',
                'phone' => '+880-17-12345678',
                'date_of_birth' => '1990-12-10',
                'id_type' => 'nid',
                'id_number' => '1234567890',
                'nationality' => 'Bangladeshi',
                'address' => '789 Gulshan Avenue, Dhaka 1212, Bangladesh',
                'vip_status' => false,
            ],
            [
                'user_id' => null,
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@example.com',
                'phone' => '+34-91-1234567',
                'date_of_birth' => '1975-03-18',
                'id_type' => 'passport',
                'id_number' => 'EF345678',
                'nationality' => 'Spanish',
                'address' => '321 Gran Vía, Madrid, 28013, Spain',
                'vip_status' => true,
            ],
            [
                'user_id' => null,
                'first_name' => 'Robert',
                'last_name' => 'Johnson',
                'email' => 'robert.johnson@example.com',
                'phone' => '+1-416-1234567',
                'date_of_birth' => '1982-11-05',
                'id_type' => 'passport',
                'id_number' => 'GH901234',
                'nationality' => 'Canadian',
                'address' => '555 Bay Street, Toronto, ON M5H 2A2, Canada',
                'vip_status' => false,
            ],
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }
    }
}
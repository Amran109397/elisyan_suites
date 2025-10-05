<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->default(1)->after('id')->constrained('roles');
        });

        // Insert default roles
        $this->insertDefaultRoles();
    }

    private function insertDefaultRoles()
    {
        $roles = [
            [
                'name' => 'super_admin',
                'description' => 'System Administrator with full access',
                'permissions' => json_encode(['full_access']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'property_manager',
                'description' => 'Property Manager with limited access',
                'permissions' => json_encode(['manage_property', 'view_reports']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'receptionist',
                'description' => 'Front Desk Receptionist',
                'permissions' => json_encode(['manage_bookings', 'manage_guests']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'housekeeping',
                'description' => 'Housekeeping Staff',
                'permissions' => json_encode(['manage_tasks', 'view_rooms']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pos_staff',
                'description' => 'Point of Sale Staff',
                'permissions' => json_encode(['manage_orders', 'process_payments']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'maintenance',
                'description' => 'Maintenance Staff',
                'permissions' => json_encode(['report_issues', 'update_status']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        
        Schema::dropIfExists('roles');
    }
};
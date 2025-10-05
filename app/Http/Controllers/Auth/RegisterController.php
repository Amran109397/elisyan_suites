<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
        ]);
    }

    protected function showRegistrationForm()
    {
        // Ensure default roles exist
        if (Role::count() === 0) {
            $this->createDefaultRoles();
        }
        
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    private function createDefaultRoles()
    {
        $roles = [
            [
                'name' => 'super_admin',
                'description' => 'System Administrator with full access',
                'permissions' => json_encode(['full_access'])
            ],
            [
                'name' => 'property_manager',
                'description' => 'Property Manager with limited access',
                'permissions' => json_encode(['manage_property', 'view_reports'])
            ],
            [
                'name' => 'receptionist',
                'description' => 'Front Desk Receptionist',
                'permissions' => json_encode(['manage_bookings', 'manage_guests'])
            ],
            [
                'name' => 'housekeeping',
                'description' => 'Housekeeping Staff',
                'permissions' => json_encode(['manage_tasks', 'view_rooms'])
            ],
            [
                'name' => 'pos_staff',
                'description' => 'Point of Sale Staff',
                'permissions' => json_encode(['manage_orders', 'process_payments'])
            ],
            [
                'name' => 'maintenance',
                'description' => 'Maintenance Staff',
                'permissions' => json_encode(['report_issues', 'update_status'])
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
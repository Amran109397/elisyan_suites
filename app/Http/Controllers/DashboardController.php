<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        // শুধুমাত্র অথেনটিকেটেড ইউজাররাই ড্যাশবোর্ড দেখতে পারবে
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        // Check if user has a role
        if (!$user->role) {
            // Assign default role if no role exists (receptionist হিসেবে, super_admin নয়)
            $defaultRole = Role::where('name', 'receptionist')->first(); 
            if ($defaultRole) {
                $user->role_id = $defaultRole->id;
                $user->save();
                
                // Reload the user with role
                $user->load('role');
            }
        }
        
        $role = $user->role->name;

        // Get role-specific data
        $stats = $this->getRoleStats($role);
        $activities = $this->getRoleActivities($role);

        return view('backend.dashboard.index', compact('stats', 'activities'));
    }

    private function getRoleStats($role)
    {
        switch ($role) {
            case 'super_admin':
                return [
                    ['icon' => 'fas fa-building', 'value' => '3', 'label' => 'Properties', 'color' => 'primary'],
                    ['icon' => 'fas fa-users', 'value' => '15', 'label' => 'Total Staff', 'color' => 'success'],
                    ['icon' => 'fas fa-bed', 'value' => '45', 'label' => 'Total Rooms', 'color' => 'info'],
                    ['icon' => 'fas fa-calendar', 'value' => '12', 'label' => 'Today Bookings', 'color' => 'warning']
                ];

            case 'property_manager':
                return [
                    ['icon' => 'fas fa-building', 'value' => '2', 'label' => 'My Properties', 'color' => 'primary'],
                    ['icon' => 'fas fa-bed', 'value' => '30', 'label' => 'Managed Rooms', 'color' => 'success'],
                    ['icon' => 'fas fa-calendar', 'value' => '8', 'label' => 'Today Check-ins', 'color' => 'info'],
                    ['icon' => 'fas fa-chart-line', 'value' => '75%', 'label' => 'Occupancy Rate', 'color' => 'warning']
                ];

            case 'receptionist':
                return [
                    ['icon' => 'fas fa-calendar', 'value' => '5', 'label' => 'Today Check-ins', 'color' => 'primary'],
                    ['icon' => 'fas fa-calendar-check', 'value' => '3', 'label' => 'Today Check-outs', 'color' => 'success'],
                    ['icon' => 'fas fa-users', 'value' => '12', 'label' => 'Current Guests', 'color' => 'info'],
                    ['icon' => 'fas fa-bed', 'value' => '8', 'label' => 'Available Rooms', 'color' => 'warning']
                ];

            case 'housekeeping':
                return [
                    ['icon' => 'fas fa-broom', 'value' => '10', 'label' => 'Tasks Today', 'color' => 'primary'],
                    ['icon' => 'fas fa-check-circle', 'value' => '7', 'label' => 'Completed', 'color' => 'success'],
                    ['icon' => 'fas fa-clock', 'value' => '2', 'label' => 'In Progress', 'color' => 'info'],
                    ['icon' => 'fas fa-exclamation-triangle', 'value' => '1', 'label' => 'Pending', 'color' => 'warning']
                ];

            case 'pos_staff':
                return [
                    ['icon' => 'fas fa-shopping-cart', 'value' => '24', 'label' => 'Orders Today', 'color' => 'primary'],
                    ['icon' => 'fas fa-money-bill-wave', 'value' => '$1,250', 'label' => 'Revenue', 'color' => 'success'],
                    ['icon' => 'fas fa-utensils', 'value' => '18', 'label' => 'Dine-in', 'color' => 'info'],
                    ['icon' => 'fas fa-motorcycle', 'value' => '6', 'label' => 'Takeaway', 'color' => 'warning']
                ];

            case 'maintenance':
                return [
                    ['icon' => 'fas fa-tools', 'value' => '5', 'label' => 'Pending Issues', 'color' => 'primary'],
                    ['icon' => 'fas fa-wrench', 'value' => '3', 'label' => 'In Progress', 'color' => 'success'],
                    ['icon' => 'fas fa-check-double', 'value' => '12', 'label' => 'Completed', 'color' => 'info'],
                    ['icon' => 'fas fa-exclamation-circle', 'value' => '2', 'label' => 'Urgent', 'color' => 'warning']
                ];

            default:
                return [
                    ['icon' => 'fas fa-user', 'value' => '1', 'label' => 'Profile', 'color' => 'primary'],
                    ['icon' => 'fas fa-tasks', 'value' => '5', 'label' => 'Tasks', 'color' => 'success'],
                    ['icon' => 'fas fa-bell', 'value' => '3', 'label' => 'Notifications', 'color' => 'info'],
                    ['icon' => 'fas fa-clock', 'value' => '0', 'label' => 'Pending', 'color' => 'warning']
                ];
        }
    }

    private function getRoleActivities($role)
    {
        switch ($role) {
            case 'super_admin':
                return [
                    ['icon' => 'fas fa-user-plus', 'title' => 'New user registered', 'time' => '2 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-database', 'title' => 'System backup completed', 'time' => '5 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-building', 'title' => 'New property added', 'time' => '10 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-cog', 'title' => 'System settings updated', 'time' => '15 min ago', 'color' => 'warning']
                ];

            case 'property_manager':
                return [
                    ['icon' => 'fas fa-broom', 'title' => 'Room cleaning scheduled', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-chart-bar', 'title' => 'Monthly report generated', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-users', 'title' => 'Staff meeting completed', 'time' => '30 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-tools', 'title' => 'Maintenance request approved', 'time' => '45 min ago', 'color' => 'warning']
                ];

            case 'receptionist':
                return [
                    ['icon' => 'fas fa-calendar-plus', 'title' => 'New booking received', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-key', 'title' => 'Guest checked in', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-credit-card', 'title' => 'Payment processed', 'time' => '25 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-concierge-bell', 'title' => 'Room service requested', 'time' => '35 min ago', 'color' => 'warning']
                ];

            case 'housekeeping':
                return [
                    ['icon' => 'fas fa-broom', 'title' => 'Room 201 cleaning completed', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-bed', 'title' => 'Turndown service requested', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-tint', 'title' => 'Plumbing issue reported', 'time' => '30 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-exclamation-triangle', 'title' => 'Urgent cleaning task', 'time' => '45 min ago', 'color' => 'warning']
                ];

            case 'pos_staff':
                return [
                    ['icon' => 'fas fa-utensils', 'title' => 'New order received', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-credit-card', 'title' => 'Payment processed', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-concierge-bell', 'title' => 'Room service order', 'time' => '25 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-motorcycle', 'title' => 'Takeaway order ready', 'time' => '35 min ago', 'color' => 'warning']
                ];

            case 'maintenance':
                return [
                    ['icon' => 'fas fa-wrench', 'title' => 'AC repair completed', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-lightbulb', 'title' => 'Lighting issue reported', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-faucet', 'title' => 'Plumbing work in progress', 'time' => '30 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-exclamation-circle', 'title' => 'Urgent elevator issue', 'time' => '45 min ago', 'color' => 'warning']
                ];

            default:
                return [
                    ['icon' => 'fas fa-user-edit', 'title' => 'Profile updated', 'time' => '5 min ago', 'color' => 'primary'],
                    ['icon' => 'fas fa-check-circle', 'title' => 'Task completed', 'time' => '15 min ago', 'color' => 'success'],
                    ['icon' => 'fas fa-sign-in-alt', 'title' => 'Login successful', 'time' => '25 min ago', 'color' => 'info'],
                    ['icon' => 'fas fa-bell', 'title' => 'New notification', 'time' => '35 min ago', 'color' => 'warning']
                ];
        }
    }
}
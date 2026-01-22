<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == Role::ROLE_ADMIN) {
            return $this->adminDashboard();
        } elseif ($user->role_id == Role::ROLE_STAFF) {
            return view('dashboard.staff_index');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    private function adminDashboard()
    {
        return view('dashboard.admin_index');
    }

    private function staffDashboard()
    {
        $user = Auth::user();

        if (! $user->counter) {
            abort(403, 'User tidak terhubung dengan counter.');
        }

        $counter = $user->counter;
        $service = $counter->service;

        return view('dashboard.staff_index', compact(
            'user',
            'counter',
            'service',
        ));
    }
}

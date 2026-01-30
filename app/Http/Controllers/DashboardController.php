<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == Role::ADMIN) {
            return $this->adminDashboard();
        } elseif ($user->role_id == Role::COUNTER) {
            return view('dashboard.staff_index');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    private function adminDashboard()
    {
        return view('dashboard.admin_index');
    }
}

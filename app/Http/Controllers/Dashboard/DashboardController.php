<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Queue;
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
            return $this->staffDashboard();
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
        $today = now()->toDateString();

        $currentQueue = Queue::with('service')
            ->where('counter_id', $counter->id)
            ->whereIn('status', [
                Queue::STATUS_SERVING,
                Queue::STATUS_CALLED,
            ])
            ->whereDate('created_at', $today)
            ->orderBy('updated_at')
            ->first();

        $nextQueue = Queue::with('service')
            ->where('service_id', $service->id)
            ->whereNull('counter_id')
            ->where('status', Queue::STATUS_WAITING)
            ->whereDate('created_at', $today)
            ->orderBy('sequence')
            ->first();

        $waitingList = Queue::where('service_id', $service->id)
            ->where('status', Queue::STATUS_WAITING)
            ->whereDate('created_at', $today)
            ->orderBy('sequence')
            ->limit(10)
            ->get();

        $historyList = Queue::where('counter_id', $counter->id)
            ->whereIn('status', [
                Queue::STATUS_COMPLETED,
                Queue::STATUS_SKIPPED,
            ])
            ->whereDate('created_at', $today)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        $stats = (object) [
            'waiting' => Queue::where('service_id', $service->id)
                ->where('status', Queue::STATUS_WAITING)
                ->whereDate('created_at', $today)
                ->count(),

            'completed' => Queue::where('counter_id', $counter->id)
                ->where('status', Queue::STATUS_COMPLETED)
                ->whereDate('created_at', $today)
                ->count(),

            'skipped' => Queue::where('counter_id', $counter->id)
                ->where('status', Queue::STATUS_SKIPPED)
                ->whereDate('created_at', $today)
                ->count(),
        ];

        $serverTimeMs = $currentQueue && $currentQueue->start_time
            ? strtotime($currentQueue->start_time) * 1000
            : 0;

        // dd([
        //     'currentQueue' => $currentQueue->toArray(),
        //     'nextQueue'    => $nextQueue->toArray(),
        //     'waitingList'  => $waitingList->toArray(),
        //     'historyList'  => $historyList->toArray(),
        //     'stats'        => $stats,
        //     'serverTimeMs' => $serverTimeMs,
        // ]);

        return view('dashboard.staff_index', compact(
            'currentQueue',
            'nextQueue',
            'waitingList',
            'historyList',
            'stats',
            'serverTimeMs'
        ));
    }
}

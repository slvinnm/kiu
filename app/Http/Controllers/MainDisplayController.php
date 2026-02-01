<?php

namespace App\Http\Controllers;

use App\Models\TicketStep;

class MainDisplayController extends Controller
{
    public function index()
    {
        return view('frontend.display.index');
    }

    public function getDisplayData()
    {
        $setting = [
            'logo' => 'https://cdn-icons-png.flaticon.com/512/3063/3063822.png',
            'media_type' => 'image',
            'video' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'slideshow' => [
                'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=2000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop',
            ],
            'name' => 'RSUD KOTA',
            'running_text' => 'PENGUMUMAN: Harap menjaga kebersihan ruang tunggu.',
        ];

        $activeCounters = TicketStep::with(['ticket', 'service', 'counter'])
            ->whereIn('status', ['called', 'serving'])
            ->whereDate('created_at', today())
            ->whereNotNull('counter_id')
            ->orderBy('called_at', 'desc')
            ->get();

        $current = $activeCounters->first();

        $history = TicketStep::with(['ticket', 'service', 'counter'])
            ->where('status', 'completed')
            ->whereDate('updated_at', today())
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'setting' => $setting,
            'current' => $current,
            'active_counters' => $activeCounters,
            'history' => $history,
        ], 200);
    }
}

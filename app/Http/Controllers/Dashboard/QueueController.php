<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    // public function callQueue(Queue $queue)
    // {
    //     $user = Auth::user();

    //     if (! $user->counter) {
    //         abort(403, 'User tidak terhubung dengan counter.');
    //     }

    //     $counter = $user->counter;

    //     if ($counter->status !== Counter::STATUS_OPEN) {
    //         return back()->with('error', 'Counter sedang tidak tersedia.');
    //     }

    //     if ($queue->service_id !== $counter->service_id) {
    //         abort(403, 'Queue tidak sesuai dengan layanan counter.');
    //     }

    //     if ($queue->status !== Queue::STATUS_WAITING) {
    //         return back()->with('error', 'Queue tidak dapat dipanggil.');
    //     }

    //     if ($queue->created_at->toDateString() !== now()->toDateString()) {
    //         return back()->with('error', 'Queue sudah tidak valid.');
    //     }

    //     $hasActiveQueue = Queue::where('counter_id', $counter->id)
    //         ->whereIn('status', [
    //             Queue::STATUS_CALLED,
    //             Queue::STATUS_SERVING,
    //         ])
    //         ->exists();

    //     if ($hasActiveQueue) {
    //         return back()->with('error', 'Masih ada antrian aktif di counter ini.');
    //     }

    //     DB::transaction(function () use ($queue, $counter) {
    //         $queue->update([
    //             'counter_id' => $counter->id,
    //             'status' => Queue::STATUS_CALLED,
    //             'start_time' => now(),
    //         ]);
    //     });

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Nomor ' . $queue->ticket_number . ' berhasil dipanggil.'
    //     ], 200);
    // }
}

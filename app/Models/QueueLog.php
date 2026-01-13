<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueLog extends Model
{
    /** @use HasFactory<\Database\Factories\QueueLogFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'queue_id',
        'event',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}

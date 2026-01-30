<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    /** @use HasFactory<\Database\Factories\CounterFactory> */
    use HasFactory, HasUlids;

    public const STATUS = [
        'open' => 'Buka',
        'closed' => 'Tutup',
        'break' => 'Istirahat',
    ];

    public const STATUS_OPEN = 'open';

    public const STATUS_CLOSED = 'closed';

    public const STATUS_BREAK = 'break';

    protected $fillable = [
        'name',
        'status',
    ];

    public function operator()
    {
        return $this->hasOne(User::class);
    }
}

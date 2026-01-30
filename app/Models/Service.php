<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'code',
        'icon',
        'opening_time',
        'closing_time',
        'max_queue_per_day',
        'is_active',
    ];

    public function operator()
    {
        return $this->hasOne(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

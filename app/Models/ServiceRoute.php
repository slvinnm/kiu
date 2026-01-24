<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoute extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceRouteFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'from_service_id',
        'to_service_id',
        'step_order',
    ];
}

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

    public function fromService()
    {
        return $this->belongsTo(Service::class, 'from_service_id');
    }

    public function toService()
    {
        return $this->belongsTo(Service::class, 'to_service_id');
    }
}

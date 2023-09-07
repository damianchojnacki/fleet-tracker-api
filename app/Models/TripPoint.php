<?php

namespace App\Models;

use App\Services\GeoService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripPoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function (TripPoint $model) {
            $model->created_at = $model->created_at ?? $model->freshTimestamp();
        });
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function getDistanceTo(TripPoint $point): float
    {
        return GeoService::calculateDistanceBetweenTwoPoints(
            $this->lat,
            $this->lng,
            $point->lat,
            $point->lng
        );
    }
}

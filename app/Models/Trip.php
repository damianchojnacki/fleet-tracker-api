<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property float $distance
 * @property bool $is_finished
 * @property string|null $note
 * @property string|null $from
 * @property string|null $to
 * @property Carbon $starts_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Trip extends Model
{
    use HasFactory;

    protected $casts = [
        'starts_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(TripPoint::class);
    }

    public function calculateDistance(): float
    {
        $distance = 0;

        if (! $this->relationLoaded('points')) {
            $this->load('points');
        }

        $points = $this->points;

        $points->each(function (TripPoint $point, int $i) use (&$distance, $points) {
            if ($i >= $points->count() - 1) {
                return;
            }

            $distance += $point->getDistanceTo($points[$i + 1]);
        });

        return $distance;
    }
}

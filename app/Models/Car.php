<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $plate_number
 * @property string $vin
 * @property array<string,int|float|string> $specs
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Car extends Model
{
    use HasFactory;

    protected $casts = [
        'specs' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}

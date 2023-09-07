<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string $name
 */
class CarBrand extends Model
{
    use Sushi;

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    /**
     * @return array{id: int, name: string}|array<never>
     */
    public function getRows(): array
    {
        return Storage::json('car-brands.json') ?? [];
    }

    protected function sushiShouldCache(): bool
    {
        return true;
    }

    protected function sushiCacheReferencePath(): string
    {
        return Storage::path('car-brands.json');
    }
}

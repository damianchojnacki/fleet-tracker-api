<?php

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CarModel::class, 'model_id')->constrained('car_models')->cascadeOnDelete();
            $table->foreignIdFor(CarBrand::class, 'brand_id')->constrained('car_brands')->cascadeOnDelete();
            $table->string('plate_number')->nullable();
            $table->string('vin')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

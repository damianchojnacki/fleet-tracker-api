<?php

use App\Models\CarBrand;
use App\Models\Organization;
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
            $table->foreignIdFor(CarBrand::class, 'brand_id');
            $table->foreignIdFor(Organization::class)->constrained()->cascadeOnDelete();
            $table->string('plate_number')->nullable();
            $table->string('vin')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('specs')->default('{}');
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

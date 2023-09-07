<?php

use App\Models\Trip;
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
        Schema::create('trip_points', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Trip::class)->constrained()->cascadeOnDelete();
            $table->decimal('lat', 6, 4);
            $table->decimal('lng', 7, 4);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_points');
    }
};

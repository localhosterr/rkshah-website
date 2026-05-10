<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->string('type', 60);  // e.g. "Premium SUV", "Compact SUV"
            $table->string('fuel', 30);  // Diesel, Petrol, CNG
            $table->string('model_year', 20);
            $table->tinyInteger('seats');
            $table->string('luggage', 50)->nullable();

            // Pricing
            $table->decimal('rate_per_km', 6, 2);
            $table->decimal('driver_allowance', 8, 2)->default(0);
            $table->integer('min_km')->default(250);

            // Display
            $table->string('badge', 50)->nullable();  // "Most Popular", "Budget Pick"
            $table->string('emoji', 10)->nullable();
            $table->string('bg_class', 60)->nullable(); // CSS class for card background
            $table->json('features')->nullable();       // ["AC","GPS","USB Charging"]
            $table->string('best_for', 200)->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleet');
    }
};

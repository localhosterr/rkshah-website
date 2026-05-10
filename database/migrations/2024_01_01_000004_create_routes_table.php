<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('from_city', 80);
            $table->string('to_city', 80);
            $table->string('slug', 160)->unique();

            // Distance & time
            $table->integer('distance_km')->default(0);
            $table->decimal('duration_hrs', 4, 1)->nullable();
            $table->string('highway', 200)->nullable();
            $table->string('highlight', 100)->nullable(); // "Taj Mahal", "Pink City"
            $table->string('tag', 50)->nullable();        // "Weekend", "Hills", "Spiritual"
            $table->string('accent_color', 20)->nullable();

            // Per-car pricing (nullable = car not recommended for this route)
            $table->decimal('price_dzire',  10, 2)->nullable();
            $table->decimal('price_ertiga', 10, 2)->nullable();
            $table->decimal('price_creta',  10, 2)->nullable();
            $table->decimal('price_innova', 10, 2)->nullable();

            // SEO
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 320)->nullable();

            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
            $table->index('tag');
            $table->index(['from_city', 'to_city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

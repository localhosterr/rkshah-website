<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 160)->unique();

            // Duration
            $table->tinyInteger('nights')->default(0);
            $table->tinyInteger('days')->default(0);

            // Pricing
            $table->decimal('price', 10, 2)->default(0); // 0 = custom/contact us

            // Display
            $table->string('badge', 60)->nullable();   // "Best Seller", "Trending"
            $table->string('emoji', 10)->nullable();
            $table->string('bg_class', 60)->nullable();
            $table->json('destinations')->nullable();  // ["Jaipur","Jodhpur","Udaipur"]
            $table->json('includes')->nullable();      // ["AC Cab","Expert Driver","Fuel & Tolls"]
            $table->text('description')->nullable();
            $table->json('itinerary')->nullable();     // [{"day":1,"title":"Delhi → Jaipur","desc":"..."}]

            // SEO
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 320)->nullable();

            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

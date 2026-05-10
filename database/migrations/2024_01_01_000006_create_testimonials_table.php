<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 100);
            $table->string('initials', 5);
            $table->tinyInteger('rating')->default(5);  // 1-5
            $table->text('review_text');
            $table->string('trip_route', 150)->nullable();  // "Delhi → Jaipur"
            $table->string('car_used', 60)->nullable();     // "Innova Crysta"
            $table->string('source', 50)->default('Google Review');

            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_published');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};

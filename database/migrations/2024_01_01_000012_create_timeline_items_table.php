<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_items', function (Blueprint $table) {
            $table->id();
            $table->string('year', 10);
            $table->string('title', 120);
            $table->text('description');
            $table->string('icon', 10)->default('📍');
            $table->string('color', 20)->default('#D4A017');
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_items');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            // key is the primary key — no auto-increment ID
            $table->string('key', 100)->primary();
            $table->text('value')->nullable();
            $table->enum('type', ['string','number','boolean','json'])->default('string');
            $table->string('description', 200)->nullable();
            $table->boolean('is_public')->default(false); // public = readable by website visitors
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

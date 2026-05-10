<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page', 60);        // homepage, about, contact
            $table->string('section', 80);     // hero, how_it_works, cta, ticker
            $table->string('key', 100);        // title, subtitle, step_1_title
            $table->text('value')->nullable();
            $table->enum('type', [
                'text','textarea','number','boolean','json','color','url'
            ])->default('text');
            $table->string('label', 120)->nullable(); // human-readable label for CMS
            $table->string('hint', 200)->nullable();  // helper text shown in CMS
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['page','section','key']);
            $table->index(['page','section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};

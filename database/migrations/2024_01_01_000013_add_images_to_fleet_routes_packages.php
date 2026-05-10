<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fleet', function (Blueprint $table) {
            if (!Schema::hasColumn('fleet', 'featured_image')) {
                $table->string('featured_image', 500)->nullable()->after('bg_class');
            }
        });

        Schema::table('routes', function (Blueprint $table) {
            if (!Schema::hasColumn('routes', 'featured_image')) {
                $table->string('featured_image', 500)->nullable()->after('accent_color');
            }
        });

        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'featured_image')) {
                $table->string('featured_image', 500)->nullable()->after('bg_class');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fleet',    fn($t) => $t->dropColumn('featured_image'));
        Schema::table('routes',   fn($t) => $t->dropColumn('featured_image'));
        Schema::table('packages', fn($t) => $t->dropColumn('featured_image'));
    }
};
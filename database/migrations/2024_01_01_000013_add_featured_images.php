<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add featured_image to fleet table
        if (!Schema::hasColumn('fleet', 'featured_image')) {
            Schema::table('fleet', function (Blueprint $table) {
                $table->string('featured_image', 500)->nullable()->after('bg_class');
            });
        }

        // Add featured_image to routes table
        if (!Schema::hasColumn('routes', 'featured_image')) {
            Schema::table('routes', function (Blueprint $table) {
                $table->string('featured_image', 500)->nullable()->after('accent_color');
            });
        }

        // Add featured_image to packages table
        if (!Schema::hasColumn('packages', 'featured_image')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->string('featured_image', 500)->nullable()->after('bg_class');
            });
        }

        // Add owner_photo to settings table as a new setting row
        \DB::table('settings')->insertOrIgnore([
            'key'         => 'owner_photo',
            'value'       => '',
            'type'        => 'text',
            'description' => 'Owner profile photo path (storage relative)',
            'is_public'   => true,
        ]);
    }

    public function down(): void
    {
        Schema::table('fleet',    fn($t) => $t->dropColumn('featured_image'));
        Schema::table('routes',   fn($t) => $t->dropColumn('featured_image'));
        Schema::table('packages', fn($t) => $t->dropColumn('featured_image'));
    }
};

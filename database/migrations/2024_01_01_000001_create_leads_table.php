<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Customer info
            $table->string('name', 100);
            $table->string('phone', 15);

            // Trip info
            $table->string('from_city', 80);
            $table->string('to_city', 80);
            $table->date('travel_date')->nullable();
            $table->time('pickup_time')->nullable();
            $table->enum('car_type', ['innova_crysta','kia_creta','ertiga','swift_dzire','any'])->default('any');
            $table->enum('trip_type', ['one_way','round_trip','airport','hourly'])->default('one_way');
            $table->smallInteger('passengers')->nullable();
            $table->text('message')->nullable();

            // Business fields
            $table->enum('status', [
                'new','contacted','quoted','confirmed','completed','cancelled'
            ])->default('new');
            $table->enum('source', [
                'website','whatsapp','phone','google_ads','meta_ads','referral','walkin'
            ])->default('website');
            $table->decimal('estimated_fare', 10, 2)->nullable();
            $table->timestamp('follow_up_at')->nullable();

            // Tracking
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->ipAddress('ip_address')->nullable();

            $table->timestamps();

            // Indexes for common queries
            $table->index('status');
            $table->index('phone');
            $table->index('source');
            $table->index('travel_date');
            $table->index('follow_up_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

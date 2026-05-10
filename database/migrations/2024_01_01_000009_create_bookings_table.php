<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Auto-generated reference number e.g. BK-000001
            $table->string('booking_ref', 20)->unique();

            // Link to original lead (optional)
            $table->foreignId('lead_id')
                  ->nullable()
                  ->constrained('leads')
                  ->onDelete('set null');

            // Customer
            $table->string('customer_name', 100);
            $table->string('customer_phone', 15);

            // Trip details
            $table->string('from_city', 80);
            $table->string('to_city', 80);
            $table->date('travel_date');
            $table->time('pickup_time')->nullable();
            $table->date('return_date')->nullable();

            // Car & Driver
            $table->enum('car_type', [
                'innova_crysta', 'kia_creta', 'ertiga', 'swift_dzire'
            ])->default('innova_crysta');
            $table->string('driver_name', 100)->nullable();
            $table->string('driver_phone', 15)->nullable();

            $table->enum('trip_type', [
                'one_way', 'round_trip', 'airport', 'hourly'
            ])->default('one_way');

            $table->tinyInteger('passengers')->nullable();

            // Financials
            $table->decimal('total_fare', 10, 2);
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('balance_due', 10, 2)->virtualAs('total_fare - advance_paid');
            $table->enum('advance_method', [
                'upi', 'cash', 'bank_transfer', 'card'
            ])->nullable();

            // Status
            $table->enum('status', [
                'pending', 'confirmed', 'in_progress', 'completed', 'cancelled'
            ])->default('confirmed');

            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('travel_date');
            $table->index('status');
            $table->index('customer_phone');
            $table->index('booking_ref');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

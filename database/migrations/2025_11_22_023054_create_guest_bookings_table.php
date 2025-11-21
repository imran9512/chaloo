<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('guest_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_lead_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('booking_dates');
            $table->decimal('total_fare', 10, 2);
            $table->string('payment_proof_path')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('guest_lead_id')->references('id')->on('guest_leads')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guest_bookings');
    }
}
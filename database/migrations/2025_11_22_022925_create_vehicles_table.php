<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->integer('seats');
            $table->boolean('ac_status')->default(false);
            $table->string('city', 100);
            $table->decimal('base_rate', 10, 2);
            $table->decimal('driver_rate', 10, 2)->nullable();
            $table->enum('condition', ['very-good', 'good', 'average'])->default('good');
            $table->enum('status', ['available', 'booked', 'handed_to_company', 'maintenance'])->default('available');
            $table->integer('available_in_days')->nullable();
            $table->text('special_notes')->nullable();
            $table->enum('managed_by', ['self', 'company'])->default('self');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->index('status');
            $table->index('managed_by');
            $table->index('city');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
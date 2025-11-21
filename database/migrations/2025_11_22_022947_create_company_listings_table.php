<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyListingsTable extends Migration
{
    public function up()
    {
        Schema::create('company_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->decimal('markup_percentage', 5, 2)->default(10.00);
            $table->boolean('admin_approved')->default(false);
            $table->timestamps();

            $table->unique('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_listings');
    }
}
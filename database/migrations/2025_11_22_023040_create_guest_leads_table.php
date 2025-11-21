<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('guest_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20);
            $table->string('city', 100);
            $table->enum('status', ['pending', 'contacted', 'converted'])->default('pending');
            $table->timestamps();

            $table->index('city');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guest_leads');
    }
}
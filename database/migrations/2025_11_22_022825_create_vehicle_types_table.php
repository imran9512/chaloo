<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTypesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        // Insert default data
        DB::table('vehicle_types')->insert([
            ['name' => 'Bus', 'slug' => 'bus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Coaster', 'slug' => 'coaster', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Car', 'slug' => 'car', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Van', 'slug' => 'van', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mini Van', 'slug' => 'mini-van', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_types');
    }
}
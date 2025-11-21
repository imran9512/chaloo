<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'guest_markup_percentage', 'value' => '10.00', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'default_listing_limit', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'admin_phone', 'value' => '923001234567', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_name', 'value' => 'Chaloo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
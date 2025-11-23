<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Sirf agar column nahi hai tab add karega
            if (!Schema::hasColumn('vehicles', 'driver_rate')) {
                $table->decimal('driver_rate', 10, 2)->nullable()->after('base_rate');
            }

            if (!Schema::hasColumn('vehicles', 'special_note')) {
                $table->text('special_note')->nullable()->after('driver_rate');
            }
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['driver_rate', 'special_note']);
        });
    }
};
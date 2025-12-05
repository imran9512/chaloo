<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('user_id');
            $table->date('arrival_date')->nullable()->after('departure_date');
            // Modifying enum is hard in some DBs, so we'll just change the default or add a comment. 
            // Ideally we should use string for status to be flexible.
            // For now, let's just make sure we can handle the new status values in code.
            // But if we want to enforce it in DB, we might need raw statement.
            // Let's just add the columns for now.
            // $table->string('status')->change(); // If we want to remove enum constrainte the migrations.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            //
        });
    }
};

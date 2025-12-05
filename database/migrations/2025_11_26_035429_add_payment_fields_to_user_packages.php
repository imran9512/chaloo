<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->enum('payment_status', ['free', 'pending', 'completed'])->default('free')->after('status');
            $table->text('payment_proof')->nullable()->after('payment_status');
            $table->timestamp('purchased_at')->nullable()->after('payment_proof');
        });
    }

    public function down(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_proof', 'purchased_at']);
        });
    }
};

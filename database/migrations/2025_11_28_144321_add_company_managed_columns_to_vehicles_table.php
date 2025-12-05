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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->boolean('is_company_managed')->default(false)->after('is_approved');
            $table->decimal('commission_percentage', 5, 2)->default(10.00)->after('is_company_managed');
            $table->decimal('base_daily_rate', 10, 2)->nullable()->after('daily_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['is_company_managed', 'commission_percentage', 'base_daily_rate']);
        });
    }
};

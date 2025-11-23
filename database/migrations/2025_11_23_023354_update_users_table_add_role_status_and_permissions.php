<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agar ye columns pehle se nahi hain to add kar do
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('phone');
            }

            // Ye column abhi 'password' hai → hum 'password_hash' banayenge
            if (!Schema::hasColumn('users', 'password_hash')) {
                $table->string('password_hash')->after('password');
            }

            // Role & Status (ENUM)
            $table->enum('role', ['transporter', 'agent', 'super_admin', 'operator'])
                  ->default('agent')
                  ->after('password_hash');

            $table->enum('status', ['active', 'suspended', 'pending'])
                  ->default('active')
                  ->after('role');

            // Subscription & Limits
            $table->date('subscription_ends_at')->nullable()->after('status');
            $table->integer('listing_limit')->default(10)->after('subscription_ends_at');
            $table->integer('credits')->default(0)->after('listing_limit');

            // Operator Permissions (boolean)
            $table->boolean('can_manage_transporters')->default(false);
            $table->boolean('can_manage_agents')->default(false);
            $table->boolean('can_manage_payments')->default(false);
            $table->boolean('can_manage_vehicle_types')->default(false);
            $table->boolean('can_manage_settings')->default(false);
        });

        // Ab purana 'password' column hata denge (data khatam ho jayega lekin dev mein theek hai)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['password', 'email_verified_at']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'city', 'password_hash', 'role', 'status',
                'subscription_ends_at', 'listing_limit', 'credits',
                'can_manage_transporters', 'can_manage_agents',
                'can_manage_payments', 'can_manage_vehicle_types', 'can_manage_settings'
            ]);
        });
    }
};
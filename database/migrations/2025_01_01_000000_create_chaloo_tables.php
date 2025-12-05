<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('city')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['guest', 'transporter', 'agent', 'admin', 'operator'])->default('guest');
            $table->string('status')->default('active'); // active, suspended, pending
            $table->json('operator_permissions')->nullable(); // For granular operator rights
            $table->rememberToken();
            $table->timestamps();
        });

        // Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Vehicle Types
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon')->nullable(); // SVG or path
            $table->integer('capacity')->default(4);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Vehicles
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Transporter
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');

            $table->string('name'); // e.g., "Toyota Corolla GLI"
            $table->string('brand'); // Toyota
            $table->string('model'); // Corolla
            $table->integer('year');
            $table->string('registration_number')->unique();
            $table->string('color')->nullable();

            $table->decimal('daily_rate', 10, 2);
            $table->string('city');
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // AC, GPS, etc.
            $table->json('images')->nullable();

            $table->string('status')->default('available'); // available, booked, maintenance
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });

        // Vehicle Photos
        Schema::create('vehicle_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->boolean('is_thumbnail')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tours table is created in 2025_11_26_045700_create_tours_table.php
        // Schema::create('tours', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Agent
        //     $table->string('title');
        //     $table->text('destinations'); // Comma separated or JSON
        //     $table->integer('duration_days');
        //     $table->integer('duration_nights');
        //     $table->decimal('price_per_person', 10, 2)->nullable();
        //     $table->decimal('price_per_couple', 10, 2)->nullable();
        //     $table->decimal('price_group', 10, 2)->nullable(); // Price for 5 persons
        //     $table->text('details')->nullable(); // HTML/Text details
        //     $table->string('contact_number');
        //     $table->timestamps();
        // });

        // Favorites
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Agent
            $table->morphs('favoritable'); // Vehicle or Tour (future proof)
            $table->timestamps();
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Settings (Key-Value Store)
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('favorites');
        // Schema::dropIfExists('tours');
        Schema::dropIfExists('vehicle_photos');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_types');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};

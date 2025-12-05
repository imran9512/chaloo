<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Basic", "Premium"
            $table->enum('type', ['transporter', 'agent']); // Package type
            $table->integer('listing_limit'); // Number of allowed listings
            $table->decimal('price', 10, 2); // Package price
            $table->integer('duration_days'); // Validity period in days
            $table->json('features')->nullable(); // Array of features
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

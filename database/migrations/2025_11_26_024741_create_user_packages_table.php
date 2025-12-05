<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('set null'); // Null for custom packages
            $table->boolean('is_custom')->default(false); // True for custom plans
            $table->integer('listing_limit'); // Current listing limit
            $table->decimal('price_paid', 10, 2)->default(0); // Amount paid
            $table->timestamp('started_at'); // Subscription start date
            $table->timestamp('expires_at')->nullable(); // Expiry date
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};

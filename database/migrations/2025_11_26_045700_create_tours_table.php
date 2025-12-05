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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('destinations'); // Array of {city, order, special_notes}
            $table->date('departure_date');
            $table->integer('duration_days');
            $table->decimal('price_per_person', 10, 2)->nullable();
            $table->decimal('price_per_couple', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('optional_addons')->nullable(); // {meals: {included, price}, individual_room: {price}, site_visits: [{name, price}]}
            $table->enum('status', ['available', 'booked', 'completed', 'cancelled'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};

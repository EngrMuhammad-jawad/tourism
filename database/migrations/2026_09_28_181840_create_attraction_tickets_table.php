<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attraction_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->nullable()->constrained('tour_packages')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('city')->default('Dubai')->index();
            $table->string('category')->default('observation-decks')->index();
            $table->json('title');
            $table->json('attraction_name');
            $table->json('badge')->nullable();
            $table->decimal('counter_price', 10, 2)->index();
            $table->decimal('our_price', 10, 2)->index();
            $table->string('currency', 10)->default('AED');
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('validity')->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attraction_tickets');
    }
};

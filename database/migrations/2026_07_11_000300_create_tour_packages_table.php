<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2)->index();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->unsignedSmallInteger('duration_days')->default(1)->index();
            $table->unsignedSmallInteger('duration_nights')->default(0);
            $table->unsignedSmallInteger('max_guests')->nullable();
            $table->json('included_services')->nullable();
            $table->json('excluded_services')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['destination_id', 'status']);
        });

        Schema::create('package_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number');
            $table->json('title');
            $table->json('description')->nullable();
            $table->timestamps();

            $table->unique(['tour_package_id', 'day_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_itineraries');
        Schema::dropIfExists('tour_packages');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->json('name');
            $table->unsignedTinyInteger('star_rating')->default(3)->index();
            $table->json('description')->nullable();
            $table->string('address')->nullable();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['destination_id', 'status']);
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->json('name');
            $table->decimal('price_per_night', 10, 2)->index();
            $table->unsignedTinyInteger('capacity')->default(2);
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('amenity_hotel', function (Blueprint $table) {
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();

            $table->primary(['amenity_id', 'hotel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_hotel');
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('hotels');
    }
};

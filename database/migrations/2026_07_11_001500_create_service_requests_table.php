<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('service_type'); // flights, hotels, transfer_taxi, food, city_tours, desert_safari, tickets, relocation, to_buy_property
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('service_date')->nullable();
            $table->date('return_date')->nullable();
            $table->unsignedSmallInteger('guests_count')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->json('details')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, contacted, in_progress, completed, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};

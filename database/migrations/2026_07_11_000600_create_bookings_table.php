<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A booking targets any bookable model (tour package, room or
     * transport) through a polymorphic relation, so one flow serves
     * every module.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 20)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('bookable');
            $table->date('travel_date')->index();
            $table->unsignedSmallInteger('adults')->default(1);
            $table->unsignedSmallInteger('children')->default(0);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('payment_method', 20)->default('pay_later'); // App\Enums\PaymentMethod
            $table->string('status', 20)->default('pending')->index();  // App\Enums\BookingStatus
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('method', 20); // App\Enums\PaymentMethod
            $table->string('transaction_id')->nullable();
            $table->string('status', 20)->default('pending')->index(); // App\Enums\PaymentStatus
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
    }
};

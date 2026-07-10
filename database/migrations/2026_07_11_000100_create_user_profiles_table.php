<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One-to-one extension of users: travel-document and address details
     * kept out of the users table to keep auth queries lean.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('passport_no', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
                        $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};

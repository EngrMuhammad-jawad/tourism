<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Gallery: albums hold images via the media library; videos are
     * external embeds (YouTube/Vimeo URLs) optionally grouped in albums.
     */
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();
            $table->boolean('status')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('gallery_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->json('title');
            $table->string('video_url');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_videos');
        Schema::dropIfExists('albums');
    }
};

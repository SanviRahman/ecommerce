<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_section_photos', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 80)->index();
            $table->string('title', 190)->nullable();
            $table->text('caption')->nullable();
            $table->string('link_url', 2048)->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes()->index();

            // Recommended composite index
            $table->index(['section_key', 'status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_section_photos');
    }
};
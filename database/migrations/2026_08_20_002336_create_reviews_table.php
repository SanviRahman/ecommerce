<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewer_name', 150);
            $table->string('reviewer_title', 150)->nullable();
            $table->text('review_text');
            $table->decimal('rating', 2, 1)->default(5.0); // ফ্লোটিং পয়েন্ট ও ডিফল্ট ৫
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
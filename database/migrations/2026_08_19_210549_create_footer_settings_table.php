<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('about_heading', 120)->nullable()->default('About Us');
            $table->text('about_text')->nullable();
            $table->string('navigation_heading', 120)->nullable()->default('Navigate');
            $table->string('products_heading', 120)->nullable()->default('Our Products');
            $table->string('contact_heading', 120)->nullable()->default('Our Showroom');
            $table->string('copyright_text', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
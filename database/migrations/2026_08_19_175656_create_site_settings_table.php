<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name', 190)->default('Flooring Website');
            $table->string('logo_alt', 255)->nullable();
            $table->string('contact_phone', 15)->nullable(); // লেন্থ অপ্টিমাইজ করে 15 করা হয়েছে
            $table->string('contact_email', 190)->nullable();
            $table->string('whatsapp_url', 2048)->nullable();
            $table->text('address')->nullable();
            $table->string('business_hours', 255)->nullable();
            $table->text('map_embed_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
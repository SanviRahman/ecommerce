<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED, PK
            $table->boolean('topbar_enabled')->default(true); //
            $table->string('topbar_text', 255)->nullable(); //
            $table->boolean('show_phone')->default(true); //
            $table->boolean('show_email')->default(true); //
            $table->boolean('cta_enabled')->default(false); //
            $table->string('cta_label', 80)->nullable(); //
            $table->string('cta_url', 2048)->nullable(); //
            $table->timestamps(); //
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
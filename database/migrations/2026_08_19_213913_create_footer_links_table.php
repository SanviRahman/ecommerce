<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 50)->index();
            $table->string('label', 120);
            $table->string('route_name', 150)->nullable()->index();
            $table->string('custom_url', 2048)->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('open_new_tab')->default(false);
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_links');
    }
};
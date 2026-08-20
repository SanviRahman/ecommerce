<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_pixel_scripts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('placement', 30)->default('head')->index();
            $table->longText('script_code');
            $table->char('code_hash', 64)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes()->index();

            // Unique and composite index rules
            $table->unique(['placement', 'code_hash']);
            $table->index(['status', 'placement', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_pixel_scripts');
    }
};
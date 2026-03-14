<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->index();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('store_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};

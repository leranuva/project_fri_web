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
        Schema::create('store_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Compra en todas estas tiendas');
            $table->string('subtitle')->nullable();
            $table->string('title_color')->default('#ffffff');
            $table->string('subtitle_color')->default('rgba(255, 255, 255, 0.8)');
            $table->string('footer_link')->nullable();
            $table->string('footer_link_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_sections');
    }
};

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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Título principal del slide');
            $table->string('subtitle')->nullable()->comment('Subtítulo del slide');
            $table->text('description')->nullable()->comment('Descripción del slide');
            $table->string('image')->comment('URL de la imagen del slide');
            $table->string('cta')->nullable()->comment('Texto del botón CTA');
            $table->string('cta_link')->nullable()->comment('URL del botón CTA');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->boolean('is_active')->default(true)->comment('Indica si el slide está activo');
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};

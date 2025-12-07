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
        Schema::create('alert_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Título del banner');
            $table->text('description')->comment('Descripción del banner');
            $table->text('icon_svg')->comment('Código SVG del icono');
            $table->string('button_text_auth')->nullable()->comment('Texto del botón para usuarios autenticados');
            $table->string('button_link_auth')->nullable()->comment('Enlace del botón para usuarios autenticados');
            $table->string('button_text_guest')->nullable()->comment('Texto del botón para usuarios no autenticados');
            $table->string('button_link_guest')->nullable()->comment('Enlace del botón para usuarios no autenticados');
            $table->boolean('is_active')->default(true)->comment('Indica si el banner está activo');
            $table->timestamps();
            
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_banners');
    }
};

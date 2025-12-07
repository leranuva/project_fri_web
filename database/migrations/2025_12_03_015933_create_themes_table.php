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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del tema');
            $table->string('primary_color')->default('#667eea')->comment('Color principal');
            $table->string('secondary_color')->default('#764ba2')->comment('Color secundario');
            $table->string('accent_color')->default('#f093fb')->comment('Color de acento');
            $table->string('background_gradient_start')->default('#667eea')->comment('Inicio del gradiente de fondo');
            $table->string('background_gradient_mid')->default('#764ba2')->comment('Medio del gradiente de fondo');
            $table->string('background_gradient_end')->default('#f093fb')->comment('Fin del gradiente de fondo');
            $table->string('text_color')->default('#ffffff')->comment('Color de texto principal');
            $table->string('text_secondary_color')->default('rgba(255, 255, 255, 0.8)')->comment('Color de texto secundario');
            $table->string('button_color')->default('rgba(255, 255, 255, 0.3)')->comment('Color de botones');
            $table->boolean('is_active')->default(false)->comment('Indica si el tema está activo');
            $table->timestamps();
            
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

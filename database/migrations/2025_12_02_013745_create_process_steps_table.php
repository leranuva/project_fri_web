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
        Schema::create('process_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('step_number')->comment('Número del paso (1, 2, 3, 4, etc.)');
            $table->string('title')->comment('Título del paso');
            $table->text('description')->comment('Descripción del paso');
            $table->text('icon_svg')->comment('Código SVG del icono');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->boolean('is_active')->default(true)->comment('Indica si el paso está activo');
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('order');
            $table->index('step_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_steps');
    }
};

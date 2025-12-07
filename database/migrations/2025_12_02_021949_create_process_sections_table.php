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
        Schema::create('process_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Título principal de la sección');
            $table->text('subtitle')->nullable()->comment('Subtítulo de la sección');
            $table->text('footer_text')->nullable()->comment('Texto que aparece debajo de los cards');
            $table->string('button_text')->nullable()->comment('Texto del botón debajo de los cards');
            $table->string('button_link')->nullable()->comment('Enlace del botón debajo de los cards');
            $table->boolean('is_active')->default(true)->comment('Indica si la sección está activa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_sections');
    }
};

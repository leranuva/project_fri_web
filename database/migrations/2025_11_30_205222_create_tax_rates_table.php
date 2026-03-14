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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nombre del impuesto (fodinfa, iva, seguro_cif)');
            $table->string('label')->comment('Etiqueta para mostrar (Fodinfa, IVA, Seguro CIF)');
            $table->decimal('rate', 5, 4)->comment('Tasa del impuesto (ej: 0.005 para 0.5%)');
            $table->text('description')->nullable()->comment('Descripción del impuesto');
            $table->boolean('is_active')->default(true)->comment('Indica si el impuesto está activo');
            $table->timestamps();
            
            $table->index('name');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
};

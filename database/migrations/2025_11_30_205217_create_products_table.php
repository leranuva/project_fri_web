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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Clave única del producto (ej: Laptos, Tablets)');
            $table->string('name')->comment('Nombre formateado para mostrar');
            $table->decimal('ad_valorem', 5, 4)->comment('Impuesto ad-valorem (ej: 0.30 para 30%)');
            $table->decimal('arancel_especifico', 10, 2)->default(0)->comment('Arancel específico en USD');
            $table->decimal('new_percent', 5, 4)->nullable()->comment('Porcentaje adicional (opcional, para algunos productos)');
            $table->text('description')->nullable()->comment('Descripción del producto');
            $table->string('category')->nullable()->comment('Categoría del producto');
            $table->boolean('is_active')->default(true)->comment('Indica si el producto está activo');
            $table->integer('sort_order')->default(0)->comment('Orden de visualización');
            $table->timestamps();
            
            $table->index('key');
            $table->index('is_active');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

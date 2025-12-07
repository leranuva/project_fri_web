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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('method')->comment('Método de envío: maritimo, aereo, aereoExpres');
            $table->decimal('min_weight', 10, 2)->comment('Peso mínimo en libras');
            $table->decimal('max_weight', 10, 2)->nullable()->comment('Peso máximo en libras (null = sin límite)');
            $table->decimal('cost_per_pound', 10, 2)->comment('Costo por libra en USD');
            $table->boolean('is_special_case')->default(false)->comment('Indica si es caso especial (ej: aereo peso 1)');
            $table->text('notes')->nullable()->comment('Notas adicionales sobre la tarifa');
            $table->integer('sort_order')->default(0)->comment('Orden de evaluación');
            $table->boolean('is_active')->default(true)->comment('Indica si la tarifa está activa');
            $table->timestamps();
            
            $table->index(['method', 'min_weight', 'max_weight']);
            $table->index('method');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};

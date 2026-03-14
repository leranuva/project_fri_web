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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_key')->comment('Clave del producto para referencia');
            $table->decimal('weight', 10, 2)->comment('Peso total en libras');
            $table->decimal('fob', 12, 2)->comment('Valor FOB en USD');
            $table->unsignedInteger('quantity')->default(1);
            $table->string('shipping_method')->comment('Método de envío');
            $table->decimal('total', 12, 2)->comment('Total cotización en USD');
            $table->json('details')->nullable()->comment('Desglose completo de la cotización');
            $table->timestamps();

            $table->index('user_id');
            $table->index('product_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

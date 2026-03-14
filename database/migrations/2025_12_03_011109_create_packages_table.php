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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('tracking_number')->unique()->comment('Número de tracking o guía');
            $table->string('carrier')->nullable()->comment('Transportista (USPS, FedEx, UPS, DHL, etc.)');
            $table->string('status')->default('pending')->comment('Estado del paquete: pending, in_transit, received, in_customs, delivered, etc.');
            $table->string('origin')->nullable()->comment('Origen del paquete');
            $table->string('destination')->nullable()->comment('Destino del paquete');
            $table->text('description')->nullable()->comment('Descripción del paquete');
            $table->decimal('weight', 10, 2)->nullable()->comment('Peso en libras');
            $table->decimal('value', 10, 2)->nullable()->comment('Valor declarado en USD');
            $table->date('shipped_date')->nullable()->comment('Fecha de envío');
            $table->date('estimated_delivery')->nullable()->comment('Fecha estimada de entrega');
            $table->date('delivered_date')->nullable()->comment('Fecha de entrega');
            $table->json('tracking_history')->nullable()->comment('Historial de tracking');
            $table->text('notes')->nullable()->comment('Notas adicionales');
            $table->timestamps();
            
            $table->index('tracking_number');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

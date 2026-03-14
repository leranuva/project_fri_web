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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('producto')->nullable();
            $table->decimal('valor', 12, 2)->nullable();
            $table->string('pais', 50)->nullable();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('quote_count')->default(1);
            $table->string('source')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

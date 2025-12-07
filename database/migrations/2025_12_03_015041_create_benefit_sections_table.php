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
        Schema::create('benefit_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Título principal de la sección');
            $table->boolean('is_active')->default(true)->comment('Indica si la sección está activa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_sections');
    }
};

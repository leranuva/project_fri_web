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
        Schema::table('cotizador_sections', function (Blueprint $table) {
            $table->boolean('store_button_animated')->default(true)->after('store_button_visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizador_sections', function (Blueprint $table) {
            $table->dropColumn('store_button_animated');
        });
    }
};

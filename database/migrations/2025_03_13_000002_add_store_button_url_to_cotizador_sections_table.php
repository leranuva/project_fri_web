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
            $table->string('store_button_url_base', 500)->nullable()->after('store_button_text_color');
            $table->string('store_button_url_path', 255)->nullable()->after('store_button_url_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizador_sections', function (Blueprint $table) {
            $table->dropColumn(['store_button_url_base', 'store_button_url_path']);
        });
    }
};

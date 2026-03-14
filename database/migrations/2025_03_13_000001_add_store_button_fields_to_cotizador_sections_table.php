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
            $table->string('store_button_text')->default('Comprar este producto en la tienda')->after('shipping_method_label_color');
            $table->boolean('store_button_visible')->default(true)->after('store_button_text');
            $table->string('store_button_bg_color')->default('rgba(34, 197, 94, 0.2)')->after('store_button_visible');
            $table->string('store_button_border_color')->default('rgba(34, 197, 94, 0.4)')->after('store_button_bg_color');
            $table->string('store_button_text_color')->default('#86efac')->after('store_button_border_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizador_sections', function (Blueprint $table) {
            $table->dropColumn([
                'store_button_text',
                'store_button_visible',
                'store_button_bg_color',
                'store_button_border_color',
                'store_button_text_color',
            ]);
        });
    }
};

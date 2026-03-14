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
            $table->string('title_color')->default('#ffffff')->after('description');
            $table->string('section_title_color')->default('#ffffff')->after('title_color');
            $table->string('product_label_color')->default('#ffffff')->after('section_title_color');
            $table->string('quantity_label_color')->default('#ffffff')->after('product_label_color');
            $table->string('weight_label_color')->default('#ffffff')->after('quantity_label_color');
            $table->string('unit_value_label_color')->default('#ffffff')->after('weight_label_color');
            $table->string('shipping_method_label_color')->default('#ffffff')->after('unit_value_label_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizador_sections', function (Blueprint $table) {
            $table->dropColumn([
                'title_color',
                'section_title_color',
                'product_label_color',
                'quantity_label_color',
                'weight_label_color',
                'unit_value_label_color',
                'shipping_method_label_color',
            ]);
        });
    }
};

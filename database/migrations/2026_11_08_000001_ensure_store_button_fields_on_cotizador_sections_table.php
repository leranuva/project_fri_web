<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fresh installs reach the original store-button migrations before the table exists.
        $columns = array_flip(Schema::getColumnListing('cotizador_sections'));

        Schema::table('cotizador_sections', function (Blueprint $table) use ($columns) {
            if (! isset($columns['store_button_text'])) {
                $table->string('store_button_text')->default('Comprar este producto en la tienda');
            }

            if (! isset($columns['store_button_visible'])) {
                $table->boolean('store_button_visible')->default(true);
            }

            if (! isset($columns['store_button_bg_color'])) {
                $table->string('store_button_bg_color')->default('rgba(34, 197, 94, 0.2)');
            }

            if (! isset($columns['store_button_border_color'])) {
                $table->string('store_button_border_color')->default('rgba(34, 197, 94, 0.4)');
            }

            if (! isset($columns['store_button_text_color'])) {
                $table->string('store_button_text_color')->default('#86efac');
            }

            if (! isset($columns['store_button_url_base'])) {
                $table->string('store_button_url_base', 500)->nullable();
            }

            if (! isset($columns['store_button_url_path'])) {
                $table->string('store_button_url_path', 255)->nullable();
            }

            if (! isset($columns['store_button_animated'])) {
                $table->boolean('store_button_animated')->default(true);
            }
        });
    }

    public function down(): void
    {
        // The original migrations own these columns on existing installations.
        // On a fresh install, rolling back the table creation removes them.
    }
};

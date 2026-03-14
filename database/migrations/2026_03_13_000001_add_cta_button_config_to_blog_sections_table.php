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
        Schema::table('blog_sections', function (Blueprint $table) {
            $table->string('cta_button_text')->default('Ir a la tienda')->after('button_link');
            $table->boolean('cta_button_visible')->default(true)->after('cta_button_text');
            $table->boolean('cta_button_animated')->default(true)->after('cta_button_visible');
            $table->string('cta_button_bg_color')->default('rgba(34, 197, 94, 0.2)')->after('cta_button_animated');
            $table->string('cta_button_border_color')->default('rgba(34, 197, 94, 0.4)')->after('cta_button_bg_color');
            $table->string('cta_button_text_color')->default('#86efac')->after('cta_button_border_color');
            $table->string('cta_button_url_base')->nullable()->after('cta_button_text_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_sections', function (Blueprint $table) {
            $table->dropColumn([
                'cta_button_text',
                'cta_button_visible',
                'cta_button_animated',
                'cta_button_bg_color',
                'cta_button_border_color',
                'cta_button_text_color',
                'cta_button_url_base',
            ]);
        });
    }
};

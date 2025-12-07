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
        Schema::table('alert_banners', function (Blueprint $table) {
            $table->string('background_color')->default('transparent')->after('description')->comment('Color de fondo del banner');
            $table->string('title_color')->default('#FFFFFF')->after('background_color')->comment('Color del título');
            $table->string('description_color')->default('#FFFFFF')->after('title_color')->comment('Color de la descripción');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert_banners', function (Blueprint $table) {
            $table->dropColumn(['background_color', 'title_color', 'description_color']);
        });
    }
};

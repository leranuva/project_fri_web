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
            $table->string('container_color')->default('rgba(255, 255, 255, 0.15)')->after('description_color')->comment('Color del contenedor/card del banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alert_banners', function (Blueprint $table) {
            $table->dropColumn('container_color');
        });
    }
};

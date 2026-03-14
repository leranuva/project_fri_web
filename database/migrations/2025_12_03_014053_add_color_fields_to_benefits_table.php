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
        Schema::table('benefits', function (Blueprint $table) {
            $table->string('title_color')->default('#ffffff')->after('title')->comment('Color del título en formato hexadecimal');
            $table->string('description_color')->default('#ffffff')->after('description')->comment('Color de la descripción en formato hexadecimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benefits', function (Blueprint $table) {
            $table->dropColumn(['title_color', 'description_color']);
        });
    }
};

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
        // Primero eliminar duplicados si existen
        $duplicates = \DB::table('benefits')
            ->select('title', \DB::raw('MIN(id) as keep_id'))
            ->groupBy('title')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        
        foreach ($duplicates as $duplicate) {
            \DB::table('benefits')
                ->where('title', $duplicate->title)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }
        
        // Agregar restricción única
        Schema::table('benefits', function (Blueprint $table) {
            $table->unique('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('benefits', function (Blueprint $table) {
            $table->dropUnique(['title']);
        });
    }
};

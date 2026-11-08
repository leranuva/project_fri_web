<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dateTime('published_at', 6)->nullable();
        });

        $activeId = DB::table('themes')->where('is_active', true)->orderBy('id')->value('id');
        if ($activeId !== null) {
            DB::table('themes')->where('id', $activeId)->update(['published_at' => now()]);
            DB::table('themes')->where('id', '!=', $activeId)->where('is_active', true)->update(['is_active' => false]);
        }
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
};

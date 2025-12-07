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
        Schema::table('products', function (Blueprint $table) {
            $table->string('arancel_code', 20)->nullable()->after('key')->comment('Código arancelario NANDINA (ej: 8517.12.00)');
            $table->string('arancel_subpartida', 50)->nullable()->after('arancel_code')->comment('Subpartida arancelaria completa');
            $table->index('arancel_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['arancel_code']);
            $table->dropColumn(['arancel_code', 'arancel_subpartida']);
        });
    }
};

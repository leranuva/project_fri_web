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
            $table->text('subtitle')->nullable()->after('title')->comment('Subtítulo de la sección');
            $table->text('footer_text')->nullable()->after('title_color')->comment('Texto que aparece debajo de los cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_sections', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'footer_text']);
        });
    }
};

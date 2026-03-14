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
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('cta_text')->nullable()->after('link');
            $table->string('cta_link')->nullable()->after('cta_text');
            $table->boolean('cta_active')->default(true)->after('cta_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['cta_text', 'cta_link', 'cta_active']);
        });
    }
};

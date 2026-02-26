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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('cta_title')->nullable()->after('partner_show');
            $table->string('cta_sub_title')->nullable()->after('cta_title');
            $table->longText('footer_text_one')->nullable()->after('cta_sub_title');
            $table->longText('footer_text_two')->nullable()->after('footer_text_one');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['cta_title', 'cta_sub_title', 'footer_text_one', 'footer_text_two']);
        });
    }
};

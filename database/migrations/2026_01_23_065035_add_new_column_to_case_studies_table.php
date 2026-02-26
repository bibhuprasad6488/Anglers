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
        Schema::table('case_studies', function (Blueprint $table) {
            $table->bigInteger('topic_id')->after('id')->nullable();
            $table->integer('read_time')->after('long_desc')->default(0);
            $table->bigInteger('user_id')->after('topic_id')->default(1);
            $table->integer('views')->after('read_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropColumn(['topic_id', 'read_time', 'user_id', 'views']);
        });
    }
};

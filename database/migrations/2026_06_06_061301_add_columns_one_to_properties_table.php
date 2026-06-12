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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('slug');
            $table->string('price_per_pet')->default(0)->after('price_per_month');
            $table->string('minimum_diposit')->default(0)->after('price_per_pet');
            $table->string('number_of_bed')->default('N/A')->after('minimum_diposit');
            $table->string('max_adult')->default(0)->after('number_of_bed');
            $table->string('max_child')->default(0)->after('max_adult');
            $table->string('max_pet')->default(2)->after('max_child');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'thumbnail',
                'price_per_pet',
                'minimum_diposit',
                'number_of_bed',
                'max_adult',
                'max_child',
                'max_pet'
            ]);
        });
    }
};

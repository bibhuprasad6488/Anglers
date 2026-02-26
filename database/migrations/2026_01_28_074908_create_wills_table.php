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
        Schema::create('wills', function (Blueprint $table) {
            $table->id();
            $table->string('will_unique_id')->nullable();
            $table->longText('setup');
            $table->string('full_name');
            $table->string('email');
            $table->string('postcode');
            $table->string('confirm_england');
            $table->string('confirm_self');
            $table->string('confirm_no_advice');
            $table->string('confirm_free_will');
            $table->longText('assets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wills');
    }
};

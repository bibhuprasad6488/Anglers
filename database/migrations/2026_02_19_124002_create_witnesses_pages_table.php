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
        Schema::create('witnesses_pages', function (Blueprint $table) {
            $table->id();
            $table->longText('w_title')->nullable();
            $table->longText('w_desc_one')->nullable();
            $table->longText('w_desc_two')->nullable();
            $table->longText('w_desc_three')->nullable();
            $table->string('w_img')->nullable();
            $table->enum('show_on_page', [1, 0])->default(1);
            $table->text('meta_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->longText('meta_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witnesses_pages');
    }
};

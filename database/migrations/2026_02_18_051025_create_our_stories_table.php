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
        Schema::create('our_stories', function (Blueprint $table) {
            $table->id();
            $table->longText('story_desc_one')->nullable();
            $table->string('ap_title_one')->nullable();
            $table->text('ap_desc_one')->nullable();
            $table->string('ap_title_two')->nullable();
            $table->text('ap_desc_two')->nullable();
            $table->string('ap_title_three')->nullable();
            $table->text('ap_desc_three')->nullable();
            $table->longText('story_desc_two')->nullable();
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
        Schema::dropIfExists('our_stories');
    }
};

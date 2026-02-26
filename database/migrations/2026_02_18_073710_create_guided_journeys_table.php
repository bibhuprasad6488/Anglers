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
        Schema::create('guided_journeys', function (Blueprint $table) {
            $table->id();

            $table->longText('journey_desc')->nullable();

            $table->string('step_title')->nullable();
            $table->string('step_sub_title')->nullable();

            $table->string('step_title_one')->nullable();
            $table->string('step_sub_title_one')->nullable();
            $table->longText('step_desc_one')->nullable();
            $table->string('step_img_one')->nullable();

            $table->string('step_title_two')->nullable();
            $table->string('step_sub_title_two')->nullable();
            $table->longText('step_desc_two')->nullable();
            $table->string('step_img_two')->nullable();

            $table->string('step_title_three')->nullable();
            $table->string('step_sub_title_three')->nullable();
            $table->longText('step_desc_three')->nullable();
            $table->string('step_img_three')->nullable();

            $table->string('step_title_four')->nullable();
            $table->string('step_sub_title_four')->nullable();
            $table->longText('step_desc_four')->nullable();
            $table->string('step_img_four')->nullable();

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
        Schema::dropIfExists('guided_journeys');
    }
};

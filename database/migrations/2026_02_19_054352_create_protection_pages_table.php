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
        Schema::create('protection_pages', function (Blueprint $table) {
            $table->id();
            $table->longText('p_desc')->nullable();
            $table->string('p_image')->nullable();

            $table->string('ps_title_one')->nullable();
            $table->longText('ps_desc_one')->nullable();
            $table->string('ps_img_one')->nullable();

            $table->string('ps_title_two')->nullable();
            $table->longText('ps_desc_two')->nullable();
            $table->string('ps_img_two')->nullable();

            $table->string('ps_title_three')->nullable();
            $table->longText('ps_desc_three')->nullable();
            $table->string('ps_img_three')->nullable();

            $table->string('ps_title_four')->nullable();
            $table->longText('ps_desc_four')->nullable();
            $table->string('ps_img_four')->nullable();

            $table->longText('pp_desc_one')->nullable();
            $table->longText('pp_desc_two')->nullable();
            $table->string('pp_img')->nullable();

            $table->string('pw_title_one')->nullable();
            $table->string('pw_img_one')->nullable();

            $table->string('pw_title_two')->nullable();
            $table->string('pw_img_two')->nullable();

            $table->string('pw_title_three')->nullable();
            $table->string('pw_img_three')->nullable();

            $table->string('pw_title_four')->nullable();
            $table->string('pw_img_four')->nullable();

            $table->string('pcta_title')->nullable();
            $table->string('pcta_btn_text')->nullable();
            $table->string('pcta_btn_link')->nullable();

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
        Schema::dropIfExists('protection_pages');
    }
};

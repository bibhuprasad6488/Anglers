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
        Schema::create('cms_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('setion_one_title')->nullable();
            $table->longText('setion_one_desc')->nullable();
            $table->string('setion_one_img')->nullable();
            $table->longText('setion_two_title')->nullable();
            $table->longText('setion_two_desc')->nullable();
            $table->string('setion_two_img')->nullable();
            $table->string('resource_title')->nullable();
            $table->longText('resource_desc')->nullable();
            $table->string('resource_btn_one_text')->nullable();
            $table->string('resource_btn_one_link')->nullable();
            $table->string('resource_btn_two_text')->nullable();
            $table->string('resource_btn_two_link')->nullable();
            $table->string('resource_btn_three_text')->nullable();
            $table->string('resource_btn_three_link')->nullable();
            $table->string('meta_title')->nullable();
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
        Schema::dropIfExists('cms_resources');
    }
};

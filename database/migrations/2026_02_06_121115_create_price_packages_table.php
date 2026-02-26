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
        Schema::create('price_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cat_id')->nullable();
            $table->string('package_title')->nullable();
            $table->longText('package_text')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', [1, 0])->default(1)->comment('1=Acrive,0=Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_packages');
    }
};

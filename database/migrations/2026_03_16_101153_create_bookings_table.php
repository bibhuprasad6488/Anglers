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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->bigInteger('property_id');
            $table->bigInteger('category_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_nights');
            $table->decimal('booking_amount', 10, 2);
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->text('user_address')->nullable();
            $table->string('number_of_child')->default(0);
            $table->string('number_of_adult')->default(0);
            $table->string('status')->default('locked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

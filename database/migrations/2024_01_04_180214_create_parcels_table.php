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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('sender_name');
            $table->string('recepient');
            $table->string('recepient_email');
            $table->string('recepient_phone');
            $table->string('recepient_address');
            $table->string('recepient_country');
            $table->string('parcel_description');
            $table->string('logitsic_type');
            $table->string('weight');
            $table->string('location');
            $table->enum('status', ['pending','proccessing', 'delivered', 'cancelled', 'onhold', 'ontransit'])->default('pending');
            $table->string('total_days');
            $table->string('deputuer_day');
            $table->string('arrival_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};

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
        Schema::create('rooms_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('rooms_number')->nullable();

            $table->unsignedBigInteger('rooms_type_id')->nullable();
            $table->foreign('rooms_type_id')->references('id')->on('rooms_types');
            
            $table->unsignedBigInteger('acommodation_type_id')->nullable();
            $table->foreign('acommodation_type_id')->references('id')->on('acommodation_types');
            
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->foreign('hotel_id')->references('id')->on('hotels');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_configurations');
    }
};

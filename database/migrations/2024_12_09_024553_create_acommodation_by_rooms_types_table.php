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
        Schema::create('acommodation_by_rooms_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('room_type_id');
            $table->foreign('room_type_id')->references('id')->on('rooms_types');
            
            $table->unsignedBigInteger('acommodation_type_id');
            $table->foreign('acommodation_type_id')->references('id')->on('acommodation_types');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acommodation_by_rooms_types');
    }
};

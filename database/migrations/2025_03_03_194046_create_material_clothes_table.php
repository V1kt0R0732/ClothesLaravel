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
        Schema::create('material_clothes', function (Blueprint $table) {
            $table->id('material_cloth_id');
            $table->bigInteger('material_id')->unsigned();
            $table->bigInteger('cloth_id')->unsigned();

            $table->foreign('material_id')->references('material_id')->on('materials');
            $table->foreign('cloth_id')->references('cloth_id')->on('clothes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_clothes');
    }
};

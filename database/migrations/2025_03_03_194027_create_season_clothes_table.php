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
        Schema::create('season_clothes', function (Blueprint $table) {
            $table->id('season_cloth_id');
            $table->bigInteger('season_id')->unsigned();
            $table->bigInteger('cloth_id')->unsigned();

            $table->foreign('season_id')->references('season_id')->on('seasons');
            $table->foreign('cloth_id')->references('cloth_id')->on('clothes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_clothes');
    }
};

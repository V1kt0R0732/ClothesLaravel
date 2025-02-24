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
        Schema::create('storages', function (Blueprint $table) {
            $table->id('storage_id');
            $table->bigInteger('clothes_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('size_id')->unsigned();
            $table->integer('count');
            $table->timestamps();

            $table->foreign('clothes_id')->references('cloth_id')->on('clothes');
            $table->foreign('color_id')->references('color_id')->on('colors');
            $table->foreign('size_id')->references('size_id')->on('sizes');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storages');
    }
};

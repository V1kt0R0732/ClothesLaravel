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
        Schema::create('storage_clothes', function (Blueprint $table) {
            $table->id('storage_cloth_id');
            $table->bigInteger('cloth_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('size_id')->unsigned();
            $table->bigInteger('body_shape_id')->unsigned();
            $table->integer('count');
            $table->timestamps();

            $table->foreign('cloth_id')->references('cloth_id')->on('clothes');
            $table->foreign('color_id')->references('color_id')->on('colors');
            $table->foreign('size_id')->references('size_id')->on('sizes');
            $table->foreign('body_shape_id')->references('body_shape_id')->on('body_shapes');

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

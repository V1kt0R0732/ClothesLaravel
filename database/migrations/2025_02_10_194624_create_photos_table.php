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
        Schema::create('photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->string('photo_name')->default('images/noPhoto.png');
            $table->bigInteger('storage_cloth_id')->unsigned();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('storage_cloth_id')->references('storage_cloth_id')->on('storage_clothes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};

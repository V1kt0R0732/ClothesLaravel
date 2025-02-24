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
        Schema::create('properties', function (Blueprint $table) {
            $table->id('property_id');
            $table->string('property_name');
            $table->string('property_value');
            $table->bigInteger('id_cloth')->unsigned();

            $table->timestamps();

            $table->foreign('id_cloth')->references('cloth_id')->on('clothes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

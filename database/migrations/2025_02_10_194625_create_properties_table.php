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
            $table->bigInteger('cloth_id')->unsigned();

            $table->timestamps();

            $table->foreign('cloth_id')->references('cloth_id')->on('clothes');
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

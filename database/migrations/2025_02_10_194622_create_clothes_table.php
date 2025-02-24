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
        Schema::create('clothes', function (Blueprint $table) {
            $table->id('cloth_id');
            $table->string('cloth_name');
            $table->float('price');
            $table->bigInteger('id_material')->unsigned();
            $table->bigInteger('cat_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('season_id')->unsigned();
            $table->text('description');
            $table->timestamps();

            $table->foreign('id_material')->references('material_id')->on('materials');
            $table->foreign('cat_id')->references('category_id')->on('categories');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers');
            $table->foreign('season_id')->references('season_id')->on('seasons');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothes');
    }
};

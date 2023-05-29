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
        Schema::create('stays', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('owner');
          $table->foreign('owner')->references('id')->on('users');
          $table->string('title');
          $table->text('description');
          $table->integer('capacity');
          $table->integer('bedrooms');
          $table->float('price');
          $table->string('country');
          $table->string('city');
          $table->double('lat', 16, 14)->nullable();
          $table->double('lon', 17, 14)->nullable();
          $table->boolean('beingUsed');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stays');
    }
};

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
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->string('country')->nullable();
      $table->string('image')->nullable();
      $table->date('start')->nullable();
      $table->date('end')->nullable();
      $table->integer('headcount')->nullable();
      $table->integer('adults')->nullable();
      $table->integer('children')->nullable();
      $table->float('cost')->default(0);
      $table->boolean('closed')->default(false);
      $table->unsignedBigInteger('owner');
      $table->foreign('owner')->references('id')->on('users');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('projects');
  }
};

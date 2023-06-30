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
    Schema::create('reports', function (Blueprint $table) {
      $table->id();
      $table->enum('type', ['stay', 'review']);
      $table->unsignedBigInteger('user');
      $table->foreign('user')->references('id')->on('users')->onDelete('no action');
      $table->unsignedBigInteger('review')->nullable();
      $table->foreign('review')->references('id')->on('stay_reviews')->onDelete('no action');
      $table->date('date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('reports');
  }
};

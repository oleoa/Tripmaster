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
    Schema::create('stays_views', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user');
      $table->foreign('user')->references('id')->on('users')->onDelete('no action');
      $table->unsignedBigInteger('stay');
      $table->foreign('stay')->references('id')->on('stays')->onDelete('no action');
      $table->dateTime('time');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('stays_views');
  }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creating rents table.
 * It is useful to save all the rents that a user has made.
 * And it is useful to save all the rents that a stay has.
 * It also keeps the stay rented until the deadend date.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('rents', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project');
        $table->foreign('project')->references('id')->on('projects')->onDelete('cascade');
        $table->unsignedBigInteger('stay');
        $table->foreign('stay')->references('id')->on('stays')->onDelete('cascade');
        $table->unsignedBigInteger('user');
        $table->foreign('user')->references('id')->on('users')->onDelete('no action');
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('headcount');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};

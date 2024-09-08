<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('off_days', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('type'); // e.g., public holiday, weekend
            $table->string('description')->nullable();
            $table->boolean('weekend')->default(false);
            $table->string('day')->nullable(); // e.g., Saturday, Sunday
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('off_days');
    }
};

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
        Schema::create('privileges', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->string('operation'); // Create, Read, Update, Delete
            $table->unsignedBigInteger('group_type_id'); // FK to group_type
            $table->timestamps();

            $table->foreign('group_type_id')->references('id')->on('group_types')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privileges');
    }
};

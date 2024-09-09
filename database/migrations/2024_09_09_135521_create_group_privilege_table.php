<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_privilege', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_type_id');
            $table->unsignedBigInteger('privileges_id');

            // Foreign keys
            $table->foreign('group_type_id')->references('id')->on('group_types')->onDelete('cascade');
            $table->foreign('privileges_id')->references('id')->on('privileges')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_privilege');
    }
};

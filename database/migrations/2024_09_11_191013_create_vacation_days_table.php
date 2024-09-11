<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationDaysTable extends Migration
{
    public function up()
    {
        Schema::create('vacation_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('off_day_id');
            $table->date('vacation_date');
            $table->timestamps();


            $table->foreign('off_day_id')->references('id')->on('off_days')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_days');
    }
}

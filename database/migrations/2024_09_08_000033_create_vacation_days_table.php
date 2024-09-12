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
            $table->enum('weekend_day',['sunday','monday','tuesday','wednesday','thursday','friday','saturday']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_days');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SplitOffDaysTable extends Migration
{
    public function up()
    {

        Schema::table('off_days', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('weekend');
            $table->dropColumn('day');
        });


        Schema::create('off_day_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('off_day_off_day_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('off_day_id');
            $table->unsignedBigInteger('off_day_type_id');
            $table->timestamps();


            $table->foreign('off_day_id')->references('id')->on('off_days')->onDelete('cascade');
            $table->foreign('off_day_type_id')->references('id')->on('off_day_types')->onDelete('cascade');
        });
    }

    public function down()
    {



        Schema::dropIfExists('off_day_off_day_type');


        Schema::dropIfExists('off_day_types');



        Schema::table('off_days', function (Blueprint $table) {
            $table->string('type');
            $table->boolean('weekend')->default(false);
            $table->string('day')->nullable();
        });
    }
}

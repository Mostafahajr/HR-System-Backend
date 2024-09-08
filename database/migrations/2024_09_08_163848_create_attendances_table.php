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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->dateTime('attendance_time');
        $table->dateTime('arrival_time');
        $table->dateTime('leave_time');
        $table->date('date');
        $table->unsignedBigInteger('employee_id'); // FK to employee
        $table->timestamps();

        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('phone_number');
        $table->string('gender');
        $table->date('DOB');
        $table->string('nationality');
        $table->decimal('salary', 10, 2);
        $table->date('date_of_contract');
        $table->unsignedBigInteger('department_id')->nullable(); // FK for Department
        $table->timestamps();

        // Foreign Key Constraint
        $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

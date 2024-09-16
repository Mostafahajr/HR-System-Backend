<?php

use App\Models\Department;
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
            // address can be optimized later
            $table->string('address');
            $table->string('phone_number');
            $table->enum('gender', ['male', 'female']);
            $table->date('DOB');
            $table->string('nationality');
            $table->integer('national_id')->unique();
            $table->time('arrival_time'); // Changed from dateTime to time
            $table->time('leave_time');   // Changed from dateTime to time
            $table->decimal('salary', 10, 2);
            $table->date('date_of_contract');
            $table->foreignIdFor(Department::class)->nullable();
            $table->timestamps();
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

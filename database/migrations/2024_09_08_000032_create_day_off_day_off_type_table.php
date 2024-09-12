<?php

use App\Models\OffDay;
use App\Models\OffDayType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('off_day_off_day_type', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OffDay::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(OffDayType::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_off_day_off_type');
    }
};

<?php

use App\Models\GroupType;
use App\Models\Privilege;
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
            $table->foreignIdFor(GroupType::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Privilege::class)->constrained()->onDelete('cascade');
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

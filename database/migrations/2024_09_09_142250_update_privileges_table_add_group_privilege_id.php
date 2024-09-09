<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePrivilegesTableAddGroupPrivilegeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('privileges', function (Blueprint $table) {
            $table->unsignedBigInteger('group_privilege_id')->after('group_type_id');

            $table->foreign('group_privilege_id')
                  ->references('id')
                  ->on('group_privilege')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('privileges', function (Blueprint $table) {
            $table->dropForeign(['group_privilege_id']);
            $table->dropColumn('group_privilege_id');
        });
    }
}

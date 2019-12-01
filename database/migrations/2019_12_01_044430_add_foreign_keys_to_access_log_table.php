<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToAccessLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_log', function (Blueprint $table) {
            $table->foreign('user_id', 'FK_activities_users_1')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_log', function (Blueprint $table) {
            $table->dropForeign('FK_activities_users_1');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToSmsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_events', function (Blueprint $table) {
            $table->foreign('created_by', 'FK_sms_events_users_1')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_sms_events_users_2')
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
        Schema::table('sms_events', function (Blueprint $table) {
            $table->dropForeign('FK_sms_events_users_1');
            $table->dropForeign('FK_sms_events_users_2');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('message', 500);
            $table->string('description', 140);
            $table->dateTime('date');
            $table->boolean('status');
            $table->integer('send_to')->comment('0 = active memeber, 1 = inactive member, 2 = lead enquiries, 3 = lost enquiries');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('FK_sms_events_users_1');
            $table->integer('updated_by')->unsigned()->index('FK_sms_events_users_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_events');
    }
}

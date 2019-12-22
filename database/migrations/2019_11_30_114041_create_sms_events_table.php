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
            $table->integer('id', true);
            $table->string('name', 50);
            $table->string('message', 500);
            $table->string('description', 140);
            $table->dateTime('date');
            $table->boolean('status')->comment('0 = active memeber, 1 = inactive member, 2 = lead enquiries, 3 = lost enquiries');;
            $table->string('send_to');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('sms_events_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('sms_events_updated_by_foreign');
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

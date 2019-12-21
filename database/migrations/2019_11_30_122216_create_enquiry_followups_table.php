<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiryFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_followups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enquiry_id')->unsigned()->index('enquiry_followups_enquiry_id_foreign');
            $table->string('followup_by', 50);
            $table->date('due_date');
            $table->string('outcome', 50);
            $table->boolean('status')->comment('0 - pending, 1- done');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('enquiry_followups_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('enquiry_followups_updated_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enquiry_followups');
    }
}

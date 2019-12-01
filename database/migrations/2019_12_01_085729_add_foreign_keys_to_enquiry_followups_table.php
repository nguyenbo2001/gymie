<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToEnquiryFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiry_followups', function (Blueprint $table) {
            $table->foreign('enquiry_id', 'FK_enquiry_followups_enquiries_1')
                    ->references('id')->on('enquiries')
                    ->onUpdate("RESTRICT")->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_enquiry_followups_staff_2')
                    ->references('id')->on('users')
                    ->onUpdate("RESTRICT")->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_enquiry_followups_staff_3')
                    ->references('id')->on('users')
                    ->onUpdate("RESTRICT")->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiry_followups', function (Blueprint $table) {
            $table->dropForeign('FK_enquiry_followups_enquiries_1');
            $table->dropForeign('FK_enquiry_followups_staff_2');
            $table->dropForeign('FK_enquiry_followups_staff_3');
        });
    }
}

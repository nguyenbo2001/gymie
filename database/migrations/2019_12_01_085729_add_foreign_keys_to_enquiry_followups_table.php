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
            $table->foreign('enquiry_id')
                    ->references('id')->on('enquiries')
                    ->onUpdate("RESTRICT")->onDelete('RESTRICT');
            $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->onUpdate("RESTRICT")->onDelete('RESTRICT');
            $table->foreign('updated_by')
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
            $table->dropForeign('enquiry_followups_enquiry_id_foreign');
            $table->dropForeign('enquiry_followups_created_by_foreign');
            $table->dropForeign('enquiry_followups_updated_by_foreign');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_details', function (Blueprint $table) {
            $table->foreign('invoice_id', 'FK_payment_details_1')
                    ->references('id')->on('invoice')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_payment_details_staff_2')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_payment_details_staff_3')
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
        Schema::table('payment_details', function (Blueprint $table) {
            $table->dropForeign('FK_payment_details_1');
            $table->dropForeign('FK_payment_details_staff_2');
            $table->dropForeign('FK_payment_details_staff_3');
        });
    }
}

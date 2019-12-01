<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToChequeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheque_details', function (Blueprint $table) {
            $table->foreign('created_by', 'FK_cheque_details_users')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_cheque_details_users_2')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('payment_id', 'FK_cheque_details_payment_details')
                    ->references('id')->on('payment_details')
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
        Schema::table('cheque_details', function (Blueprint $table) {
            $table->dropForeign('FK_cheque_details_users');
            $table->dropForeign('FK_cheque_details_users_2');
            $table->dropForeign('FK_cheque_details_payment_details');
        });
    }
}

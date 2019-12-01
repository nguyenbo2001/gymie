<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice', function (Blueprint $table) {
            $table->foreign('member_id', 'FK_invoice_members_1')
                    ->references('id')->on('members')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_invoice_staff_1')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_invoice_staff_2')
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
        Schema::table('invoice', function (Blueprint $table) {
            $table->dropForeign('FK_invoice_members_1');
            $table->dropForeign('FK_invoice_staff_1');
            $table->dropForeign('FK_invoice_staff_2');
        });
    }
}

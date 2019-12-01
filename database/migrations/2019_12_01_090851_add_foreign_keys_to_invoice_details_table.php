<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->foreign('created_by', 'FK_invoice_details_staff_2')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_invoice_details_staff_3')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id', 'FK_invoice_details_invoice_1')
                    ->references('id')->on('invoice')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id')
                    ->references('id')->on('plans')
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
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropForeign('FK_invoice_details_staff_2');
            $table->dropForeign('FK_invoice_details_staff_3');
            $table->dropForeign('FK_invoice_details_invoice_1');
            $table->dropForeign('FK_invoice_details_plan_id_foreign');
        });
    }
}

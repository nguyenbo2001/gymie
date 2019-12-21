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
            $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id')
                    ->references('id')->on('invoices')
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
            $table->dropForeign('invoice_details_created_by_foreign');
            $table->dropForeign('invoice_details_updated_by_foreign');
            $table->dropForeign('invoice_details_invoice_id_foreign');
            $table->dropForeign('invoice_details_plan_id_foreign');
        });
    }
}

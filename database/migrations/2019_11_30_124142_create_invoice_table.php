<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Unique record id for system');
            $table->integer('member_id')->index('FK_invoice_members_1')->comment('link to unique record id of member');
            $table->integer('total')->comment('total fees/amount generated');
            $table->integer('pending_amount')->comment('pending amount');
            $table->text('note', 65535)->comment('note regarding payment');
            $table->boolean('status')->comment('0 = unpaid, 1 = Paid, 2 = Partial, 3 = overpaid');
            $table->string('invoice_number', 50)->comment('number of the invoice/reciept');
            $table->string('discount_percent', 50);
            $table->string('discount_amount', 50);
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('FK_payments_users_3');
            $table->integer('updated_by')->unsigned()->index('FK_payments_users_4');
            $table->integer('tax');
            $table->integer('additional_fees')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}

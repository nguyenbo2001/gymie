<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id')->index('payment_details_invoice_id_foreign')->comment('link to unique record id of invoice');
            $table->integer('payment_amount')->comment('amount of transaction being done');
            $table->string('mode', 50)->comment('1 = Cash, 0 = Cheque');
            $table->string('node', 50)->comment('misc. note');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('payment_details_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('payment_details_updated_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
}

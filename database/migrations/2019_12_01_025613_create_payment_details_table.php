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
            $table->integer('id');
            $table->integer('invoice_id')->index('FK_payment_details_1')->comment('link to unique record id of invoice');
            $table->integer('payment_amount')->comment('amount of transaction being done');
            $table->string('mode', 50)->comment('1 = Cash, 0 = Cheque');
            $table->string('node', 50)->comment('misc. note');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('FK_payment_details_staff_2');
            $table->integer('updated_by')->unsigned()->index('FK_payment_details_staff_3');
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

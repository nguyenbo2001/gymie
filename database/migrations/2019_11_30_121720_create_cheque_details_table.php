<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('payment_id')->index('cheque_details_payment_id_foreign');
            $table->string('number', 50);
            $table->date('date');
            $table->boolean('status')->comment('0 = received, 1 = deposited, 2 = cleared, 3 = bouced');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('cheque_details_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('cheque_details_updated_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheque_details');
    }
}

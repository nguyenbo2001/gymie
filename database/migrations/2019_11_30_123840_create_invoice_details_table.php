<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoice_id')->index('invoice_details_invocie_id_foreign')->comment('link  to unique record id of invoice');
            $table->integer('item_amount')->comment('amount of the item');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('invoice_details_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('invoice_details_updated_by_foreign');
            $table->integer('plan_id')->default(1)->index('invoice_details_plan_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('member_id')->index('subscriptioins_member_id_foreign')->comment('links to unique record id of members');
            $table->integer('invoice_id')->index('subscriptions_invoice_id_foreign')->comment('links to unique record id of invoice');
            $table->integer('plan_id')->index('subscriptions_plan_id_foreign')->comment('links to unique record if of plans');
            $table->date('start_date')->comment('start date of subscriptioin');
            $table->date('end_date')->comment('end date of subscription');
            $table->boolean('status')->comment('0 = expired, 1 = ongoing, 2 = renewed, 3 = canceled');
            $table->boolean('is_renewal')->comment('0 = false, 1 = true');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('subscriptions_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('subscriptions_updated_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}

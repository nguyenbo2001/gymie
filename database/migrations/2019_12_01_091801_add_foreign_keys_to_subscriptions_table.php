<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreign('member_id')
                    ->references('id')->on('members')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id')
                    ->references('id')->on('plans')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id')
                    ->references('id')->on('invoice')
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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_member_id_foreign');
            $table->dropForeign('subscriptions_plan_id_foreign');
            $table->dropForeign('subscriptions_created_by_foreign');
            $table->dropForeign('subscriptions_updated_by_foreign');
            $table->dropForeign('subscriptions_invoice_id_foreign');
        });
    }
}

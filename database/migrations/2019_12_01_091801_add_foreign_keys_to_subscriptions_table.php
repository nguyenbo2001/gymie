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
            $table->foreign('member_id', 'FK_subscriptions_members_1')
                    ->references('id')->on('members')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id', 'FK_subscriptions_plans_2')
                    ->references('id')->on('plans')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_subscriptions_staff_3')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_subscriptions_staff_4')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('invoice_id', 'FK_subscriptions_invoice')
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
            $table->dropForeign('FK_subscriptions_members_1');
            $table->dropForeign('FK_subscriptions_plans_2');
            $table->dropForeign('FK_subscriptions_staff_3');
            $table->dropForeign('FK_subscriptions_staff_4');
            $table->dropForeign('FK_subscriptions_invoice');
        });
    }
}

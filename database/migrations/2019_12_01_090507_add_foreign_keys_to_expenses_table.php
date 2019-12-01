<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('category_id', 'FK_expenses_expenses_categories_1')
                    ->references('id')->on('expenses_categories')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by', 'FK_expenses_expenses_users_2')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by', 'FK_expenses_expenses_users_3')
                    ->references('id')->on('users')
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
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('FK_expenses_expenses_categories_1');
            $table->dropForeign('FK_expenses_users_2');
            $table->dropForeign('FK_expenses_users_3');
        });
    }
}

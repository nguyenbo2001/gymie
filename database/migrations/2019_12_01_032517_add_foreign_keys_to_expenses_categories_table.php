<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToExpensesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses_categories', function (Blueprint $table) {
            $table->foreign('created_by', 'FK_expenses_categories_users_1')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('No ACTION');
            $table->foreign('updated_by', 'FK_expenses_categories_users_2')
                    ->references('id')->on('users')
                    ->onUpdate('RESTRICT')->onDelete('No ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses_categories', function (Blueprint $table) {
            $table->dropForeign('FK_expenses_categories_users_1');
            $table->dropForeign('FK_expenses_categories_users_2');
        });
    }
}

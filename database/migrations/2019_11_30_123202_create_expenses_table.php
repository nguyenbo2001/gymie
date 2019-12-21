<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->integer('id', true)->comment('unique record id for system');
            $table->string('name', 50)->comment('name of the expenses');
            $table->integer('category_id')->index('expenses_category_id_foreign')->comment('name of the category of expenses');
            $table->integer('amount')->comment('expenses amount');
            $table->date('due_date')->comment('Due Date for the expenses created');
            $table->boolean('repeat')->comment('0 = never repeat, 1 = every day, 2 = every week, 3 = every month, 4 = every year');
            $table->boolean('paid')->comment('0 = false, 1 = true');
            $table->string('note', 50);
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('expenses_created_by_foreign');
            $table->integer('updated_by')->unsigned()->index('expenses_updated_by_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}

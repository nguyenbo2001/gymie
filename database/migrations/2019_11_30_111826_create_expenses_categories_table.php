<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_categories', function (Blueprint $table) {
            $table->integer('id')->comment('Unique Record Id for system');
            $table->string('name', 50)->comment('category name');
            $table->boolean('status');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->index('FK_expenses_categories_users_1');
            $table->integer('updated_by')->unsigned()->index('FK_expenses_categories_users_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_categories');
    }
}

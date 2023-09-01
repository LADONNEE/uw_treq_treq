<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedViewBudgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(sqlInclude(__DIR__ . '/../views/shared_view_budgets.sql', [
            '__DBSHARED__' => env('DB_DATABASE_SHARED', 'shared'),
            '__DBBUDGETS__' => env('DB_DATABASE_BUDGETS', 'budgets')
        ]));
    }

    public function down()
    {
        // there is no down
    }
}

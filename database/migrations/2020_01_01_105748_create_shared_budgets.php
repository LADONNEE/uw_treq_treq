<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Config;

class CreateSharedBudgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(sqlInclude(__DIR__ . '/../views/shared_view_budgets.sql', [
            '__DBSHARED__' => Config::get('app.database_shared'),
            '__DBBUDGETS__' => Config::get('app.database_budgets'),
        ]));
    }

    public function down()
    {
        // there is no down
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedViewWorktags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(sqlInclude(__DIR__ . '/../views/shared_view_worktags.sql', [
            '__DBSHARED__' => env('DB_DATABASE_SHARED', 'shared'),
            '__DBBUDGETS__' => env('DB_DATABASE_BUDGETS', 'budgets')
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

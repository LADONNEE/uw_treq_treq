<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedBudgetsBienniumSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(sqlInclude(__DIR__ . '/../views/shared_view_budgets_biennium_setting.sql'));
    }

    public function down()
    {
        // there is no down
    }
}

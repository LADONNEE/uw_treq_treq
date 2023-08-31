<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkdayBudgetsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            //
            $table->string('wd_costcenter', 102)->nullable();
            $table->string('wd_program', 102)->nullable();
            $table->string('wd_standalonegrant', 102)->nullable();
            $table->string('wd_grant', 102)->nullable();
            $table->string('wd_assignee', 102)->nullable();
            $table->string('wd_gift', 102)->nullable();
            $table->string('wd_fund', 102)->nullable();
            $table->string('wd_other', 102)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            //
            $table->dropColumn('wd_costcenter');
            $table->dropColumn('wd_program');
            $table->dropColumn('wd_standalonegrant');
            $table->dropColumn('wd_grant');
            $table->dropColumn('wd_assignee');
            $table->dropColumn('wd_gift');
            $table->dropColumn('wd_fund');
            $table->dropColumn('wd_other');
        });
    }
}

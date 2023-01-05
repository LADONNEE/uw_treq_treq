<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectCodeIdToBudgetsTable extends Migration
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
            $table->unsignedBigInteger('project_code_id')->nullable()->after('pca_code');

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
            $table->dropColumn('project_code_id');
        });
    }
}

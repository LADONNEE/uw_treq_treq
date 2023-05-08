<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLodgingMealsIntegersToDecimalsInPerdiemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perdiems', function (Blueprint $table) {
            //
            $table->decimal('meals', 13, 2)->nullable()->change(); 
            $table->decimal('meals_pd', 13, 2)->nullable()->change();
            $table->decimal('lodging_pd', 13, 2)->nullable()->change();

        });
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

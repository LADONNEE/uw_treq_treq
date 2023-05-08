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
            DB::statement('ALTER TABLE `perdiems` MODIFY `lodging_pd` DECIMAL(13, 2);');
            DB::statement('ALTER TABLE `perdiems` MODIFY `lodging` DECIMAL(13, 2);');
            DB::statement('ALTER TABLE `perdiems` MODIFY `meals_pd` DECIMAL(13, 2);');
            DB::statement('ALTER TABLE `perdiems` MODIFY `meals` DECIMAL(13, 2);');
            

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cr06ChangeNonUwTravelerStateSelectionInTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            //
            
            $table->string('nuwt_state_province', 255)->nullable()->change();
            $table->foreign('nuwt_state_province')
                ->references('name')->on('states')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            //
            $table->dropForeign('trips_nuwt_state_province_foreign');
            
        });
    }
}

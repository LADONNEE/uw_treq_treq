<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cr03AddMailAdressAndStatesForNonUwTravelersToTripsTable extends Migration
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
            $table->string('nuwt_address_line1', 300)->nullable();
            $table->string('nuwt_address_line2', 300)->nullable();
            $table->string('nuwt_city', 300)->nullable();
            $table->string('nuwt_state_province', 2)->nullable();
            $table->string('nuwt_zipcode', 10)->nullable();
            $table->string('nuwt_country', 300)->nullable();
            $table->string('state')->nullable();
            $table->foreign('state')
                ->references('name')->on('states')
                ->onDelete('cascade');
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
            $table->dropColumn('nuwt_address_line1');
            $table->dropColumn('nuwt_address_line2');
            $table->dropColumn('nuwt_city');
            $table->dropColumn('nuwt_state_province');
            $table->dropColumn('nuwt_zipcode');
            $table->dropColumn('nuwt_country');
            $table->dropForeign('trips_state_foreign');
            $table->dropColumn('state');
        });
    }
}

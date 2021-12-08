<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('destination', 200);
            $table->date('depart_at')->nullable();
            $table->date('return_at')->nullable();
            $table->string('traveler', 200);
            $table->unsignedBigInteger('person_id')->nullable();
            $table->string('traveler_title', 200)->nullable();
            $table->string('traveler_email', 200)->nullable();
            $table->string('traveler_phone', 200)->nullable();
            $table->boolean('non_uw')->default(0);
            $table->boolean('personal_time')->default(0);
            $table->string('personal_time_dates', 200)->nullable();
            $table->string('honorarium', 200)->nullable();
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')->on('projects')
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
        Schema::dropIfExists('trips');
    }
}

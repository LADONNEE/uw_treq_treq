<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrackingTable extends Migration
{
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('order_id');
            $table->string('last_action', 100);
            $table->string('last_actor', 100);
            $table->dateTime('last_at');
            $table->string('next_action', 100);
            $table->string('next_actors', 250)->nullable();
            $table->timestamps();
            $table->index('order_id');

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking');
    }
}

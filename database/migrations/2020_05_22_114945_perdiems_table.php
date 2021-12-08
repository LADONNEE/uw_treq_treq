<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerdiemsTable extends Migration
{
    public function up()
    {
        Schema::create('perdiems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedInteger('nights')->nullable();
            $table->unsignedInteger('lodging_pd')->nullable();
            $table->decimal('lodging', 13, 2)->nullable();
            $table->unsignedInteger('days')->nullable();
            $table->unsignedInteger('meals_pd')->nullable();
            $table->unsignedInteger('meals')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perdiems');
    }
}

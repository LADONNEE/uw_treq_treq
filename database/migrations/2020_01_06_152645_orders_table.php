<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->string('type', 50);
            $table->string('stage', 100);
            $table->dateTime('submitted_at')->nullable();
            $table->unsignedBigInteger('submitted_by');
            $table->decimal('amount', 13, 2)->nullable();
            $table->dateTime('active_at')->nullable();
            $table->dateTime('notified_at')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('on_call', 300)->nullable();
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('actions');
    }
}

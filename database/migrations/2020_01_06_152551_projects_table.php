<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->unsignedBigInteger('person_id');
            $table->text('purpose');
            $table->boolean('is_travel')->default(0);
            $table->boolean('is_food')->default(0);
            $table->boolean('is_gift_card')->default(0);
            $table->boolean('is_rsp')->default(0);
            $table->string('folder_url', 300)->nullable();
            $table->string('folder_name', 300)->nullable();
            $table->string('closed', 300)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

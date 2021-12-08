<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFoldersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('file_folders');
        Schema::dropIfExists('file_notes');

        Schema::create('user_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('url', 300);
            $table->string('name', 300);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_folders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectsChangeClosed extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('closed');
            $table->string('folder_deleted', 300)->nullable()->after('folder_name');
            $table->dateTime('closed_at')->nullable()->after('folder_deleted');
            $table->unsignedBigInteger('closed_by')->nullable()->after('closed_at');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectsAddClosed extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('projects', 'closed')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->string('closed', 300)->nullable()->after('folder_name');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('closed');
        });
    }
}

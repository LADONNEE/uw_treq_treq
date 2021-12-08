<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectsAddFolderName extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('projects', 'folder_name')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->string('folder_name', 300)->nullable()->after('is_gift_card');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('folder_name');
        });
    }
}

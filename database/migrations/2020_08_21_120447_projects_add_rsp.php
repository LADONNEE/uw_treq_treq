<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectsAddRsp extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('projects', 'is_rsp')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_rsp')->default(0)->after('is_gift_card');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('is_rsp');
        });
    }
}

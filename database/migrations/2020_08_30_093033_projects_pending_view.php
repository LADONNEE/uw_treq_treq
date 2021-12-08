<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsPendingView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW projects_pending_view AS
           SELECT DISTINCT project_id
           FROM orders
           WHERE stage NOT IN('Complete', 'Canceled')"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS projects_pending_view");
    }
}

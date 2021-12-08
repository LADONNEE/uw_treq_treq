<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsClosableView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW projects_closable_view AS
            SELECT p.id AS project_id
            FROM projects p
            LEFT OUTER JOIN projects_pending_view pp
              ON p.id = pp.project_id
            WHERE pp.project_id IS NULL"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS projects_closable_view");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsWithPreauthView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW projects_with_preauth_view AS
            SELECT DISTINCT project_id
            FROM orders
            WHERE type IN('pre-auth', 'travel-pre-auth')
            AND stage = 'Complete'"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW projects_with_preauth_view");
    }
}

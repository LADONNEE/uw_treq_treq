<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TasksPendingView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW tasks_pending_view AS
            SELECT
               t.id AS task_id
              ,t.assigned_to
              ,t.created_at
            FROM tasks t
            INNER JOIN orders o
              ON t.order_id = o.id
            WHERE t.assigned_to IS NOT NULL
              AND o.submitted_at IS NOT NULL
              AND o.stage NOT IN('Complete', 'Canceled')
              AND t.completed_at IS NULL"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS tasks_pending_view");
    }
}

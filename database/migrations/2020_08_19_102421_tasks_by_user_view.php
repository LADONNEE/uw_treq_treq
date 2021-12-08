<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TasksByUserView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW tasks_by_user_view AS
            SELECT
               assigned_to AS person_id
              ,COUNT(task_id) AS num_pending
              ,MIN(created_at) AS earliest_at
            FROM tasks_pending_view
            GROUP BY assigned_to"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS tasks_by_user_view");
    }
}

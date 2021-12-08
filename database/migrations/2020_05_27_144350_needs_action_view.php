<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NeedsActionView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW needs_action_view AS
             SELECT DISTINCT order_id, assigned_to
             FROM tasks
             WHERE completed_at IS NULL"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW needs_action_view");
    }
}

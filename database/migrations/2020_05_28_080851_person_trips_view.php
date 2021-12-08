<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PersonTripsView extends Migration
{
    public function up()
    {
        DB::statement(
            "CREATE OR REPLACE VIEW person_trips_view AS
            SELECT DISTINCT p.id AS project_id, o.submitted_by AS person_id, t.return_at
            FROM projects p
            JOIN orders o
            ON p.id = o.project_id
            JOIN trips t
            ON p.id = t.project_id
            WHERE p.is_travel = 1
            UNION
            SELECT p.id AS project_id, p.person_id, t.return_at
            FROM projects p
            JOIN trips t
            ON p.id = t.project_id
            WHERE p.is_travel = 1"
        );
    }

    public function down()
    {
        DB::statement("DROP VIEW needs_action_view");
    }
}

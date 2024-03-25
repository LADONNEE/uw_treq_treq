<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::unprepared(
            'DROP FUNCTION IF EXISTS `' . env('DB_DATABASE_SHARED', 'shared') . '`.getpath;'
        );

        DB::unprepared(
            'CREATE FUNCTION `' . env('DB_DATABASE_SHARED', 'shared') . '`.getpath(cat_id INT) RETURNS TEXT DETERMINISTIC
            BEGIN
                DECLARE res TEXT;
                CALL get_path(cat_id, res);
                RETURN res;
            END;'
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $procedure = "DROP FUNCTION IF EXISTS `' . env('DB_DATABASE_SHARED', 'shared') . '`.getpath;";
        DB::unprepared($procedure);

    }
};

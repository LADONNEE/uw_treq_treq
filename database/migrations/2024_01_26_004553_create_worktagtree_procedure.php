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
            'DROP PROCEDURE IF EXISTS `' . env('DB_DATABASE_SHARED', 'shared') . '`.`get_path`;'
        
        );

        DB::unprepared(
            'CREATE PROCEDURE `' . env('DB_DATABASE_SHARED', 'shared') . '`.`get_path` (IN cat_id INT, OUT path TEXT)
            BEGIN
                DECLARE catcode VARCHAR(255);
                DECLARE catdescription VARCHAR(255);
                DECLARE temppath TEXT;
                DECLARE tempparent INT;
                SET max_sp_recursion_depth = 2048;
            
                SELECT workday_code, name as worktag_name, cc_worktag_id FROM `' . env('DB_DATABASE_BUDGETS', 'budgets') . '`.worktags WHERE id=cat_id INTO catcode, catdescription, tempparent;
                IF tempparent IS NULL
                THEN
                    SET path = CONCAT( "a!/^/!a", catcode , "c!/^/!c : ", REPLACE(catdescription, catcode, "") );
                ELSE
                    CALL get_path(tempparent, temppath);
                    SET path = CONCAT(temppath, "b!/^/!b", catcode, "c!/^/!c : ", REPLACE(catdescription, catcode, "") );
                END IF;
            END;'
        
        );

        


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $procedure = "DROP PROCEDURE IF EXISTS `' . env('DB_DATABASE_SHARED', 'shared') . '`.`get_path`;";
        DB::unprepared($procedure);

    }
};

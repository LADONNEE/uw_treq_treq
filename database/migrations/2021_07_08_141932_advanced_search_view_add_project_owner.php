<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AdvancedSearchViewAddProjectOwner extends Migration
{
    public function up()
    {
        DB::statement(sqlInclude(__DIR__ . '/../views/advanced_search_view.sql',
                                    ['__DBSHARED__' => env('DB_DATABASE_SHARED', 'shared')],
                                ));

    }

    public function down()
    {
        // there is no down
    }
}

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
        DB::statement(sqlInclude(__DIR__ . '/../views/shared_view_worktagtree.sql', [
            '__DBSHARED__' => env('DB_DATABASE_SHARED', 'shared'),
            '__DBBUDGETS__' => env('DB_DATABASE_BUDGETS', 'budgets')
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};

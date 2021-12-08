<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersAddOnCall extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('orders', 'on_call')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('on_call', 300)->nullable()->after('assigned_to');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('on_call');
        });
    }
}

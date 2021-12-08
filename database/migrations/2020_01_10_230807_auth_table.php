<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuthTable extends Migration
{
    protected $initialUsers = [
        'hanisko' => 'treq:super',
        'mollyvin' => 'treq:super',
        'seribock' => 'treq:super',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->char('uwnetid', 8);
            $table->string('role', 50);
            $table->timestamps();
        });
        $this->fill();
    }

    public function fill()
    {
        foreach ($this->initialUsers as $uwnetid => $role) {
            \App\Models\Auth::firstOrCreate([
                'uwnetid' => $uwnetid,
                'role' => $role,
            ]);
        }
    }

    public function down()
    {
        Schema::drop('auth');
    }
}

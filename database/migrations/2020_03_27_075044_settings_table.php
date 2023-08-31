<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingsTable extends Migration
{
    protected $initialSettings = [
        'current-biennium' => '2021',
        'fiscal-contact-default' => 'nbedani',
    ];

    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('value', 100);
            $table->bigInteger('changed_by')->unsigned();
            $table->timestamps();
        });
        $this->fill();
    }

    public function fill()
    {
        foreach ($this->initialSettings as $name => $value) {
            $setting = \App\Models\Setting::firstOrNew([
                'name' => $name,
            ]);
            $setting->value = $value;
            $setting->changed_by = 15;
            $setting->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

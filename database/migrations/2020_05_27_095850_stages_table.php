<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StagesTable extends Migration
{
    private $data = [
        'Budget Approval' => 'budget',
        'Canceled' => null,
        'Creating' => null,
        'Department Approval' => 'department',
        'Enter in Ariba' => 'ariba',
        'Assign Fiscal Contact' => null,
        'Needs Approval' => 'approval',
        'Pending Task' => 'task',
        'Place Order' => 'order',
        'Re-Submitted' => 'resubmit',
        'Sent Back' => null,
        'Unassigned' => null,
    ];

    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('task_type', 50)->nullable();
            $table->timestamps();
        });
        $this->fill();
    }

    public function fill()
    {
        foreach ($this->data as $name => $task_type) {
            $s = \App\Models\Stage::firstOrNew(['name' => $name]);
            $s->task_type = $task_type;
            $s->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('stages');
    }
}

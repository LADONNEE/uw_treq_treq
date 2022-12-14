<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Config;

class UserTasksController extends Controller
{

    private $table;

    public function __construct() {
            $this->table = Config::get('app.database_shared'); 
    } 

    public function index()
    {
        $usersWithTasks = DB::table('tasks_by_user_view AS tv')
            ->join($this->table . '.uw_persons AS p', 'tv.person_id', '=', 'p.person_id')
            ->select([
                'tv.person_id',
                'tv.num_pending',
                'tv.earliest_at',
                'p.firstname',
                'p.lastname',
                'p.uwnetid',
            ])
            ->orderBy('num_pending', 'desc')
            ->get();

        return view('user-tasks.index', compact('usersWithTasks'));
    }

    public function show($uwnetid)
    {
        $person = $this->personByUwnetid($uwnetid);
        $fullName = "{$person->firstname} {$person->lastname}";

        $tasks = Task::select('tasks.*')
            ->join('tasks_pending_view', 'tasks.id', '=', 'tasks_pending_view.task_id')
            ->where('tasks_pending_view.assigned_to', $person->person_id)
            ->orderBy('created_at')
            ->with('order', 'order.project')
            ->get();

        return view('user-tasks.show', compact('person', 'fullName', 'tasks'));
    }

    private function personByUwnetid($uwnetid): Person
    {
        return Person::where('uwnetid', $uwnetid)->firstOrFail();
    }
}

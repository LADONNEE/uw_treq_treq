<?php

namespace App\Http\Controllers;

use App\Models\WorkflowManagement;
use Illuminate\Http\Request;

class WorkflowManagementController extends Controller
{
    public function index()
    {
        $help = WorkflowManagement::all();
        return view('help.index', compact('help'));
    }
    public function edit($id){
        $help = WorkflowManagement::where('id', $id)->first();
        return view('help.edit', compact('help'));
    }
    public function update(Request $request, $id){

        WorkflowManagement::where('id', $id)->update([
            'content' => $request->guidance
        ]);

        return redirect()->route('workflowmanagement-index');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getTasks(Request $request)
    {
        if(!auth()->user()->can('view_project')){
            abort(403 , 'Forbidden');
        }
        $project = Project::with('tasks.members')
        ->findOrFail($request->id);
        // return $project->tasks;
        return View::make('components.tasks' ,compact('project'))->render();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $task = Task::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);
        $task->members()->sync($request->members);
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ]);

        $task->members()->sync($request->members);

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $task = Task::findOrFail($id);

        $deleted = $task->delete();

        $task->members()->detach();

        if($deleted){
            $response['success'] = 1;
        }
        return response()->json($response);

    }
}

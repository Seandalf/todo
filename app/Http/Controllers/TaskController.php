<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        try {
            return successResponse(
                Task::whereProjectId($project->id)->get(),
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve tasks for project: {$project->id}");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        try {
            $task = Task::create([
                'project_id' => $project->id,

                ...$request->validated(),
            ]);

            return successResponse($task);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not create task for project: {$project->id}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return Inertia::render('Tasks/View', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        try {
            $task->update($request->validated());

            return successResponse($task);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update task: {$task->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        try {
            $task->delete();

            return successResponse($task);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not delete task: {$task->id}");
        }
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Assignee;
use App\Http\Requests\StoreAssigneeRequest;
use App\Http\Requests\UpdateAssigneeRequest;
use App\Models\Project;

class AssigneeController extends Controller
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
                Assignee::whereProjectId($project->id)
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve assignees for project: {$project->id}");
        }
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
     * @param  \App\Http\Requests\StoreAssigneeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssigneeRequest $request, Project $project)
    {
        try {
            $assignee = Assignee::create([
                'project_id' => $project->id,

                ...$request->validated(),
            ]);

            return successResponse($assignee);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve assignees for project: {$project->id}");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignee $assignee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssigneeRequest  $request
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssigneeRequest $request, Project $project, Assignee $assignee)
    {
        try {
            $assignee->update($request->validated());

            return successResponse($assignee);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update assignee: {$assignee->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignee  $assignee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Assignee $assignee)
    {
        try {
            $assignee->delete();

            return successResponse($assignee);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update assignee: {$assignee->id}");
        }
    }
}

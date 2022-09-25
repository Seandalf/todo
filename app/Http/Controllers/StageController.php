<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Stage;
use App\Models\Project;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use Inertia\Inertia;

class StageController extends Controller
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
                Stage::whereProjectId($project->id)
                     ->with('tasks', 'tasks.status', 'tasks.assignee')
                     ->get(),
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve stages for project: {$project->id}");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Stages/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStageRequest $request, Project $project)
    {
        try {
            $stage = Stage::create([
                'project_id' => $project->id,

                ...$request->validated(),
            ]);

            return successResponse($stage);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not create stage for project: {$project->id}");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function edit(Stage $stage)
    {
        return Inertia::render('Stages/Update', [
            'stage' => $stage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStageRequest  $request
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStageRequest $request, Project $project, Stage $stage)
    {
        try {
            $stage->update($request->validated());

            return successResponse($stage);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update stage: {$stage->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Stage $stage)
    {
        try {
            $stage->delete();

            return successResponse($stage);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not delete stage: {$stage->id}");
        }
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return successResponse(
                Project::whereUserId($this->user->id)->get()
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve projects for user: {$this->user->id}");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $project = Project::create([
                'user_id' => $this->user->id,

                ...$request->validated(),
            ]);

            return successResponse($project);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not create project for user: {$this->user->id}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return Inertia::render('Projects/View', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Update', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $project->update($request->validated());

            return successResponse($project);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update project: {$project->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return successResponse($project);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not delete project: {$project->id}");
        }
    }
}

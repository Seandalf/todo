<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Status;
use App\Models\Project;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use Inertia\Inertia;

class StatusController extends Controller
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
                Status::whereProjectId($project->id)->get(),
            );
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not retrieve statuses for project: {$project->id}");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Statuses/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request, Project $project)
    {
        try {
            $status = Status::create([
                'project_id' => $project->id,

                ...$request->validated(),
            ]);

            return successResponse($status);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not create status for project: {$project->id}");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        return Inertia::render('Statuses/Update', [
            'status' => $status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request, Project $project, Status $status)
    {
        try {
            $status->update($request->validated());

            return successResponse($status);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not update status: {$status->id}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Status $status)
    {
        try {
            $status->delete();

            return successResponse($status);
        } catch (Exception $e) {
            return errorResponse($e->getMessage(), "Could not delete status: {$status->id}");
        }
    }
}

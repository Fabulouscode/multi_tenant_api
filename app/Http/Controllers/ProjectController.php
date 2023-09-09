<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Tenant;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate();

        return $this->jsonResponse(HTTP_SUCCESS, 'Projects retrieved successfully ', ProjectResource::collection($projects));
    }

    public function store(ProjectRequest $request)
    {
        $validatedData = $request->validatedData();

        $project = Project::create([
            'uuid' => $validatedData['uuid'],
            'name' => $validatedData['name'],
            'tenant_id' => $request->user()->tenant_id,
        ]);

        return $this->jsonResponse(HTTP_CREATED, 'Project project successfully', $project);
    }

    public function show(Tenant $tenant, Project $project)
    {
        return $this->jsonResponse(HTTP_SUCCESS, 'Project retrieved successfully', new ProjectResource($project));
    }
}

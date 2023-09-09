<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Tenant;
use Illuminate\Http\Request;

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

    public function update(Request $request, Tenant $tenant, Project $project)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100', 'min:5', 'unique:projects'],
        ]);

        $project->update($validatedData);

        return $this->jsonResponse(HTTP_SUCCESS, 'Route updated successfully', new ProjectResource($project));
    }
}

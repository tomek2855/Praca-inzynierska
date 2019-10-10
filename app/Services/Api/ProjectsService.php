<?php

namespace App\Services\Api;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsService
{
    public function index(Request $request)
    {
        if ($request->has('q') && !empty($request->get('q')))
        {
            return Project::where('title', 'LIKE', '%' . $request->get('q') . '%')->paginate(15);
        }

        return Project::paginate(15);
    }

    public function store(Request $request)
    {
        return Project::create($request->all());
    }

    public function show($id)
    {
        return Project::with('issues')->findOrFail($id);
    }
}
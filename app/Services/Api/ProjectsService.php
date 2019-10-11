<?php

namespace App\Services\Api;

use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectsService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->has('q') && !empty($request->get('q')))
        {
            return Project::where('title', 'LIKE', '%' . $request->get('q') . '%')->paginate(15);
        }

        return Project::paginate(15);
    }

    /**
     * @param Request $request
     * @return Project|null
     */
    public function store(Request $request) : ?Project
    {
        return Project::create($request->all());
    }

    /**
     * @param int $id
     * @return Project|null
     */
    public function show(int $id) : ?Project
    {
        try
        {
            $project = Project::findOrFail($id);

            return $project;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Project|null
     */
    public function update(Request $request, int $id) : ?Project
    {
        try
        {
            $project = Project::findOrFail($id);
            $project->update($request->all());

            return $project;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param int $id
     * @return int
     */
    public function destroy(int $id) : int
    {
        return Project::destroy($id);
    }
}
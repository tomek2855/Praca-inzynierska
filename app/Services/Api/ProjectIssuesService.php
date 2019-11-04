<?php

namespace App\Services\Api;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectIssuesService
{
    /**
     * @param Request $request
     * @param int $projectId
     * @return mixed
     */
    public function index(Request $request, int $projectId)
    {
        try
        {
            if ($request->has('q') && !empty($request->get('q')))
            {
                return Project::findOrFail($projectId)->issues()->where('title', 'LIKE', '%' . $request->get('q') . '%')->paginate(15);
            }

            return Project::findOrFail($projectId)->issues()->paginate(15);
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $projectId
     * @return Issue|null
     */
    public function store(Request $request, int $projectId) : ?Issue
    {
        try
        {
            $project = Project::findOrFail($projectId);

            return $project->issues()->create($request->all());
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param int $projectId
     * @param int $issueId
     * @return Issue|null
     */
    public function show(int $projectId, int $issueId) : ?Issue
    {
        try
        {
            $issue = Issue::where('project_id', $projectId)->where('id', $issueId)->firstOrFail();

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $projectId
     * @param int $issueId
     * @return Project|null
     */
    public function update(Request $request, int $projectId, int $issueId) : ?Issue
    {
        try
        {
            $issue = Issue::where('project_id', $projectId)->where('id', $issueId)->firstOrFail();
            $issue->update($request->all());

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }
}
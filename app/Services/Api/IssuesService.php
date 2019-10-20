<?php

namespace App\Services\Api;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssuesService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function showUserIssues(Request $request)
    {
        $projects = Auth::user()->projects()->select('id')->get()->pluck('id')->toArray();

        if ($request->has('q') && !empty($request->get('q')))
        {
            return Issue::whereIn('project_id', $projects)->where('title', 'LIKE', '%' . $request->get('q') . '%')->orderBy('project_id')->paginate(15);
        }

        return Issue::whereIn('project_id', $projects)->orderBy('project_id')->paginate(15);
    }

    /**
     * @param int $id
     * @return Issue|null
     */
    public function show(int $id) : ?Issue
    {
        try
        {
            $issue = Issue::findOrFail($id);

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Issue|null
     */
    public function update(Request $request, int $id) : ?Issue
    {
        try
        {
            $issue = Issue::findOrFail($id);
            $issue->update($request->all());

            return $issue;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }
}
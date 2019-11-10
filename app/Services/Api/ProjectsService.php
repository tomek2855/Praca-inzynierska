<?php

namespace App\Services\Api;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
            $project = Project::with('users')->findOrFail($id);

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
            $project->update($request->only(['title', 'content']));

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

    /**
     * @param int $id
     * @return Collection|null
     */
    public function userList(int $id) : ?Collection
    {
        try
        {
            $project = Project::findOrFail($id);

            $usersList = UserProjectRoleResolver::projectUsersList($project);

            return $usersList;
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public function getAssignedUsers(int $id) : ?Collection
    {
        try
        {
            $project = Project::findOrFail($id);

            $excludedUsers = UserProjectRoleResolver::projectUsersList($project)->pluck('id')->toArray();

            return User::whereNotIn('id', $excludedUsers)->get();
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return ProjectUser|null
     */
    public function addAssignedUser(Request $request, int $id) : ?ProjectUser
    {
        try
        {
            $project = Project::findOrFail($id);

            return ProjectUser::firstOrCreate([
                'project_id' => $project->id,
                'user_id' => $request->get('userId'),
                'role' => $request->get('role'),
            ]);
        }
        catch (ModelNotFoundException $e)
        {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return int
     */
    public function deleteAssignedUser(Request $request, int $id) : int
    {
        try
        {
            $project = Project::findOrFail($id);

            return ProjectUser::where('project_id', $project->id)->where('user_id', $request->get('userId'))->delete() > 0;
        }
        catch (\Exception $e)
        {
            return 0;
        }
    }
}
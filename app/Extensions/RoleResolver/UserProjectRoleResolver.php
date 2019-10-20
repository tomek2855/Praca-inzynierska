<?php

namespace App\Extensions\RoleResolver;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Collection;

class UserProjectRoleResolver
{
    const USER_CAN_CREATE_PROJECT = 0;
    const USER_CAN_EDIT_PROJECT = 1;
    const USER_CAN_DELETE_PROJECT = 2;

    const USER_CAN_CREATE_ISSUE = 3;
    const USER_CAN_EDIT_ISSUE = 4;
    const USER_CAN_DELETE_ISSUE = 5;

    const USER_CAN_ADD_COMMENT = 6;
    const USER_CAN_EDIT_COMMENT = 7;
    const USER_CAN_DELETE_COMMENT = 8;

    public static function userHasAccessTo(User $user, ?Project $project, int $role) : bool
    {
        $projectUser = null;
        if ($project)
        {
            $projectUser = ProjectUser::where('user_id', $user->id)->where('project_id', $project->id)->first();
        }

        switch ($role)
        {
            case self::USER_CAN_CREATE_PROJECT:
                return $user->isAdmin();
            case self::USER_CAN_EDIT_PROJECT:
            case self::USER_CAN_DELETE_PROJECT:
                return $projectUser && in_array($projectUser->role, [
                        ProjectUser::PROJECT_OWNER,
                        ProjectUser::PROJECT_MODERATOR,
                    ]);
            default: return true;
        }
    }

    /**
     * @param Project $project
     * @return Collection
     */
    public static function projectUsersList(Project $project) : Collection
    {
        $users = ProjectUser::where('project_id', $project->id)->whereIn('role', [
            ProjectUser::PROJECT_OWNER,
            ProjectUser::PROJECT_MODERATOR,
            ProjectUser::PROJECT_USER,
        ])->with('user')->get()->pluck('user');

        return $users;
    }
}
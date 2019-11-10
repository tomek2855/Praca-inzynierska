<?php

namespace App\Http\Requests\Project;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteProjectRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $project = Project::findOrFail($this->route('project'));
        return Auth::user()
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $project, UserProjectRoleResolver::USER_CAN_DELETE_PROJECT);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

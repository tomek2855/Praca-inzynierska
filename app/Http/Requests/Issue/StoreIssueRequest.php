<?php

namespace App\Http\Requests\Issue;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreIssueRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $project = Project::findOrFail($this->route('projectId'));
        return Auth::user()
            && $project
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $project, UserProjectRoleResolver::USER_CAN_CREATE_ISSUE);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string|min:5',
        ];
    }
}

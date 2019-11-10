<?php

namespace App\Http\Requests\Project;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddUserToProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::findOrFail($this->route('projectId'));
        return Auth::user()
            && $project
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $project, UserProjectRoleResolver::USER_CAN_EDIT_PROJECT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => 'required|exists:users,id',
            'role' => 'required|in:PROJECT_MODERATOR,PROJECT_USER,PROJECT_READER',
        ];
    }

    public function messages()
    {
        return [
            'userId.required' => 'Pole użytkownik jest wymagane',
            'role.required' => 'Pole rola jest wymagane',
        ];
    }
}

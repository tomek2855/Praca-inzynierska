<?php

namespace App\Http\Requests\Project;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteUserToProjectRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'userId.required' => 'Pole użytkownik jest wymagane',
        ];
    }
}

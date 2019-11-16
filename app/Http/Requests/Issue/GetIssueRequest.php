<?php

namespace App\Http\Requests\Issue;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class GetIssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::find($this->route('projectId'));

        if (!$project)
        {
            $project = Issue::findOrFail($this->route('issue') ?? $this->route('issueId'))->project;
        }

        return $this->user() && $project && UserProjectRoleResolver::userHasAccessTo($this->user(), $project, UserProjectRoleResolver::USER_CAN_SEE_PROJECT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}

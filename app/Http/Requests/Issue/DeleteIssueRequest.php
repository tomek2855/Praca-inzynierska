<?php

namespace App\Http\Requests\Issue;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteIssueRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $issue = Issue::findOrFail($this->route('issue'));
        return Auth::user()
            && $issue
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $issue, UserProjectRoleResolver::USER_CAN_DELETE_ISSUE);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

<?php

namespace App\Http\Requests\Issue;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateIssueRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $issue = Issue::findOrFail($this->route('issue'));
        return Auth::user()
            && $issue
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $issue, UserProjectRoleResolver::USER_CAN_EDIT_ISSUE);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'content' => 'required|string|min:5',
        ];
    }

    public function messages()
    {
        return [
            'title.min' => 'Nazwa zadania musi mieć co najmniej 5 znaków',
            'title.required' => 'Nazwa zadania jest wymagana',
            'content.min' => 'Opis musi mieć co najmniej 5 znaków',
            'content.required' => 'Opis jest wymagany',
        ];
    }
}

<?php

namespace App\Http\Requests\Comment;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $issue = Issue::findOrFail($this->route('issueId'));
        return Auth::user()
            && $issue
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $issue, UserProjectRoleResolver::USER_CAN_ADD_COMMENT);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|min:5|max:10000',
            'file_id' => 'nullable|exists:files,id',
        ];
    }

    public function messages()
    {
        return [
            'content.min' => 'Treść komentarza musi mieć co najmniej 5 znaków',
            'content.required' => 'Treść komentarza jest wymagana',
        ];
    }
}

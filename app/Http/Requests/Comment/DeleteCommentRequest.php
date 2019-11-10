<?php

namespace App\Http\Requests\Comment;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteCommentRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $comment = Comment::findOrFail($this->route('comment'));
        return Auth::user()
            && $comment
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $comment, UserProjectRoleResolver::USER_CAN_DELETE_COMMENT);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

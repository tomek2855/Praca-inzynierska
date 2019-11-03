<?php

namespace App\Http\Requests\Comment;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCommentRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        $comment = Comment::findOrFail($this->route('comment'));
        return Auth::user()
            && $comment
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), $comment, UserProjectRoleResolver::USER_CAN_EDIT_COMMENT);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|min:5',
            'file_id' => 'nullable|exists:files,id',
        ];
    }

    public function messages()
    {
        return [
            'content.min' => 'Treść komentarza musi mieć co najmniej 5 znaków',
        ];
    }
}

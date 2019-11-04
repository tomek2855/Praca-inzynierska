<?php

namespace App\Http\Requests\Project;

use App\Extensions\RoleResolver\UserProjectRoleResolver;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()
            && UserProjectRoleResolver::userHasAccessTo(Auth::user(), null, UserProjectRoleResolver::USER_CAN_CREATE_PROJECT);
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

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.min' => 'Nazwa projektu musi mieć co najmniej 5 znaków',
            'title.required' => 'Nazwa projektu jest wymagana',
            'content.min' => 'Opis projektu musi mieć co najmniej 5 znaków',
            'content.required' => 'Opis projektu jest wymagany',
        ];
    }
}

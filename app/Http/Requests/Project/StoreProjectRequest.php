<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjectRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() && Auth::user()->isAdmin();
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

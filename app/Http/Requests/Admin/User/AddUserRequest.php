<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddUserRequest extends FormRequest
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
            'name' => 'required|string|min:5|unique:users,name,' . $this->route('user'),
            'first_name' => 'required|string|min:5',
            'last_name' => 'required|string|min:5',
            'is_admin' => 'nullable',
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Login jest wymagany',
            'first_name.required' => 'Imię jest wymagane',
            'last_name.required' => 'Nazwisko jest wymagane',
            'email.required' => 'Email jest wymagany',
            'name.min' => 'Login wymaga conajmniej 5 znaków',
            'first_name.min' => 'Imię wymaga conajmniej 5 znaków',
            'last_name.min' => 'Nazwisko wymaga conajmniej 5 znaków',
            'email.min' => 'Email wymaga conajmniej 5 znaków',
            'email.email' => 'Podany email jest zły',
            'name.unique' => 'Ten login jest już zajęty',
            'email.unique' => 'Ten email jest już zajęty',
        ];
    }
}

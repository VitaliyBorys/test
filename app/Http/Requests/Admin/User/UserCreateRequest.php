<?php

namespace App\Http\Requests\Admin\User;

use App\Rules\PasswordCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'birthday' => 'date',
            'bio' => 'max:3000',
            'gender' => 'required',
            'lastname' => 'max:255',
            'name' => 'required|max:255',
            'phone' => 'max:255',
            'email' => ['required', 'min:1', 'max:255', 'email', Rule::unique('users', 'unique:uses')],
            'password' => 'required|min:6|max:255|confirmed',
            'card' => 'unique:users|required'
        ];

        if ($this->method() == 'PUT') {
            array_pop($rules['email']);
            $rules['email'][] = Rule::unique('users')->ignore(request()->input('id'), 'id');
            $rules['card'][] = Rule::unique('users')->ignore(request()->input('id'), 'id');
            $rules['password'] = 'min:6|max:255|confirmed';
        }

        return $rules;
    }
}

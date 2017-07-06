<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->id) {
            return [
                'username' => 'sometimes|alpha_dash|required|max:20',
                'nickname' => 'sometimes|required|max:20',
                'email' => 'sometimes|required|email|unique:users,email,' . $this->id,
                'password' => 'nullable|min:6|max:20|confirmed',
                'password_confirmation' => 'required_with:password',
            ];
        } else {
            return [
                'username' => 'required|alpha_dash|max:20',
                'nickname' => 'required|max:20',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required_with:password',
            ];
        }
    }

    public function performUpdate()
    {

    }
}

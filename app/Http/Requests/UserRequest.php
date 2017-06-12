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
                'name' => 'sometimes|required|max:20',
                'email' => 'email|unique:users,email,' . $this->id,
                'password' => 'nullable|min:6|max:20|confirmed',
                'password_confirmation' => 'required_with:password',
            ];
        } else {
            return [
                'name' => 'required|max:20',
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

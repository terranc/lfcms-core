<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentModelRequest extends FormRequest
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
                'name' => 'sometimes|required|alpha_dash|max:12|unique:document_models,name,' . $this->id,
                'title' => 'sometimes|required|max:50',
            ];
        } else {
            return [
                'name' => 'required|alpha_dash|max:12|unique:document_models,name',
                'title' => 'required|max:50',
            ];
        }
    }
}

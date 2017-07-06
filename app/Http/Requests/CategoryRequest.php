<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'title' => ['sometimes','required','max:100'],
                'type' => 'sometimes|required|in:link,page,list',
                'flag' => 'sometimes|required|alpha_dash|max:20|unique:categories,flag,' . $this->id,
                'description' => 'max:255',
            ];
        } else {
            return [
                'title' => ['required','max:100'],
                'type' => 'required|in:link,page,list',
                'thumb' => 'image',
                'flag' => 'required|alpha_dash|max:20|unique:categories,flag,',
                'description' => 'max:255',
            ];
        }
    }

    public function attributes() {
        return [
            'title' => '分类名称',
            'flag' => '标识',
            'type' => '类型',
            'thumb' => '缩略图',
        ];
    }
}

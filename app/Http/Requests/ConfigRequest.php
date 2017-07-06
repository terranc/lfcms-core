<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfigRequest extends FormRequest
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
                'name' => [
                    'sometimes',
                    'required',
                    'alpha_dash',
                    'max:30',
                    Rule::unique('configs')->ignore($this->id)->where(function($query){
                        $query->where('namespace', $this->namespace);
                    }),
                ],
                'type' => 'sometimes|required|in:string,enum,array,json',
                'namespace' => 'sometimes|required|alpha_dash|max:15',
                'value' => 'sometimes|required',
            ];
        } else {
            return [
                'name' => [
                    'required',
                    'alpha_dash',
                    'max:30',
                    Rule::unique('configs')->where(function($query){
                        $query->where('namespace', $this->namespace);
                    }),
                ],
                'type' => 'required|in:string,enum,array,json',
                'namespace' => 'required|alpha_dash|max:15',
                'value' => 'required',
            ];
        }
    }

    public function attributes() {
        return [
            'namespace' => '命名空间',
            'name' => '配置名称',
            'type' => '类型',
        ];
    }
}

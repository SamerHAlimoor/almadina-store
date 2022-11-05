<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{




    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('category');
        return [
            'name' => [
                'required', 'string', 'min:4', 'max:255', 'unique:categories,name,' . $id,
                //  Rule::unique('categories', 'name')->ignore($id)
            ],
            'parent_id' => 'nullable', 'int|exists:categories,id',
            'image' => [
                'image',
                //mimes:png,
                'max:1048000', //1 mega
                'dimensions:min_width=100,min_height=100',

            ],
            'status' => 'in:active,inactive' // enum
        ];
    }


    public function messages()
    {
        return [
            'required' => 'This :attribute is Require',
            //'name.required' => 'This :attribute is Require', // for specific field
            'unique' => 'This :attribute must be Unique',
        ];
    }
}
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool //do all validation part
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array //here your input field validation
    {
        $rules= [
            'name' =>['required','string','max:200'],
            'slug' =>['required','string','max:200'],
            'description' =>['required'],
            // 'image' =>['required','image'],
            'image' =>['nullable','mimes:jpeg,jpg,png'],
            'meta_title' =>['required','string','max:200'],
            'meta_description' =>['required','string'],
            'meta_keyword' =>['required','string'],
            'navbar_status' =>['nullable'],
            'status' =>['nullable'],
        ];
        return $rules;
    }
}
